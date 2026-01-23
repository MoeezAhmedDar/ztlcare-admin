@extends('layouts.public')
@section('title', 'Job Application - Personal Details')

@section('content')


<div class="form-container">
   @include('layouts.form-header')
    @include('job-application.partials.progress', ['currentStep' => 1])

    <div class="form-body">
        <!-- NEW: Profile Photo Upload - Placed at the very top -->

        <h2 class="form-section-title">Personal Details</h2>

            <form action="{{ route('job-application.store-step', 1) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="text-center mb-4">
                <h3 class="h5 mb-3 text-primary">Profile Photo</h3>
                <div class="form-group">
                    <label for="profile_photo">Upload Your Profile Photo (required)</label>
                    <input type="file" required name="profile_photo" id="profile_photo" class="form-control-file mx-auto d-block" accept="image/*" style="max-width: 300px;">
                    <small class="form-text text-muted">Accepted formats: JPG, JPEG, PNG, GIF. Maximum size: 2MB.</small>
                    @error('profile_photo')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Optional: Show preview if previously uploaded (after validation error) -->
                @if (isset($formData['step_1']['profile_photo']) && $formData['step_1']['profile_photo'])
                    <div class="mt-3">
                        <img src="{{ Storage::url($formData['step_1']['profile_photo']) }}" 
                            alt="Profile Preview" 
                            class="img-thumbnail mx-auto d-block" 
                            style="max-width: 180px; max-height: 180px; object-fit: cover;">
                        <p class="small text-muted mt-1">Previously uploaded photo</p>
                    </div>
                @endif
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="title">Title</label>
                    <select name="title" id="title" class="form-control">
                        <option value="">Select</option>
                        <option value="Mr" {{ old('title', $formData['step_1']['title'] ?? '') === 'Mr' ? 'selected' : '' }}>Mr</option>
                        <option value="Mrs" {{ old('title', $formData['step_1']['title'] ?? '') === 'Mrs' ? 'selected' : '' }}>Mrs</option>
                        <option value="Miss" {{ old('title', $formData['step_1']['title'] ?? '') === 'Miss' ? 'selected' : '' }}>Miss</option>
                        <option value="Ms" {{ old('title', $formData['step_1']['title'] ?? '') === 'Ms' ? 'selected' : '' }}>Ms</option>
                        <option value="Dr" {{ old('title', $formData['step_1']['title'] ?? '') === 'Dr' ? 'selected' : '' }}>Dr</option>
                    </select>
                    @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                    <input type="date" required name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth', $formData['step_1']['date_of_birth'] ?? '') }}">
                    @error('date_of_birth')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="form-control">
                        <option value="">Select</option>
                        <option value="Male" {{ old('gender', $formData['step_1']['gender'] ?? '') === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $formData['step_1']['gender'] ?? '') === 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender', $formData['step_1']['gender'] ?? '') === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="marital_status">Marital Status</label>
                    <select name="marital_status" id="marital_status" class="form-control">
                        <option value="">Select</option>
                        <option value="Single" {{ old('marital_status', $formData['step_1']['marital_status'] ?? '') === 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Married" {{ old('marital_status', $formData['step_1']['marital_status'] ?? '') === 'Married' ? 'selected' : '' }}>Married</option>
                        <option value="Divorced" {{ old('marital_status', $formData['step_1']['marital_status'] ?? '') === 'Divorced' ? 'selected' : '' }}>Divorced</option>
                        <option value="Widowed" {{ old('marital_status', $formData['step_1']['marital_status'] ?? '') === 'Widowed' ? 'selected' : '' }}>Widowed</option>
                    </select>
                    @error('marital_status')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="forename">Forename <span class="text-danger">*</span></label>
                    <input type="text" name="forename" id="forename" class="form-control" value="{{ old('forename', $formData['step_1']['forename'] ?? '') }}" required>
                    @error('forename')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="surname">Surname <span class="text-danger">*</span></label>
                    <input type="text" name="surname" id="surname" class="form-control" value="{{ old('surname', $formData['step_1']['surname'] ?? '') }}" required>
                    @error('surname')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="previous_name">Previous Name</label>
                    <input type="text" name="previous_name" id="previous_name" class="form-control" value="{{ old('previous_name', $formData['step_1']['previous_name'] ?? '') }}">
                    @error('previous_name')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="ni_number">NI Number <span class="text-danger">*</span></label>
                    <input type="text" required name="ni_number" id="ni_number" class="form-control" placeholder="AB123456C" value="{{ old('ni_number', $formData['step_1']['ni_number'] ?? '') }}">
                    @error('ni_number')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>

            <h3 class="h5 mt-4 mb-3 text-primary">Address</h3>
            
            <div class="form-group">
                <label for="address">Address <span class="text-danger">*</span></label>
                <textarea name="address" required id="address" class="form-control" rows="3">{{ old('address', $formData['step_1']['address'] ?? '') }}</textarea>
                @error('address')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="postcode">Postcode <span class="text-danger">*</span></label>
                    <input type="text" required name="postcode" id="postcode" class="form-control" value="{{ old('postcode', $formData['step_1']['postcode'] ?? '') }}">
                    @error('postcode')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>

            <h3 class="h5 mt-4 mb-3 text-primary">Ways to Contact You</h3>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="mobile_number">Mobile Number <span class="text-danger">*</span></label>
                    <input type="text" name="mobile_number" id="mobile_number" class="form-control" value="{{ old('mobile_number', $formData['step_1']['mobile_number'] ?? '') }}" required>
                    @error('mobile_number')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="landline">Landline</label>
                    <input type="text" name="landline" id="landline" class="form-control" value="{{ old('landline', $formData['step_1']['landline'] ?? '') }}">
                    @error('landline')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $formData['step_1']['email'] ?? '') }}" required>
                    @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>

            <h3 class="h5 mt-4 mb-3 text-primary">Emergency Contact (Next of Kin)</h3>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="next_of_kin_name">Name</label>
                    <input type="text" name="next_of_kin_name" id="next_of_kin_name" class="form-control" value="{{ old('next_of_kin_name', $formData['step_1']['next_of_kin_name'] ?? '') }}">
                    @error('next_of_kin_name')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="next_of_kin_relationship">Relationship</label>
                    <input type="text" name="next_of_kin_relationship" id="next_of_kin_relationship" class="form-control" value="{{ old('next_of_kin_relationship', $formData['step_1']['next_of_kin_relationship'] ?? '') }}">
                    @error('next_of_kin_relationship')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="next_of_kin_phone">Phone</label>
                    <input type="text" name="next_of_kin_phone" id="next_of_kin_phone" class="form-control" value="{{ old('next_of_kin_phone', $formData['step_1']['next_of_kin_phone'] ?? '') }}">
                    @error('next_of_kin_phone')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label for="next_of_kin_address">Address</label>
                <textarea name="next_of_kin_address" id="next_of_kin_address" class="form-control" rows="2">{{ old('next_of_kin_address', $formData['step_1']['next_of_kin_address'] ?? '') }}</textarea>
                @error('next_of_kin_address')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="next_of_kin_postcode">Postcode</label>
                    <input type="text" name="next_of_kin_postcode" id="next_of_kin_postcode" class="form-control" value="{{ old('next_of_kin_postcode', $formData['step_1']['next_of_kin_postcode'] ?? '') }}">
                    @error('next_of_kin_postcode')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="next_of_kin_email">Email</label>
                    <input type="email" name="next_of_kin_email" id="next_of_kin_email" class="form-control" value="{{ old('next_of_kin_email', $formData['step_1']['next_of_kin_email'] ?? '') }}">
                    @error('next_of_kin_email')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4 pt-4 border-top">
                <div></div>
                <button type="submit" class="btn btn-primary">
                    Next: Work History <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection