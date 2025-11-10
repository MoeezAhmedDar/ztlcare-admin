<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\InterviewQuestion;
use App\Models\InterviewSection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class InterviewController extends Controller
{
    private array $statusOptions = [
        'draft' => 'Draft',
        'in_review' => 'In Review',
        'completed' => 'Completed',
    ];

    private array $outcomeOptions = [
        'pending' => 'Pending',
        'offer' => 'Offer',
        'reject' => 'Reject',
    ];

    public function index()
    {
        $interviews = Interview::query()
            ->latest('interview_date')
            ->latest()
            ->paginate(15);

        return view('interviews.index', [
            'interviews' => $interviews,
            'statusOptions' => $this->statusOptions,
            'outcomeOptions' => $this->outcomeOptions,
        ]);
    }

    public function create()
    {
        $sections = InterviewSection::with(['questions' => function ($query) {
            $query->orderBy('display_order');
        }])->orderBy('display_order')->get();

        return view('interviews.create', [
            'interview' => new Interview([
                'status' => 'draft',
                'outcome' => 'pending',
            ]),
            'sections' => $sections,
            'statusOptions' => $this->statusOptions,
            'outcomeOptions' => $this->outcomeOptions,
            'responses' => collect(),
            'statusHistory' => collect(),
        ]);
    }

    public function store(Request $request)
    {
        [$inputs, $answers, $scores, $statusComment, $questions] = $this->validatePayload($request);

        return DB::transaction(function () use ($inputs, $statusComment) {
            // Don't set total_score on creation - it will be calculated after candidate submits
            $inputs['total_score'] = 0;
            
            $interview = Interview::create($inputs);

            // Don't sync responses on creation - candidate will fill the questionnaire via public link
            // $this->syncResponses($interview, $questions, $answers, $scores);

            if ($statusComment || $interview->status) {
                $interview->statusHistories()->create([
                    'status' => $interview->status,
                    'comment' => $statusComment,
                ]);
            }

            return redirect()
                ->route('interviews.show', $interview)
                ->with('status', 'Interview created successfully. Share the public link with the candidate to complete the questionnaire.');
        });
    }

    public function show(Interview $interview)
    {
        $interview->load([
            'responses.question.section' => function ($query) {
                $query->orderBy('display_order');
            },
            'statusHistories' => function ($query) {
                $query->latest();
            },
        ]);

        $sections = InterviewSection::with(['questions' => function ($query) {
            $query->orderBy('display_order');
        }])->orderBy('display_order')->get();

        $responses = $interview->responses->keyBy('question_id');
        
        return view('interviews.show', [
            'interview' => $interview,
            'sections' => $sections,
            'responses' => $responses,
            'statusOptions' => $this->statusOptions,
            'outcomeOptions' => $this->outcomeOptions,
        ]);
    }

    public function edit(Interview $interview)
    {
        $interview->load('responses', 'statusHistories');

        $sections = InterviewSection::with(['questions' => function ($query) {
            $query->orderBy('display_order');
        }])->orderBy('display_order')->get();

        $responses = $interview->responses->keyBy('question_id');

        return view('interviews.edit', [
            'interview' => $interview,
            'sections' => $sections,
            'responses' => $responses,
            'statusOptions' => $this->statusOptions,
            'outcomeOptions' => $this->outcomeOptions,
            'statusHistory' => $interview->statusHistories,
        ]);
    }

    public function update(Request $request, Interview $interview)
    {
        [$inputs, $answers, $scores, $statusComment, $questions] = $this->validatePayload($request, $interview->id);

        return DB::transaction(function () use ($interview, $inputs, $answers, $scores, $statusComment, $questions) {
            $previousStatus = $interview->status;

            $interview->update($inputs);

            $this->syncResponses($interview, $questions, $answers, $scores);

            if ($statusComment || $previousStatus !== $interview->status) {
                $interview->statusHistories()->create([
                    'status' => $interview->status,
                    'comment' => $statusComment,
                ]);
            }

            return redirect()
                ->route('interviews.show', $interview)
                ->with('status', 'Interview updated successfully.');
        });
    }

    public function destroy(Interview $interview)
    {
        $interview->delete();

        return redirect()
            ->route('interviews.index')
            ->with('status', 'Interview removed.');
    }

    public function exportPdf(Interview $interview)
    {
        $interview->load([
            'responses.question.section' => function ($query) {
                $query->orderBy('display_order');
            },
            'statusHistories' => function ($query) {
                $query->latest();
            },
        ]);

        $sections = InterviewSection::with(['questions' => function ($query) {
            $query->orderBy('display_order');
        }])->orderBy('display_order')->get();

        $responses = $interview->responses->keyBy('question_id');

        $pdf = Pdf::loadView('interviews.pdf', [
            'interview' => $interview,
            'sections' => $sections,
            'responses' => $responses,
        ]);

        $filename = 'interview-' . $interview->candidate_name . '-' . $interview->id . '.pdf';
        $filename = preg_replace('/[^A-Za-z0-9\-_.]/', '-', $filename);

        return $pdf->download($filename);
    }

    protected function validatePayload(Request $request, ?int $interviewId = null): array
    {
        $data = $request->validate([
            'recruiter_name' => 'nullable|string|max:255',
            'interview_date' => 'nullable|date',
            'candidate_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'outcome' => ['required', 'string', Rule::in(array_keys($this->outcomeOptions))],
            'status' => ['required', 'string', Rule::in(array_keys($this->statusOptions))],
            'notes' => 'nullable|string',
            'overall_feedback' => 'nullable|string',
            'position_offered' => 'nullable|string|max:255',
            'recruitment_authorization' => 'nullable|string|max:255',
            'interviewer_signature_name' => 'nullable|string|max:255',
            'interviewer_signed_at' => 'nullable|date',
            'status_comment' => 'nullable|string',
            'answers' => 'nullable|array',
            'answers.*' => 'nullable|string',
            'scores' => 'nullable|array',
            'scores.*' => 'nullable|integer|min:0|max:3',
        ]);

        $questions = InterviewQuestion::query()
            ->orderBy('display_order')
            ->get()
            ->keyBy('id');

        $answers = $data['answers'] ?? [];
        $scores = $data['scores'] ?? [];
        $statusComment = $data['status_comment'] ?? null;

        unset($data['answers'], $data['scores'], $data['status_comment']);

        if (!empty($data['interviewer_signed_at'])) {
            $data['interviewer_signed_at'] = Carbon::parse($data['interviewer_signed_at']);
        }

        $data['total_score'] = $this->calculateTotalScore($scores, $questions);

        return [$data, $answers, $scores, $statusComment, $questions];
    }

    private function syncResponses(Interview $interview, Collection $questions, array $answers, array $scores): void
    {
        $existing = $interview->responses()->whereIn('question_id', $questions->keys())->get()->keyBy('question_id');

        foreach ($questions as $questionId => $question) {
            $answer = $this->normalizeAnswer(Arr::get($answers, (string) $questionId));
            $scoreInput = Arr::get($scores, (string) $questionId);
            $score = ($scoreInput === '' || $scoreInput === null) ? null : (int) $scoreInput;

            if (!$question->has_score) {
                $score = null;
            }

            // If interview questionnaire is complete (candidate has submitted), only update scores
            if ($interview->is_questionnaire_complete && $existing->has($questionId)) {
                // Update only the score, keep the candidate's answer
                $existingResponse = $existing[$questionId];
                if ($score !== null || $question->has_score) {
                    $existingResponse->update(['score' => $score]);
                }
                continue;
            }

            // For new interviews or if response doesn't exist yet
            if ($answer === null && $score === null) {
                if ($existing->has($questionId)) {
                    $existing[$questionId]->delete();
                }
                continue;
            }

            $interview->responses()->updateOrCreate(
                ['question_id' => $questionId],
                ['answer' => $answer, 'score' => $score]
            );
        }
    }

    private function calculateTotalScore(array $scores, Collection $questions): int
    {
        $total = 0;

        foreach ($scores as $questionId => $value) {
            if ($value === '' || $value === null) {
                continue;
            }

            $question = $questions->get((int) $questionId);

            if ($question && $question->has_score) {
                $total += (int) $value;
            }
        }

        return $total;
    }

    private function normalizeAnswer($value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            $trimmed = trim($value);
            return $trimmed === '' ? null : $trimmed;
        }

        return $value;
    }
}
