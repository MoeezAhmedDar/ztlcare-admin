@extends('layouts.app')

@section('title', 'Custom Letter Creator')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4 text-primary fw-bold">ZTL CARE – Custom Letter Creator</h1>

     <div class="text-center mb-4">
        <a href="{{ route('custom.preview-static') }}" 
           class="btn btn-lg btn-outline-info">
            Preview Custom Letter (Example Layout)
        </a>
    </div>
    <!-- CREATE FORM -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white h5">Create New Letter</div>
        <div class="card-body">
            <form action="{{ route('custom_letters.store') }}" method="POST">
                @csrf

                <!-- Global Validation Errors Alert -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Please fix the following errors:</strong>
                        <ul class="mt-2 mb-0 pl-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-3">
                    <!-- Dear Name Field - Will be shown/hidden by JS -->
                    <div class="col-md-6" id="dear_name_column">
                        <label class="form-label">Name (for "Dear")</label>
                        <input type="text"
                            name="dear_name"
                            class="form-control @error('dear_name') is-invalid @enderror"
                            placeholder="Mr John Smith"
                            id="dear_name_input"
                            value="{{ old('dear_name') }}">
                        <small class="text-muted">Required only when "Dear [Name]" is selected</small>

                        @error('dear_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Show Date Checkbox - Always visible -->
                    <div class="col-md-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="show_date" id="show_date" {{ old('show_date', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_date">Show Date</label>
                        </div>
                    </div>

                    <!-- Date Field - Always visible -->
                    <div class="col-md-3">
                        <label class="form-label">Date</label>
                        <input type="date"
                               name="date"
                               class="form-control @error('date') is-invalid @enderror"
                               value="{{ old('date', now()->format('Y-m-d')) }}">

                        @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <hr>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Greeting</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('greeting_type') is-invalid @enderror"
                                   type="radio"
                                   name="greeting_type"
                                   value="dear"
                                   id="dear"
                                   {{ old('greeting_type', 'to_whom') == 'dear' ? 'checked' : '' }}>
                            <label class="form-check-label" for="dear">Dear [Name]</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('greeting_type') is-invalid @enderror"
                                   type="radio"
                                   name="greeting_type"
                                   value="to_whom"
                                   id="to_whom"
                                   {{ old('greeting_type', 'to_whom') == 'to_whom' ? 'checked' : '' }}>
                            <label class="form-check-label" for="to_whom">To whom it may concern</label>
                        </div>

                        @error('greeting_type')
                            <div class="text-danger small mt-1 d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="font_size" class="form-label"><strong>Font Size</strong></label>
                        <select name="font_size"
                                id="font_size"
                                class="form-select @error('font_size') is-invalid @enderror"
                                required>
                            <option value="10.00" {{ old('font_size', '10.00') == '10.00' ? 'selected' : '' }}>10 pt (Standard)</option>
                            <option value="11.00" {{ old('font_size') == '11.00' ? 'selected' : '' }}>11 pt</option>
                            <option value="12.00" {{ old('font_size') == '12.00' ? 'selected' : '' }}>12 pt (Large)</option>
                        </select>

                        @error('font_size')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Main Content (supports bold, lists, etc.)</label>
                    <textarea name="body_content"
                              class="form-control @error('body_content') is-invalid @enderror"
                              rows="10"
                              required
                              placeholder="<p style=&quot;text-align:center;&quot;><strong>CONGRATULATIONS!</strong></p><p>We are pleased to inform you...">{{ old('body_content') }}</textarea>
                    <small class="text-muted">You can use HTML: &lt;strong&gt;bold&lt;/strong&gt;, &lt;p&gt;, &lt;ul&gt;&lt;li&gt;, etc.</small>

                    @error('body_content')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success btn-lg px-5">Save & Download PDF</button>
            </form>
        </div>
    </div>

    <!-- SAVED LETTERS TABLE -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white h5">
            Saved Custom Letters ({{ $letters->count() }})
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Greeting</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($letters as $i => $letter)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $letter->title ?: 'Untitled Letter' }}</td>
                            <td>{{ $letter->show_date ? $letter->date->format('d/m/Y') : '—' }}</td>
                            <td>
                                {{ $letter->greeting_type === 'dear' ? 'Dear ' . $letter->dear_name : 'To whom it may concern' }}
                            </td>
                            <td>{{ $letter->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('custom_letters.download', $letter->id) }}" class="btn btn-primary btn-sm">
                                    Download PDF
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No letters created yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dearRadio      = document.getElementById('dear');
    const toWhomRadio    = document.getElementById('to_whom');
    const dearNameColumn = document.getElementById('dear_name_column');

    function toggleDearName() {
        if (dearRadio.checked) {
            dearNameColumn.style.display = 'block';
        } else {
            dearNameColumn.style.display = 'none';
            document.getElementById('dear_name_input').value = ''; // Clear input when hidden
        }
    }

    // Attach event listeners
    dearRadio.addEventListener('change', toggleDearName);
    toWhomRadio.addEventListener('change', toggleDearName);

    // Run on page load (critical after form validation redirect)
    toggleDearName();
});
</script>
@endsection