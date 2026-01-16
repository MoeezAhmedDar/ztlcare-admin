@extends('layouts.public')

@section('title', 'Job Application - Education & Training')

@section('content')
<div class="form-container">
   @include('layouts.form-header')

    @include('job-application.partials.progress', ['currentStep' => 3])

    <div class="form-body">
        <h2 class="form-section-title">Your Education, Qualification and Training</h2>

        <form action="{{ route('job-application.store-step', 3) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    Education
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-4">
                        Please list all relevant education and qualifications. You can attach certificates or proof documents (optional) for each entry.
                    </p>

                    <div id="educations-container">
                        @php
                            $savedEducations = old('educations', $formData['step_3']['educations'] ?? []);
                            $educationCount = !empty($savedEducations) ? count($savedEducations) : 3;
                        @endphp

                        @for($i = 0; $i < $educationCount; $i++)
                            <div class="form-row align-items-end education-item mb-4 pb-3 border-bottom">
                                <!-- Establishment -->
                                <div class="form-group col-md-3">
                                    <label for="educations[{{ $i }}][establishment]">Establishment</label>
                                    <input type="text" name="educations[{{ $i }}][establishment]" class="form-control"
                                           value="{{ $savedEducations[$i]['establishment'] ?? '' }}">
                                    @error("educations.$i.establishment")
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- From -->
                                <div class="form-group col-md-2">
                                    <label for="educations[{{ $i }}][from_date]">From (YYYY)</label>
                                    <input type="text" name="educations[{{ $i }}][from_date]" class="form-control"
                                           placeholder="YYYY" value="{{ $savedEducations[$i]['from_date'] ?? '' }}">
                                    @error("educations.$i.from_date")
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- To -->
                                <div class="form-group col-md-2">
                                    <label for="educations[{{ $i }}][to_date]">To (YYYY)</label>
                                    <input type="text" name="educations[{{ $i }}][to_date]" class="form-control"
                                           placeholder="YYYY" value="{{ $savedEducations[$i]['to_date'] ?? '' }}">
                                    @error("educations.$i.to_date")
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Qualification -->
                                <div class="form-group col-md-3">
                                    <label for="educations[{{ $i }}][qualification]">Qualification</label>
                                    <input type="text" name="educations[{{ $i }}][qualification]" class="form-control"
                                           value="{{ $savedEducations[$i]['qualification'] ?? '' }}">
                                    @error("educations.$i.qualification")
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Grade -->
                                <div class="form-group col-md-2">
                                    <label for="educations[{{ $i }}][grade]">Grade</label>
                                    <input type="text" name="educations[{{ $i }}][grade]" class="form-control"
                                           value="{{ $savedEducations[$i]['grade'] ?? '' }}">
                                    @error("educations.$i.grade")
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Certificate Upload -->
                                <div class="form-group col-md-12 mt-3">
                                    <label for="educations[{{ $i }}][certificate]">Attach Certificate / Proof (optional)</label>
                                    <input type="file" name="educations[{{ $i }}][certificate]" class="form-control-file"
                                           accept=".jpg,.jpeg,.png,.pdf" />
                                    <small class="form-text text-muted">JPG, PNG, PDF. Max size: 5MB.</small>

                                    @if (!empty($savedEducations[$i]['certificate']))
                                        <div class="mt-2">
                                            <small class="text-success">
                                                Previously uploaded: {{ basename($savedEducations[$i]['certificate']) }}
                                            </small>
                                        </div>
                                    @endif

                                    @error("educations.$i.certificate")
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endfor
                    </div>

                    <button type="button" id="add-education" class="btn btn-outline-primary btn-sm mt-2">
                        <i class="fas fa-plus"></i> Add Another Education Entry
                    </button>
                </div>
            </div>

            <!-- Mandatory Training Section -->
            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    Mandatory Training
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Please tick if you have completed the following training within the last 12 months</p>

                    @php
                        $savedTraining = old('mandatory_training', $formData['step_3']['mandatory_training'] ?? []);
                        $trainingItems = [
                            'moving_handling' => 'Moving and Handling',
                            'basic_life_support' => 'Basic Life Support',
                            'intermediate_life_support' => 'Intermediate Life Support',
                            'advance_life_support' => 'Advance Life Support',
                            'complaints_handling' => 'Complaints Handling',
                            'handling_violence' => 'Handling Violence and Aggression',
                            'fire_safety' => 'Fire Safety',
                            'coshh' => 'COSHH',
                            'riddor' => 'RIDDOR',
                            'caldicott_protocols' => 'Caldicott Protocols',
                            'data_protection' => 'Data Protection',
                            'infection_control' => 'Infection Control',
                            'lone_worker' => 'Lone Worker Training',
                            'food_hygiene' => 'Food Hygiene (where required to handle food)',
                            'personal_safety' => 'Personal Safety (Mental Health and Learning Dis.)',
                            'covid_19' => 'Covid-19',
                        ];
                    @endphp

                    <div class="row">
                        @foreach($trainingItems as $key => $label)
                            <div class="col-md-6 mb-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="training_{{ $key }}" name="mandatory_training[]" value="{{ $key }}"
                                           {{ in_array($key, $savedTraining) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="training_{{ $key }}">{{ $label }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group mt-4">
                        <label for="other_training">Other Training (please list)</label>
                        <textarea name="other_training" id="other_training" class="form-control" rows="3">{{ old('other_training', $formData['step_3']['other_training'] ?? '') }}</textarea>
                        @error('other_training')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4 pt-4 border-top">
                <a href="{{ route('job-application.step', 2) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
                <button type="submit" class="btn btn-primary">
                    Next: Professional Details <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
let educationIndex = {{ $educationCount }};

$('#add-education').on('click', function() {
    const html = `
        <div class="form-row align-items-end education-item mb-4 pb-3 border-bottom">
            <div class="form-group col-md-3">
                <label>Establishment</label>
                <input type="text" name="educations[${educationIndex}][establishment]" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label>From (YYYY)</label>
                <input type="text" name="educations[${educationIndex}][from_date]" class="form-control" placeholder="YYYY">
            </div>
            <div class="form-group col-md-2">
                <label>To (YYYY)</label>
                <input type="text" name="educations[${educationIndex}][to_date]" class="form-control" placeholder="YYYY">
            </div>
            <div class="form-group col-md-3">
                <label>Qualification</label>
                <input type="text" name="educations[${educationIndex}][qualification]" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label>Grade</label>
                <input type="text" name="educations[${educationIndex}][grade]" class="form-control">
            </div>

            <!-- Certificate Upload -->
            <div class="form-group col-md-12 mt-3">
                <label>Attach Certificate / Proof (optional)</label>
                <input type="file" name="educations[${educationIndex}][certificate]" class="form-control-file" accept=".jpg,.jpeg,.png,.pdf">
                <small class="form-text text-muted">JPG, PNG, PDF. Max size: 5MB.</small>
            </div>
        </div>
    `;

    $('#educations-container').append(html);
    educationIndex++;
});
</script>
@endpush