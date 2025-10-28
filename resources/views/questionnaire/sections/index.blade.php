@extends('layouts.app')

@section('title', 'Questionnaire Sections')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800">Questionnaire Sections</h1>
    <a href="{{ route('questionnaire.sections.create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> New Section
    </a>
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
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Section Name</th>
                        <th width="120" class="text-center">Questions</th>
                        <th width="120" class="text-center">Order</th>
                        <th width="200" class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable-sections">
                    @forelse($sections as $section)
                        <tr data-id="{{ $section->id }}">
                            <td>
                                <i class="fas fa-grip-vertical text-muted" style="cursor: move;"></i>
                            </td>
                            <td>
                                <strong>{{ $section->name }}</strong>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ $section->questions_count }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-secondary">{{ $section->display_order }}</span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('questionnaire.questions', $section) }}" class="btn btn-sm btn-outline-primary" title="Manage Questions">
                                    <i class="fas fa-list"></i>
                                </a>
                                <a href="{{ route('questionnaire.sections.edit', $section) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('questionnaire.sections.destroy', $section) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this section?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                No sections yet. <a href="{{ route('questionnaire.sections.create') }}">Create the first one.</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="alert alert-info mt-3">
    <i class="fas fa-info-circle"></i> <strong>Tip:</strong> Drag and drop rows to reorder sections. Changes save automatically.
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const el = document.getElementById('sortable-sections');
    if (el && el.children.length > 1) {
        Sortable.create(el, {
            animation: 150,
            handle: '.fa-grip-vertical',
            onEnd: function(evt) {
                const rows = el.querySelectorAll('tr[data-id]');
                const sections = Array.from(rows).map(row => parseInt(row.dataset.id));
                
                fetch('{{ route("questionnaire.sections.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ sections: sections })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update order badges
                        rows.forEach((row, index) => {
                            row.querySelector('.badge-secondary').textContent = index + 1;
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