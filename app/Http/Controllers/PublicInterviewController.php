<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\InterviewQuestion;
use App\Models\InterviewSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicInterviewController extends Controller
{
    public function show($token)
    {
        $interview = Interview::where('public_token', $token)->firstOrFail();

        // If already submitted, show completion message
        if ($interview->is_questionnaire_complete) {
            return view('public-interview.completed', compact('interview'));
        }

        $sections = InterviewSection::with(['questions' => function ($query) {
            $query->orderBy('display_order');
        }])->orderBy('display_order')->get();

        // Get any existing responses (in case they're continuing)
        $responses = $interview->responses->keyBy('question_id');

        return view('public-interview.form', compact('interview', 'sections', 'responses'));
    }

    public function submit(Request $request, $token)
    {
        $interview = Interview::where('public_token', $token)->firstOrFail();

        // Prevent resubmission
        if ($interview->is_questionnaire_complete) {
            return redirect()->route('interview.public.completed', $token)
                ->with('error', 'This questionnaire has already been submitted.');
        }

        $validated = $request->validate([
            'answers' => 'nullable|array',
            'answers.*' => 'nullable|string',
        ]);

        $questions = InterviewQuestion::query()
            ->orderBy('display_order')
            ->get()
            ->keyBy('id');

        $answers = $validated['answers'] ?? [];

        DB::transaction(function () use ($interview, $questions, $answers) {
            // Delete existing responses
            $interview->responses()->delete();

            // Save new responses (without scores - interviewer will add those later)
            foreach ($questions as $questionId => $question) {
                $answer = $answers[$questionId] ?? null;

                if ($answer !== null && $answer !== '') {
                    $interview->responses()->create([
                        'question_id' => $questionId,
                        'answer' => $answer,
                        'score' => null, // Scores will be added by interviewer later
                    ]);
                }
            }

            // Don't calculate total score yet - interviewer will score later
            $totalScore = 0;

            // Mark as complete
            $interview->update([
                'is_questionnaire_complete' => true,
                'questionnaire_submitted_at' => now(),
                'total_score' => $totalScore,
            ]);
        });

        return redirect()->route('interview.public.completed', $token);
    }

    public function completed($token)
    {
        $interview = Interview::where('public_token', $token)->firstOrFail();

        return view('public-interview.completed', compact('interview'));
    }
}
