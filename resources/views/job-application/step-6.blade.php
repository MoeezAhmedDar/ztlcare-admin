@extends('layouts.public')

@section('title', 'Job Application - References & Availability')

@section('content')
<div class="form-container">
    <div class="form-header">
        <h1>Job Application Form</h1>
        <p>ZAN Traders Ltd - ZTL Care</p>
    </div>

    @include('job-application.partials.progress', ['currentStep' => 6])

    <div class="form-body">
        <h2 class="form-section-title">References & Availability</h2>

        <form action="{{ route('job-application.store-step', 6) }}" method="POST">
            @csrf

            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    References
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Give details of the names/addresses of two work-related Referees. One of the Referees should be your current employer, or if presently unemployed or self-employed, your last employer</p>

                    @php
                        $savedRefs = old('references', $formData['step_6']['references'] ?? []);
                    @endphp

                    @for($i = 0; $i < 2; $i++)
                        <div class="repeatable-item mb-3">
                            <h4 class="h6 text-primary mb-3">Reference {{ $i + 1 }}</h4>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Name</label>
                                    <input type="text" name="references[{{ $i }}][name]" class="form-control" value="{{ $savedRefs[$i]['name'] ?? '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Position</label>
                                    <input type="text" name="references[{{ $i }}][position]" class="form-control" value="{{ $savedRefs[$i]['position'] ?? '' }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Company Name and Address</label>
                                <textarea name="references[{{ $i }}][company_address]" class="form-control" rows="2">{{ $savedRefs[$i]['company_address'] ?? '' }}</textarea>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Telephone Number</label>
                                    <input type="text" name="references[{{ $i }}][telephone]" class="form-control" value="{{ $savedRefs[$i]['telephone'] ?? '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email Address</label>
                                    <input type="email" name="references[{{ $i }}][email]" class="form-control" value="{{ $savedRefs[$i]['email'] ?? '' }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>May we contact the above person now?</label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="ref_{{ $i }}_contact_yes" name="references[{{ $i }}][may_contact_now]" class="custom-control-input" value="1" {{ ($savedRefs[$i]['may_contact_now'] ?? '') == '1' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="ref_{{ $i }}_contact_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="ref_{{ $i }}_contact_no" name="references[{{ $i }}][may_contact_now]" class="custom-control-input" value="0" {{ ($savedRefs[$i]['may_contact_now'] ?? '') == '0' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="ref_{{ $i }}_contact_no">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

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
                                <input type="checkbox" class="custom-control-input" id="pref_morning_mf" name="work_preferences[]" value="Morning (M-F)" {{ in_array('Morning (M-F)', $savedPrefs) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pref_morning_mf">Morning (M-F)</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="pref_evenings_mf" name="work_preferences[]" value="Evenings (M-F)" {{ in_array('Evenings (M-F)', $savedPrefs) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pref_evenings_mf">Evenings (M-F)</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="pref_nights_mf" name="work_preferences[]" value="Nights (M-F)" {{ in_array('Nights (M-F)', $savedPrefs) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pref_nights_mf">Nights (M-F)</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="pref_morning_ss" name="work_preferences[]" value="Morning (SAT-SUN)" {{ in_array('Morning (SAT-SUN)', $savedPrefs) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pref_morning_ss">Morning (SAT-SUN)</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="pref_evenings_ss" name="work_preferences[]" value="Evenings (SAT-SUN)" {{ in_array('Evenings (SAT-SUN)', $savedPrefs) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="pref_evenings_ss">Evenings (SAT-SUN)</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label for="availability_other">Other (Please specify)</label>
                        <textarea name="availability_other" id="availability_other" class="form-control" rows="2">{{ old('availability_other', $formData['step_6']['availability_other'] ?? '') }}</textarea>
                    </div>

                    <hr class="my-4">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="start_date">When can you start to work</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $formData['step_6']['start_date'] ?? '') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="interview_availability">When can you attend an interview</label>
                            <input type="date" name="interview_availability" id="interview_availability" class="form-control" value="{{ old('interview_availability', $formData['step_6']['interview_availability'] ?? '') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Do you have any holiday booked?</label>
                        <div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="holidays_yes" name="has_holidays_booked" class="custom-control-input" value="1" {{ old('has_holidays_booked', $formData['step_6']['has_holidays_booked'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="holidays_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="holidays_no" name="has_holidays_booked" class="custom-control-input" value="0" {{ old('has_holidays_booked', $formData['step_6']['has_holidays_booked'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="holidays_no">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="holidays_dates">If yes, please provide the dates</label>
                        <textarea name="holidays_dates" id="holidays_dates" class="form-control" rows="2">{{ old('holidays_dates', $formData['step_6']['holidays_dates'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    Referrals (Optional)
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Do you know if you refer your friends, we will pay you £50 per person? They must complete 100 hours to receive payment.</p>

                    @php
                        $savedReferrals = old('referrals', $formData['step_6']['referrals'] ?? []);
                    @endphp

                    @for($i = 0; $i < 5; $i++)
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Referral {{ $i + 1 }} Name</label>
                                <input type="text" name="referrals[{{ $i }}][name]" class="form-control" value="{{ $savedReferrals[$i]['name'] ?? '' }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Telephone Number</label>
                                <input type="text" name="referrals[{{ $i }}][telephone]" class="form-control" value="{{ $savedReferrals[$i]['telephone'] ?? '' }}">
                            </div>
                        </div>
                    @endfor
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
