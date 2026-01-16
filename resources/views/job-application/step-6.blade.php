@extends('layouts.public')

@section('title', 'Job Application - References & Availability')

@section('content')
<div class="form-container">
    @include('layouts.form-header')
    
    @include('job-application.partials.progress', ['currentStep' => 6])

    <div class="form-body">
        <h2 class="form-section-title">References & Availability</h2>

        <form action="{{ route('job-application.store-step', 6) }}" method="POST">
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
                <div class="card-header card-header-custom">
                    References
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Give details of the names/addresses of two work-related Referees. One of the Referees should be your current employer, or if presently unemployed or self-employed, your last employer</p>

                    <!-- NEW FIELD: Reference of character certificate -->
                    <div class="form-group mb-4">
                        <label for="character_reference_certificate">Reference of character certificate</label>
                        <select name="character_reference_certificate" id="character_reference_certificate" class="form-control">
                            <option value="">Select</option>
                            <option value="yes" {{ old('character_reference_certificate', $formData['step_6']['character_reference_certificate'] ?? '') === 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('character_reference_certificate', $formData['step_6']['character_reference_certificate'] ?? '') === 'no' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('character_reference_certificate')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    @php
                        $savedRefs = old('references', $formData['step_6']['references'] ?? []);
                    @endphp

                    @for($i = 0; $i < 2; $i++)
                        <div class="repeatable-item mb-3">
                            <h4 class="h6 text-primary mb-3">Reference {{ $i + 1 }}</h4>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="references[{{ $i }}][name]" class="form-control" 
                                           value="{{ $savedRefs[$i]['name'] ?? '' }}">
                                    @error("references.$i.name")
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Position <span class="text-danger">*</span></label>
                                    <input type="text" name="references[{{ $i }}][position]" class="form-control" 
                                           value="{{ $savedRefs[$i]['position'] ?? '' }}">
                                    @error("references.$i.position")
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Company Name and Address</label>
                                <textarea name="references[{{ $i }}][company_address]" class="form-control" rows="2">{{ $savedRefs[$i]['company_address'] ?? '' }}</textarea>
                                @error("references.$i.company_address")
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Telephone Number <span class="text-danger">*</span></label>
                                    <input type="text" name="references[{{ $i }}][telephone]" class="form-control" 
                                           value="{{ $savedRefs[$i]['telephone'] ?? '' }}">
                                    @error("references.$i.telephone")
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="references[{{ $i }}][email]" class="form-control" 
                                           value="{{ $savedRefs[$i]['email'] ?? '' }}">
                                    @error("references.$i.email")
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label>May we contact the above person now?</label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="ref_{{ $i }}_contact_yes" name="references[{{ $i }}][may_contact_now]" class="custom-control-input" value="1" 
                                               {{ ($savedRefs[$i]['may_contact_now'] ?? '') == '1' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="ref_{{ $i }}_contact_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="ref_{{ $i }}_contact_no" name="references[{{ $i }}][may_contact_now]" class="custom-control-input" value="0" 
                                               {{ ($savedRefs[$i]['may_contact_now'] ?? '') == '0' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="ref_{{ $i }}_contact_no">No</label>
                                    </div>
                                    @error("references.$i.may_contact_now")
                                        <div class="text-danger small mt-1 d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Availability section remains unchanged -->
            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    Availability
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Please indicate when you would like to work. Please tick all relevant boxes.</p>

                    @php
                        $savedPrefs = old('work_preferences', $formData['step_6']['work_preferences'] ?? []);
                    @endphp

                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="pref_morning_mf" name="work_preferences[]" value="Morning (M-F)" 
                                       {{ in_array('Morning (M-F)', $savedPrefs) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pref_morning_mf">Morning (M-F)</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="pref_evenings_mf" name="work_preferences[]" value="Evenings (M-F)" 
                                       {{ in_array('Evenings (M-F)', $savedPrefs) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pref_evenings_mf">Evenings (M-F)</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="pref_nights_mf" name="work_preferences[]" value="Nights (M-F)" 
                                       {{ in_array('Nights (M-F)', $savedPrefs) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pref_nights_mf">Nights (M-F)</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="pref_morning_ss" name="work_preferences[]" value="Morning (SAT-SUN)" 
                                       {{ in_array('Morning (SAT-SUN)', $savedPrefs) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pref_morning_ss">Morning (SAT-SUN)</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="pref_evenings_ss" name="work_preferences[]" value="Evenings (SAT-SUN)" 
                                       {{ in_array('Evenings (SAT-SUN)', $savedPrefs) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pref_evenings_ss">Evenings (SAT-SUN)</label>
                            </div>
                        </div>
                    </div>
                    @error('work_preferences')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                    <div class="form-group mt-3">
                        <label for="availability_other">Other (Please specify)</label>
                        <textarea name="availability_other" id="availability_other" class="form-control" rows="2">{{ old('availability_other', $formData['step_6']['availability_other'] ?? '') }}</textarea>
                        @error('availability_other')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="start_date">When can you start to work</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" 
                                   value="{{ old('start_date', $formData['step_6']['start_date'] ?? '') }}">
                            @error('start_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="interview_availability">When can you attend an interview</label>
                            <input type="date" name="interview_availability" id="interview_availability" class="form-control" 
                                   value="{{ old('interview_availability', $formData['step_6']['interview_availability'] ?? '') }}">
                            @error('interview_availability')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Do you have any holiday booked?</label>
                        <div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="holidays_yes" name="has_holidays_booked" class="custom-control-input" value="1" 
                                       {{ old('has_holidays_booked', $formData['step_6']['has_holidays_booked'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="holidays_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="holidays_no" name="has_holidays_booked" class="custom-control-input" value="0" 
                                       {{ old('has_holidays_booked', $formData['step_6']['has_holidays_booked'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="holidays_no">No</label>
                            </div>
                            @error('has_holidays_booked')
                                <div class="text-danger small mt-1 d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="holidays_dates">If yes, please provide the dates</label>
                        <textarea name="holidays_dates" id="holidays_dates" class="form-control" rows="2">{{ old('holidays_dates', $formData['step_6']['holidays_dates'] ?? '') }}</textarea>
                        @error('holidays_dates')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4 pt-4 border-top">
                <a href="{{ route('job-application.step', 5) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
                <button type="submit" class="btn btn-success btn-lg">
                    Review & Submit <i class="fas fa-check ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection