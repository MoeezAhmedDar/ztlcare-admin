@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Create New User</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <!-- Name Fields -->
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                       value="{{ old('first_name') }}" required>
                @error('first_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Middle Name</label>
                <input type="text" name="middle_name" class="form-control @error('middle_name') is-invalid @enderror"
                       value="{{ old('middle_name') }}">
                @error('middle_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                       value="{{ old('last_name') }}" required>
                @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Contact & Personal Details -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Phone Number</label>
                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone') }}" placeholder="e.g. 01234 567890">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Postcode</label>
                <input type="text" name="postcode" class="form-control @error('postcode') is-invalid @enderror"
                       value="{{ old('postcode') }}" placeholder="e.g. ML1 1XA">
                @error('postcode')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror"
                       value="{{ old('dob') }}" required>
                @error('dob')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Email & Password -->
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   required autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
        </div>

        <!-- Role Select Box -->
        <div class="mb-4">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select a role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Direct Permissions – Shows only when "admin" is selected -->
        <div id="permissions-section" class="mb-4" style="display: none;">
            <label class="form-label">Direct Permissions (for Admin role only)</label>
            <div class="border rounded p-3 bg-light" style="max-height: 220px; overflow-y: auto;">
                @foreach($permissions as $permission)
                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            name="permissions[]" 
                            value="{{ $permission->name }}" 
                            class="form-check-input" 
                            id="perm_{{ $loop->index }}"
                            {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="perm_{{ $loop->index }}">
                            {{ ucfirst(str_replace([' ', '_'], ' → ', $permission->name)) }}
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="form-text text-muted mt-2">
                Select one or more permissions to assign directly to this admin user.<br>
                These are in addition to the permissions from the admin role.
            </div>
            @error('permissions.*')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Create User</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role');
    const permissionsSection = document.getElementById('permissions-section');

    function togglePermissions() {
        if (roleSelect.value === 'admin') {
            permissionsSection.style.display = 'block';
        } else {
            permissionsSection.style.display = 'none';
            // Clear all checkboxes when hiding
            permissionsSection.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                cb.checked = false;
            });
        }
    }

    // Run on page load
    togglePermissions();

    // Run when role changes
    roleSelect.addEventListener('change', togglePermissions);
});
</script>
@endsection