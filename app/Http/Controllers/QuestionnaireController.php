<?php

namespace App\Http\Controllers;

use App\Models\InterviewSection;
use App\Models\InterviewQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class QuestionnaireController extends Controller
{
    // Section Management
    public function sections()
    {
        $sections = InterviewSection::withCount('questions')
            ->orderBy('display_order')
            ->get();

        return view('questionnaire.sections.index', compact('sections'));
    }

    public function createSection()
    {
        return view('questionnaire.sections.create');
    }

    public function storeSection(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'display_order' => 'nullable|integer|min:0',
        ]);

        if (empty($validated['display_order'])) {
            $validated['display_order'] = (InterviewSection::max('display_order') ?? 0) + 1;
        }

        InterviewSection::create($validated);

        return redirect()
            ->route('questionnaire.sections')
            ->with('status', 'Section created successfully.');
    }

    public function editSection(InterviewSection $section)
    {
        return view('questionnaire.sections.edit', compact('section'));
    }

    public function updateSection(Request $request, InterviewSection $section)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'display_order' => 'required|integer|min:0',
        ]);

        $section->update($validated);

        return redirect()
            ->route('questionnaire.sections')
            ->with('status', 'Section updated successfully.');
    }

    public function destroySection(InterviewSection $section)
    {
        $questionsCount = $section->questions()->count();

        if ($questionsCount > 0) {
            return redirect()
                ->back()
                ->with('error', "Cannot delete section with {$questionsCount} questions. Delete questions first.");
        }

        $section->delete();

        return redirect()
            ->route('questionnaire.sections')
            ->with('status', 'Section deleted successfully.');
    }

    // Question Management
    public function questions(InterviewSection $section)
    {
        $section->load(['questions' => function ($query) {
            $query->orderBy('display_order');
        }]);

        return view('questionnaire.questions.index', compact('section'));
    }

    public function createQuestion(InterviewSection $section)
    {
        return view('questionnaire.questions.create', compact('section'));
    }

    public function storeQuestion(Request $request, InterviewSection $section)
    {
        $validated = $request->validate([
            'prompt' => 'required|string',
            'input_type' => ['required', Rule::in(['text', 'textarea', 'select', 'radio', 'checkbox'])],
            'options' => 'nullable|string',
            'has_score' => 'nullable|boolean',
            'help_text' => 'nullable|string',
            'display_order' => 'nullable|integer|min:0',
        ]);

        $validated['section_id'] = $section->id;
        $validated['has_score'] = $request->has('has_score') ? true : false;

        if (empty($validated['display_order'])) {
            $validated['display_order'] = ($section->questions()->max('display_order') ?? 0) + 1;
        }

        // Convert options string to array
        if (!empty($validated['options'])) {
            $options = array_filter(array_map('trim', explode(',', $validated['options'])));
            $validated['options'] = $options;
        } else {
            $validated['options'] = null;
        }

        InterviewQuestion::create($validated);

        return redirect()
            ->route('questionnaire.questions', $section)
            ->with('status', 'Question created successfully.');
    }

    public function editQuestion(InterviewSection $section, InterviewQuestion $question)
    {
        if ($question->section_id !== $section->id) {
            abort(404);
        }

        return view('questionnaire.questions.edit', compact('section', 'question'));
    }

    public function updateQuestion(Request $request, InterviewSection $section, InterviewQuestion $question)
    {
        if ($question->section_id !== $section->id) {
            abort(404);
        }

        $validated = $request->validate([
            'prompt' => 'required|string',
            'input_type' => ['required', Rule::in(['text', 'textarea', 'select', 'radio', 'checkbox'])],
            'options' => 'nullable|string',
            'has_score' => 'nullable|boolean',
            'help_text' => 'nullable|string',
            'display_order' => 'required|integer|min:0',
        ]);

        $validated['has_score'] = $request->has('has_score') ? true : false;

        // Convert options string to array
        if (!empty($validated['options'])) {
            $options = array_filter(array_map('trim', explode(',', $validated['options'])));
            $validated['options'] = $options;
        } else {
            $validated['options'] = null;
        }

        $question->update($validated);

        return redirect()
            ->route('questionnaire.questions', $section)
            ->with('status', 'Question updated successfully.');
    }

    public function destroyQuestion(InterviewSection $section, InterviewQuestion $question)
    {
        if ($question->section_id !== $section->id) {
            abort(404);
        }

        $responsesCount = $question->responses()->count();

        if ($responsesCount > 0) {
            return redirect()
                ->back()
                ->with('error', "Cannot delete question with {$responsesCount} responses. This would affect existing interview data.");
        }

        $question->delete();

        return redirect()
            ->route('questionnaire.questions', $section)
            ->with('status', 'Question deleted successfully.');
    }

    // Reorder sections via AJAX
    public function reorderSections(Request $request)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*' => 'required|integer|exists:interview_sections,id',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['sections'] as $order => $id) {
                InterviewSection::where('id', $id)->update(['display_order' => $order + 1]);
            }
        });

        return response()->json(['success' => true, 'message' => 'Sections reordered successfully']);
    }

    // Reorder questions via AJAX
    public function reorderQuestions(Request $request, InterviewSection $section)
    {
        $validated = $request->validate([
            'questions' => 'required|array',
            'questions.*' => 'required|integer|exists:interview_questions,id',
        ]);

        DB::transaction(function () use ($validated, $section) {
            foreach ($validated['questions'] as $order => $id) {
                InterviewQuestion::where('id', $id)
                    ->where('section_id', $section->id)
                    ->update(['display_order' => $order + 1]);
            }
        });

        return response()->json(['success' => true, 'message' => 'Questions reordered successfully']);
    }
}
