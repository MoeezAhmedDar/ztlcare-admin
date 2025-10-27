@extends('layouts.public')

@section('title', 'Job Application - Health & Safety Declarations')

@section('content')
<div class="form-container">
    <div class="form-header">
        <h1>Job Application Form</h1>
        <p>ZAN Traders Ltd - ZTL Care</p>
    </div>

    @include('job-application.partials.progress', ['currentStep' => 5])

    <div class="form-body">
        <h2 class="form-section-title">Registration Declaration Forms</h2>
        <p class="text-muted mb-4">Please read before signing</p>

        <form action="{{ route('job-application.store-step', 5) }}" method="POST">
            @csrf

            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    Health Declarations
                </div>
                <div class="card-body">
                    <p class="small">We would ask all OVERSEAS candidates to provide a medical statement from their GP or medical department confirming your state of health. Your details will be passed to our Occupational Health Doctors to establish your fitness for work.</p>
                    
                    <div class="border p-3 bg-light mb-3">
                        <p class="small mb-2">I consent to ZAN Traders Ltd releasing my health and immunisation records for review. I understand that based on this review I may be required to undergo a medical examination to establish my fitness for work.</p>
                        <p class="small mb-2">I confirm that I will immediately inform ZAN Traders Ltd in confidence if I am HIV Positive, Hep B positive or if I have AIDS in accordance with the Department of Health guidelines. I am aware of my obligations regarding MRSA contact and the need for screening.</p>
                        <p class="small mb-0">I will inform ZAN Traders Ltd immediately if I discover that I am pregnant. I understand that withholding information or giving false answers may lead to dismissal.</p>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="health_signature">Your Signature (Type Name)</label>
                            <input type="text" name="health_declaration[signature]" id="health_signature" class="form-control" value="{{ old('health_declaration.signature', $formData['step_5']['health_declaration']['signature'] ?? '') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="health_date">Date</label>
                            <input type="date" name="health_declaration[date]" id="health_date" class="form-control" value="{{ old('health_declaration.date', $formData['step_5']['health_declaration']['date'] ?? date('Y-m-d')) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    Disability Discrimination Act
                </div>
                <div class="card-body">
                    <p class="small mb-3">Applicants with disabilities will be invited for interview if the essential job criteria are met. Do you consider yourself to be a person with a disability as described by the disability discrimination act 1995?</p>
                    
                    <div class="form-group">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="disability_yes" name="disability_declaration[has_disability]" class="custom-control-input" value="1" {{ old('disability_declaration.has_disability', $formData['step_5']['disability_declaration']['has_disability'] ?? '') == '1' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="disability_yes">Yes</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="disability_no" name="disability_declaration[has_disability]" class="custom-control-input" value="0" {{ old('disability_declaration.has_disability', $formData['step_5']['disability_declaration']['has_disability'] ?? '') == '0' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="disability_no">No</label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Signature (Type Name)</label>
                            <input type="text" name="disability_declaration[signature]" class="form-control" value="{{ old('disability_declaration.signature', $formData['step_5']['disability_declaration']['signature'] ?? '') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Date</label>
                            <input type="date" name="disability_declaration[date]" class="form-control" value="{{ old('disability_declaration.date', $formData['step_5']['disability_declaration']['date'] ?? date('Y-m-d')) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    Confidentiality
                </div>
                <div class="card-body">
                    <p class="small mb-3">I hereby declare that at no time will I divulge to any person, nor use for my own or any other person's benefit, any confidential information in relation to ZAN Traders Ltd or in relation to any of their employees, business affairs, transactions, or finances which I may acquire during the term of my agreement with ZAN Traders Ltd under the Terms of Engagement.</p>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Signature (Type Name)</label>
                            <input type="text" name="confidentiality_declaration[signature]" class="form-control" value="{{ old('confidentiality_declaration.signature', $formData['step_5']['confidentiality_declaration']['signature'] ?? '') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Date</label>
                            <input type="date" name="confidentiality_declaration[date]" class="form-control" value="{{ old('confidentiality_declaration.date', $formData['step_5']['confidentiality_declaration']['date'] ?? date('Y-m-d')) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    Consent for the Use of Staff Photographic Images
                </div>
                <div class="card-body">
                    <p class="small mb-3">By signing this declaration, you authorise ZAN Traders Ltd to use your images in publications, promotions, social media, advertising, website and any other digital media or filming which ZAN Traders Ltd approves and authorise.</p>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Signature (Type Name)</label>
                            <input type="text" name="photo_consent[signature]" class="form-control" value="{{ old('photo_consent.signature', $formData['step_5']['photo_consent']['signature'] ?? '') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Date</label>
                            <input type="date" name="photo_consent[date]" class="form-control" value="{{ old('photo_consent.date', $formData['step_5']['photo_consent']['date'] ?? date('Y-m-d')) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    Personal Declarations
                </div>
                <div class="card-body">
                    <p class="small mb-3">I hereby confirm that the information provided on my application is correct and true to the best of my knowledge and that I have not withheld any information that should be considered when offering me work.</p>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Signature (Type Name)</label>
                            <input type="text" name="personal_declaration[signature]" class="form-control" value="{{ old('personal_declaration.signature', $formData['step_5']['personal_declaration']['signature'] ?? '') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Date</label>
                            <input type="date" name="personal_declaration[date]" class="form-control" value="{{ old('personal_declaration.date', $formData['step_5']['personal_declaration']['date'] ?? date('Y-m-d')) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    Working Time Regulations Declarations
                </div>
                <div class="card-body">
                    <p class="small mb-3">For the purposes of the Working Time Regulations 1998 (as amended) I, consent to work more than an average of 48 hours per week, averaged over 17 weeks. I understand that I may withdraw this consent by giving ZAN Traders Ltd not less than three months' notice at any time.</p>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Signature (Type Name)</label>
                            <input type="text" name="working_time_declaration[signature]" class="form-control" value="{{ old('working_time_declaration.signature', $formData['step_5']['working_time_declaration']['signature'] ?? '') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Date</label>
                            <input type="date" name="working_time_declaration[date]" class="form-control" value="{{ old('working_time_declaration.date', $formData['step_5']['working_time_declaration']['date'] ?? date('Y-m-d')) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    Right to Work in the UK
                </div>
                <div class="card-body">
                    <p class="small mb-3">Please complete this form, regardless of your nationality, as it is a legal requirement.</p>
                    
                    <div class="form-group">
                        <label>Your entitlement for working in the UK is based upon what status:</label>
                        <select name="right_to_work_status" class="form-control">
                            <option value="">Select</option>
                            <option value="EU Citizen" {{ old('right_to_work_status', $formData['step_5']['right_to_work_status'] ?? '') === 'EU Citizen' ? 'selected' : '' }}>EU Citizen (Visa)</option>
                            <option value="Spouse of EU Citizen" {{ old('right_to_work_status', $formData['step_5']['right_to_work_status'] ?? '') === 'Spouse of EU Citizen' ? 'selected' : '' }}>Spouse of an EU Citizen (Visa)</option>
                            <option value="Work Permit" {{ old('right_to_work_status', $formData['step_5']['right_to_work_status'] ?? '') === 'Work Permit' ? 'selected' : '' }}>Work Permit</option>
                            <option value="Permit-free Visa" {{ old('right_to_work_status', $formData['step_5']['right_to_work_status'] ?? '') === 'Permit-free Visa' ? 'selected' : '' }}>Permit-free Visa</option>
                            <option value="Right of Abode" {{ old('right_to_work_status', $formData['step_5']['right_to_work_status'] ?? '') === 'Right of Abode' ? 'selected' : '' }}>Right of Abode in the UK</option>
                            <option value="Doctor Prior to 1985" {{ old('right_to_work_status', $formData['step_5']['right_to_work_status'] ?? '') === 'Doctor Prior to 1985' ? 'selected' : '' }}>Admitted to UK as Doctor Prior to 1985</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    Rehabilitation of Offenders Act 1974
                </div>
                <div class="card-body">
                    <p class="small mb-3">Please answer all five questions</p>

                    <div class="form-group">
                        <label>1. Do you have any convictions, cautions or bindovers?</label>
                        <div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="convictions_yes" name="has_convictions" class="custom-control-input" value="1" {{ old('has_convictions', $formData['step_5']['has_convictions'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="convictions_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="convictions_no" name="has_convictions" class="custom-control-input" value="0" {{ old('has_convictions', $formData['step_5']['has_convictions'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="convictions_no">No</label>
                            </div>
                        </div>
                        <textarea name="convictions_details" class="form-control mt-2" rows="2" placeholder="If yes, please give details...">{{ old('convictions_details', $formData['step_5']['convictions_details'] ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>2. Have you ever had disciplinary action taken against you?</label>
                        <div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="disciplinary_yes" name="has_disciplinary" class="custom-control-input" value="1" {{ old('has_disciplinary', $formData['step_5']['has_disciplinary'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="disciplinary_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="disciplinary_no" name="has_disciplinary" class="custom-control-input" value="0" {{ old('has_disciplinary', $formData['step_5']['has_disciplinary'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="disciplinary_no">No</label>
                            </div>
                        </div>
                        <textarea name="disciplinary_details" class="form-control mt-2" rows="2" placeholder="If yes, please give details...">{{ old('disciplinary_details', $formData['step_5']['disciplinary_details'] ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>3. Are you at present the subject of criminal charges or disciplinary action?</label>
                        <div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="charges_yes" name="has_criminal_charges" class="custom-control-input" value="1" {{ old('has_criminal_charges', $formData['step_5']['has_criminal_charges'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="charges_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="charges_no" name="has_criminal_charges" class="custom-control-input" value="0" {{ old('has_criminal_charges', $formData['step_5']['has_criminal_charges'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="charges_no">No</label>
                            </div>
                        </div>
                        <textarea name="criminal_charges_details" class="form-control mt-2" rows="2" placeholder="If yes, please give details...">{{ old('criminal_charges_details', $formData['step_5']['criminal_charges_details'] ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>4. Do you consent to ZAN Traders Ltd requesting a police check and any appropriate references on your behalf?</label>
                        <div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="police_consent_yes" name="consents_police_check" class="custom-control-input" value="1" {{ old('consents_police_check', $formData['step_5']['consents_police_check'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="police_consent_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="police_consent_no" name="consents_police_check" class="custom-control-input" value="0" {{ old('consents_police_check', $formData['step_5']['consents_police_check'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="police_consent_no">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>5. Have you been police checked in the last three years?</label>
                        <div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="police_checked_yes" name="police_checked_recently" class="custom-control-input" value="1" {{ old('police_checked_recently', $formData['step_5']['police_checked_recently'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="police_checked_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="police_checked_no" name="police_checked_recently" class="custom-control-input" value="0" {{ old('police_checked_recently', $formData['step_5']['police_checked_recently'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="police_checked_no">No</label>
                            </div>
                        </div>
                        <textarea name="police_check_details" class="form-control mt-2" rows="2" placeholder="If so, by whom...">{{ old('police_check_details', $formData['step_5']['police_check_details'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4 pt-4 border-top">
                <a href="{{ route('job-application.step', 4) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
                <button type="submit" class="btn btn-primary">
                    Next: References & Availability <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
