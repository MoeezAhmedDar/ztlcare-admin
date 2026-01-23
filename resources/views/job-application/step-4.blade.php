@extends('layouts.public')

@section('title', 'Job Application - Professional & Payment Details')

@section('content')
<div class="form-container">
   @include('layouts.form-header')
   
    @include('job-application.partials.progress', ['currentStep' => 4])

    <div class="form-body">
        <h2 class="form-section-title">Professional Memberships</h2>

        <form action="{{ route('job-application.store-step', 4) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Global error display -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Please correct the following errors:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-body">
                    <p class="text-muted small mb-3">Please enclose, with your application a copy of your registration and membership card</p>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="professional_body">Professional Body/Type</label>
                            <input type="text" name="professional_body" id="professional_body" class="form-control" 
                                   value="{{ old('professional_body', $formData['step_4']['professional_body'] ?? '') }}">
                            @error('professional_body')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="pin">PIN (if applicable)</label>
                            <input type="text" name="pin" id="pin" class="form-control" 
                                   value="{{ old('pin', $formData['step_4']['pin'] ?? '') }}">
                            @error('pin')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="renewal_date">Renewal Date</label>
                            <input type="date" name="renewal_date" id="renewal_date" class="form-control" 
                                   value="{{ old('renewal_date', $formData['step_4']['renewal_date'] ?? '') }}">
                            @error('renewal_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pvg_number">Current PVG Number</label>
                            <input type="text" name="pvg_number" id="pvg_number" class="form-control" 
                                   value="{{ old('pvg_number', $formData['step_4']['pvg_number'] ?? '') }}">
                            @error('pvg_number')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label>Clear?</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pvg_clear_yes" name="pvg_clear" class="custom-control-input" value="1" 
                                       {{ old('pvg_clear', $formData['step_4']['pvg_clear'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pvg_clear_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pvg_clear_no" name="pvg_clear" class="custom-control-input" value="0" 
                                       {{ old('pvg_clear', $formData['step_4']['pvg_clear'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pvg_clear_no">No</label>
                            </div>
                            @error('pvg_clear')
                                <div class="text-danger small mt-1 d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="pvg_issue_date">Issue Date</label>
                            <input type="date" name="pvg_issue_date" id="pvg_issue_date" class="form-control" 
                                   value="{{ old('pvg_issue_date', $formData['step_4']['pvg_issue_date'] ?? '') }}">
                            @error('pvg_issue_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Is this certificate registered with the updated service?</label>
                        <div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pvg_updated_yes" name="pvg_updated_service" class="custom-control-input" value="1" 
                                       {{ old('pvg_updated_service', $formData['step_4']['pvg_updated_service'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pvg_updated_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="pvg_updated_no" name="pvg_updated_service" class="custom-control-input" value="0" 
                                       {{ old('pvg_updated_service', $formData['step_4']['pvg_updated_service'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pvg_updated_no">No</label>
                            </div>
                            @error('pvg_updated_service')
                                <div class="text-danger small mt-1 d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- NEW: Attachment for Registration Certificate -->
                    <div class="form-group mt-4">
                        <label for="registration_certificate">Attach Registration / Membership Certificate (optional)</label>
                        <input type="file" name="registration_certificate" id="registration_certificate" class="form-control-file" 
                               accept=".jpg,.jpeg,.png,.pdf">
                        <small class="form-text text-muted">JPG, PNG, PDF. Max size: 5MB.</small>

                        @if(old('registration_certificate_path', $formData['step_4']['registration_certificate_path'] ?? null))
                            <div class="mt-2">
                                <small class="text-success">
                                    Previously uploaded: {{ basename($formData['step_4']['registration_certificate_path']) }}
                                </small>
                            </div>
                        @endif

                        @error('registration_certificate')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Bank Payment Details -->
            <h3 class="h5 mt-4 mb-3 text-primary">Bank Payment Details</h3>
            
            <div class="card mb-4">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="bank_name">Name of Bank/Building Society</label>
                            <input type="text" name="bank_name" id="bank_name" class="form-control" 
                                   value="{{ old('bank_name', $formData['step_4']['bank_name'] ?? '') }}">
                            @error('bank_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="account_name">Account Name</label>
                            <input type="text" name="account_name" id="account_name" class="form-control" 
                                   value="{{ old('account_name', $formData['step_4']['account_name'] ?? '') }}">
                            @error('account_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Account Type</label>
                        <div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="account_personal" name="account_type" class="custom-control-input" value="Personal" 
                                       {{ old('account_type', $formData['step_4']['account_type'] ?? '') === 'Personal' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="account_personal">Personal</label>
                            </div>
                            @error('account_type')
                                <div class="text-danger small mt-1 d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bank_branch_address">Branch Address</label>
                        <textarea name="bank_branch_address" id="bank_branch_address" class="form-control" rows="2">{{ old('bank_branch_address', $formData['step_4']['bank_branch_address'] ?? '') }}</textarea>
                        @error('bank_branch_address')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="bank_postcode">Postcode</label>
                            <input type="text" name="bank_postcode" id="bank_postcode" class="form-control" 
                                   value="{{ old('bank_postcode', $formData['step_4']['bank_postcode'] ?? '') }}">
                            @error('bank_postcode')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="account_number">Account No.</label>
                            <input type="text" name="account_number" id="account_number" class="form-control" 
                                   value="{{ old('account_number', $formData['step_4']['account_number'] ?? '') }}">
                            @error('account_number')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="sort_code">Sort Code</label>
                            <input type="text" name="sort_code" id="sort_code" class="form-control" placeholder="00-00-00" 
                                   value="{{ old('sort_code', $formData['step_4']['sort_code'] ?? '') }}">
                            @error('sort_code')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Driving Details -->
            <h3 class="h5 mt-4 mb-3 text-primary">Driving Details</h3>
            
            <div class="card mb-4">
                <div class="card-body">
                    <div class="form-group">
                        <label>Do you hold a valid UK driver's licence?</label>
                        <div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="license_yes" name="has_uk_license" class="custom-control-input" value="1" 
                                       {{ old('has_uk_license', $formData['step_4']['has_uk_license'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="license_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="license_no" name="has_uk_license" class="custom-control-input" value="0" 
                                       {{ old('has_uk_license', $formData['step_4']['has_uk_license'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="license_no">No</label>
                            </div>
                            @error('has_uk_license')
                                <div class="text-danger small mt-1 d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Do you have use of a car?</label>
                        <div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="car_yes" name="has_car" class="custom-control-input" value="1" 
                                       {{ old('has_car', $formData['step_4']['has_car'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="car_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="car_no" name="has_car" class="custom-control-input" value="0" 
                                       {{ old('has_car', $formData['step_4']['has_car'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="car_no">No</label>
                            </div>
                            @error('has_car')
                                <div class="text-danger small mt-1 d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Immunisations -->
            <h3 class="h5 mt-4 mb-3 text-primary">Immunisations</h3>
            
            <div class="card mb-4">
                <div class="card-body">
                    <p class="text-muted small mb-3">Please indicate which of the following Immunisations you have been vaccinated against</p>
                    
                    <div class="row">
                        @php
                            $savedImm = old('immunisations', $formData['step_4']['immunisations'] ?? []);
                        @endphp

                        <!-- Hep B -->
                        <div class="col-md-3 mb-3">
                            <label class="font-weight-bold">Hep B</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="hep_b_yes" name="immunisations[hep_b]" value="1" 
                                       {{ ($savedImm['hep_b'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="hep_b_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="hep_b_no" name="immunisations[hep_b]" value="0" 
                                       {{ ($savedImm['hep_b'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="hep_b_no">No</label>
                            </div>
                            @error('immunisations.hep_b')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- TB -->
                        <div class="col-md-3 mb-3">
                            <label class="font-weight-bold">TB</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="tb_yes" name="immunisations[tb]" value="1" 
                                       {{ ($savedImm['tb'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="tb_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="tb_no" name="immunisations[tb]" value="0" 
                                       {{ ($savedImm['tb'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="tb_no">No</label>
                            </div>
                            @error('immunisations.tb')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Varicella -->
                        <div class="col-md-3 mb-3">
                            <label class="font-weight-bold">Varicella</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="varicella_yes" name="immunisations[varicella]" value="1" 
                                       {{ ($savedImm['varicella'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="varicella_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="varicella_no" name="immunisations[varicella]" value="0" 
                                       {{ ($savedImm['varicella'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="varicella_no">No</label>
                            </div>
                            @error('immunisations.varicella')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Measles -->
                        <div class="col-md-3 mb-3">
                            <label class="font-weight-bold">Measles</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="measles_yes" name="immunisations[measles]" value="1" 
                                       {{ ($savedImm['measles'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="measles_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="measles_no" name="immunisations[measles]" value="0" 
                                       {{ ($savedImm['measles'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="measles_no">No</label>
                            </div>
                            @error('immunisations.measles')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Rubella -->
                        <div class="col-md-3 mb-3">
                            <label class="font-weight-bold">Rubella</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="rubella_yes" name="immunisations[rubella]" value="1" 
                                       {{ ($savedImm['rubella'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="rubella_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="rubella_no" name="immunisations[rubella]" value="0" 
                                       {{ ($savedImm['rubella'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="rubella_no">No</label>
                            </div>
                            @error('immunisations.rubella')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Hep B Antigen -->
                        <div class="col-md-4 mb-3">
                            <label class="font-weight-bold">Hep B Antigen</label>
                            <select name="immunisations[hep_b_antigen]" class="form-control form-control-sm">
                                <option value="">Select</option>
                                <option value="No Proof" {{ ($savedImm['hep_b_antigen'] ?? '') === 'No Proof' ? 'selected' : '' }}>No Proof</option>
                                <option value="Negative" {{ ($savedImm['hep_b_antigen'] ?? '') === 'Negative' ? 'selected' : '' }}>Negative</option>
                                <option value="Positive" {{ ($savedImm['hep_b_antigen'] ?? '') === 'Positive' ? 'selected' : '' }}>Positive</option>
                            </select>
                            @error('immunisations.hep_b_antigen')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Hep C -->
                        <div class="col-md-4 mb-3">
                            <label class="font-weight-bold">Hep C</label>
                            <select name="immunisations[hep_c]" class="form-control form-control-sm">
                                <option value="">Select</option>
                                <option value="No Proof" {{ ($savedImm['hep_c'] ?? '') === 'No Proof' ? 'selected' : '' }}>No Proof</option>
                                <option value="Negative" {{ ($savedImm['hep_c'] ?? '') === 'Negative' ? 'selected' : '' }}>Negative</option>
                                <option value="Positive" {{ ($savedImm['hep_c'] ?? '') === 'Positive' ? 'selected' : '' }}>Positive</option>
                            </select>
                            @error('immunisations.hep_c')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- HIV -->
                        <div class="col-md-4 mb-3">
                            <label class="font-weight-bold">HIV</label>
                            <select name="immunisations[hiv]" class="form-control form-control-sm">
                                <option value="">Select</option>
                                <option value="No Proof" {{ ($savedImm['hiv'] ?? '') === 'No Proof' ? 'selected' : '' }}>No Proof</option>
                                <option value="Negative" {{ ($savedImm['hiv'] ?? '') === 'Negative' ? 'selected' : '' }}>Negative</option>
                                <option value="Positive" {{ ($savedImm['hiv'] ?? '') === 'Positive' ? 'selected' : '' }}>Positive</option>
                            </select>
                            @error('immunisations.hiv')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <small>All applications who cannot provide a registered PVG/DBS Number or full immunisation record will be required to complete at their own cost. Candidates will be required to purchase uniform if required at the cost of £20 this will be deducted from your timesheet once you have started working through us.</small>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4 pt-4 border-top">
                <a href="{{ route('job-application.step', 3) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
                <button type="submit" class="btn btn-primary">
                    Next: Declarations <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection