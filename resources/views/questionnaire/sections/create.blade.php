@extends('layouts.app')

@section('title', 'Create Section')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800">Create New Section</h1>
    <a href="{{ route('questionnaire.sections') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Back to Sections
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('questionnaire.sections.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Section Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g., Career history / Opening questions">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">A descriptive name for this section of the questionnaire.</small>
                    </div>

                    <div class="form-group">
                        <label for="display_order">Display Order</label>
                        <input type="number" name="display_order" id="display_order" class="form-control @error('display_order') is-invalid @enderror" value="{{ old('display_order') }}" min="0" placeholder="Leave blank for automatic">
                        @error('display_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Leave blank to add at the end. You can also drag-and-drop to reorder later.</small>
                    </div>

                    <div class="form-group mb-0 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Create Section
                        </button>
                        <a href="{{ route('questionnaire.sections') }}" class="btn btn-secondary ml-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-info-circle text-info"></i> About Sections</h6>
            </div>
            <div class="card-body">
                <p class="small mb-2"><strong>Sections</strong> organize your interview questionnaire into logical groups.</p>
                <p class="small mb-2">After creating a section, you can add questions to it.</p>
                <p class="small mb-0"><strong>Example sections:</strong></p>
                <ul class="small">
                    <li>Career history</li>
                    <li>Role-based competency</li>
                    <li>Mandatory questions</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection