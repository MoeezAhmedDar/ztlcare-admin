@extends('layouts.app')

@section('title', 'Edit Question')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 text-gray-800 mb-0">Edit Question</h1>
        <p class="text-muted small mb-0">In section: <strong>{{ $section->name }}</strong></p>
    </div>
    <a href="{{ route('questionnaire.questions', $section) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Back to Questions
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('questionnaire.questions.update', [$section, $question]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="prompt">Question Text <span class="text-danger">*</span></label>
                        <textarea name="prompt" id="prompt" class="form-control @error('prompt') is-invalid @enderror" rows="3" required>{{ old('prompt', $question->prompt) }}</textarea>
                        @error('prompt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="input_type">Input Type <span class="text-danger">*</span></label>
                        <select name="input_type" id="input_type" class="form-control @error('input_type') is-invalid @enderror" required>
                            <option value="">Select type...</option>
                            <option value="text" {{ old('input_type', $question->input_type) === 'text' ? 'selected' : '' }}>Text (short answer)</option>
                            <option value="textarea" {{ old('input_type', $question->input_type) === 'textarea' ? 'selected' : '' }}>Textarea (long answer)</option>
                            <option value="select" {{ old('input_type', $question->input_type) === 'select' ? 'selected' : '' }}>Select (dropdown)</option>
                            <option value="radio" {{ old('input_type', $question->input_type) === 'radio' ? 'selected' : '' }}>Radio (single choice)</option>
                            <option value="checkbox" {{ old('input_type', $question->input_type) === 'checkbox' ? 'selected' : '' }}>Checkbox (multiple choice)</option>
                        </select>
                        @error('input_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" id="options-group">
                        <label for="options">Options (for select/radio/checkbox)</label>
                        <input type="text" name="options" id="options" class="form-control @error('options') is-invalid @enderror" value="{{ old('options', $question->options ? implode(', ', $question->options) : '') }}" placeholder="e.g., Yes, No, Maybe">
                        @error('options')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Comma-separated list of options.</small>
                    </div>

                    <div class="form-group">
                        <label for="help_text">Help Text (Optional)</label>
                        <textarea name="help_text" id="help_text" class="form-control @error('help_text') is-invalid @enderror" rows="2">{{ old('help_text', $question->help_text) }}</textarea>
                        @error('help_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="has_score" name="has_score" value="1" {{ old('has_score', $question->has_score) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="has_score">
                                This question has a score (0-3)
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="display_order">Display Order <span class="text-danger">*</span></label>
                        <input type="number" name="display_order" id="display_order" class="form-control @error('display_order') is-invalid @enderror" value="{{ old('display_order', $question->display_order) }}" min="0" required>
                        @error('display_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">You can also drag-and-drop to reorder on the questions list.</small>
                    </div>

                    <div class="form-group mb-0 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Update Question
                        </button>
                        <a href="{{ route('questionnaire.questions', $section) }}" class="btn btn-secondary ml-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-chart-bar text-info"></i> Usage Stats</h6>
            </div>
            <div class="card-body">
                <p class="small mb-2"><strong>Responses recorded:</strong> {{ $question->responses()->count() }}</p>
                @if($question->responses()->count() > 0)
                    <div class="alert alert-warning small mb-0">
                        <i class="fas fa-exclamation-triangle"></i> This question has existing responses. Changes may affect data consistency.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputType = document.getElementById('input_type');
    const optionsGroup = document.getElementById('options-group');
    
    function toggleOptions() {
        const needsOptions = ['select', 'radio', 'checkbox'].includes(inputType.value);
        optionsGroup.style.display = needsOptions ? 'block' : 'none';
    }
    
    inputType.addEventListener('change', toggleOptions);
    toggleOptions(); // Initialize on page load
});
</script>
@endpush