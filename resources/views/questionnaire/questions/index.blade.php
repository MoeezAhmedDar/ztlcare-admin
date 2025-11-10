@extends('layouts.app')

@section('title', 'Questions - ' . $section->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 text-gray-800 mb-0">{{ $section->name }}</h1>
        <p class="text-muted small mb-0">Manage questions in this section</p>
    </div>
    <div>
        <a href="{{ route('questionnaire.questions.create', $section) }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i> New Question
        </a>
        <a href="{{ route('questionnaire.sections') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back to Sections
        </a>
    </div>
</div>

@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div id="sortable-questions">
            @forelse($section->questions as $question)
                <div class="question-item border-bottom p-3" data-id="{{ $question->id }}">
                    <div class="d-flex">
                        <div class="mr-3" style="cursor: move;">
                            <i class="fas fa-grip-vertical text-muted"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge badge-secondary mr-2">{{ $question->display_order }}</span>
                                    <span class="badge badge-info mr-2">{{ ucfirst($question->input_type) }}</span>
                                    @if($question->has_score)
                                        <span class="badge badge-success">Scored</span>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('questionnaire.questions.edit', [$section, $question]) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('questionnaire.questions.destroy', [$section, $question]) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this question?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <p class="mb-2"><strong>{{ $question->prompt }}</strong></p>
                            @if($question->help_text)
                                <p class="text-muted small mb-2"><i class="fas fa-info-circle"></i> {{ $question->help_text }}</p>
                            @endif
                            @if($question->options)
                                <p class="small mb-0">
                                    <strong>Options:</strong> {{ implode(', ', $question->options) }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-3">No questions in this section yet.</p>
                    <a href="{{ route('questionnaire.questions.create', $section) }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i> Add First Question
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

@if($section->questions->count() > 0)
    <div class="alert alert-info mt-3">
        <i class="fas fa-info-circle"></i> <strong>Tip:</strong> Drag and drop questions to reorder them. Changes save automatically.
    </div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const el = document.getElementById('sortable-questions');
    if (el && el.children.length > 1) {
        Sortable.create(el, {
            animation: 150,
            handle: '.fa-grip-vertical',
            onEnd: function(evt) {
                const items = el.querySelectorAll('.question-item[data-id]');
                const questions = Array.from(items).map(item => parseInt(item.dataset.id));
                
                fetch('{{ route("questionnaire.questions.reorder", $section) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ questions: questions })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update order badges
                        items.forEach((item, index) => {
                            item.querySelector('.badge-secondary').textContent = index + 1;
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    }
});
</script>
@endpush