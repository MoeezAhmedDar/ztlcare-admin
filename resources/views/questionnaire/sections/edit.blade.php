@extends('layouts.app')

@section('title', 'Edit Section')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800">Edit Section</h1>
    <a href="{{ route('questionnaire.sections') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Back to Sections
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('questionnaire.sections.update', $section) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Section Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $section->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="display_order">Display Order <span class="text-danger">*</span></label>
                        <input type="number" name="display_order" id="display_order" class="form-control @error('display_order') is-invalid @enderror" value="{{ old('display_order', $section->display_order) }}" min="0" required>
                        @error('display_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">You can also drag-and-drop on the sections list to reorder.</small>
                    </div>

                    <div class="form-group mb-0 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Update Section
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
                <h6 class="mb-0"><i class="fas fa-list text-info"></i> Section Info</h6>
            </div>
            <div class="card-body">
                <p class="small mb-2"><strong>Questions in section:</strong> {{ $section->questions()->count() }}</p>
                <a href="{{ route('questionnaire.questions', $section) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-list mr-1"></i> Manage Questions
                </a>
            </div>
        </div>
    </div>
</div>
@endsection