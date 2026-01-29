@extends('layouts.public')

@section('title', 'Job Application - Work History')

@section('content')
<div class="form-container">
   @include('layouts.form-header')

    @include('job-application.partials.progress', ['currentStep' => 2])

    <div class="form-body">
        <h2 class="form-section-title">Work History</h2>
        <p class="text-muted mb-4">
            We require a minimum of <strong>5 years of relevant experience</strong>.<br>
            Please provide details covering at least 5 years in total (current job + previous jobs).<br>
            If you have 5 or more years in your current job, you do not need to provide previous employment history.
        </p>

        <form action="{{ route('job-application.store-step', 2) }}" method="POST">
            @csrf

            <!-- Show all validation errors at the top -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    Current Job
                </div>
                <div class="card-body">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="current_job_title">Job Title <span class="text-danger">*</span></label>
                            <input type="text" name="current_job_title" id="current_job_title" class="form-control" 
                                   value="{{ old('current_job_title', $formData['step_2']['current_job_title'] ?? '') }}" required>
                            @error('current_job_title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="current_employer_name">Name of Employer / Organisation <span class="text-danger">*</span></label>
                            <input type="text" name="current_employer_name" id="current_employer_name" class="form-control" 
                                   value="{{ old('current_employer_name', $formData['step_2']['current_employer_name'] ?? '') }}" required>
                            @error('current_employer_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="current_pay_amount">Current Pay £</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="current_pay_amount" id="current_pay_amount" class="form-control" 
                                       value="{{ old('current_pay_amount', $formData['step_2']['current_pay_amount'] ?? '') }}">
                                <div class="input-group-append">
                                    <select name="current_pay_frequency" id="current_pay_frequency" class="form-control">
                                        <option value="">Select</option>
                                        <option value="hour" {{ old('current_pay_frequency', $formData['step_2']['current_pay_frequency'] ?? '') == 'hour' ? 'selected' : '' }}>per hour</option>
                                        <option value="week" {{ old('current_pay_frequency', $formData['step_2']['current_pay_frequency'] ?? '') == 'week' ? 'selected' : '' }}>per week</option>
                                        <option value="month" {{ old('current_pay_frequency', $formData['step_2']['current_pay_frequency'] ?? '') == 'month' ? 'selected' : '' }}>per month</option>
                                        <option value="year" {{ old('current_pay_frequency', $formData['step_2']['current_pay_frequency'] ?? '') == 'year' ? 'selected' : '' }}>per year</option>
                                    </select>
                                </div>
                            </div>
                            @error('current_pay_amount')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            @error('current_pay_frequency')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="current_shift_type">Day/Night Shift</label>
                            <select name="current_shift_type" id="current_shift_type" class="form-control">
                                <option value="">Select</option>
                                <option value="Day" {{ old('current_shift_type', $formData['step_2']['current_shift_type'] ?? '') == 'Day' ? 'selected' : '' }}>Day</option>
                                <option value="Night" {{ old('current_shift_type', $formData['step_2']['current_shift_type'] ?? '') == 'Night' ? 'selected' : '' }}>Night</option>
                                <option value="Both" {{ old('current_shift_type', $formData['step_2']['current_shift_type'] ?? '') == 'Both' ? 'selected' : '' }}>Both</option>
                            </select>
                            @error('current_shift_type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="current_from_date">Started (From) <span class="text-danger">*</span></label>
                            <input type="date" name="current_from_date" id="current_from_date" class="form-control" 
                                   value="{{ old('current_from_date', $formData['step_2']['current_from_date'] ?? '') }}" required>
                            @error('current_from_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="current_to_date">Ended (To) <span class="text-muted small">(leave blank if still employed)</span></label>
                            <input type="date" name="current_to_date" id="current_to_date" class="form-control" 
                                   value="{{ old('current_to_date', $formData['step_2']['current_to_date'] ?? '') }}">
                            @error('current_to_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="current_duties">Duties / Main Responsibilities <span class="text-danger">*</span></label>
                        <textarea name="current_duties" id="current_duties" class="form-control" rows="4" required>{{ old('current_duties', $formData['step_2']['current_duties'] ?? '') }}</textarea>
                        @error('current_duties')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="current_place_of_work">Current Place of Work / Location</label>
                        <input type="text" name="current_place_of_work" id="current_place_of_work" class="form-control" 
                               value="{{ old('current_place_of_work', $formData['step_2']['current_place_of_work'] ?? '') }}">
                        @error('current_place_of_work')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- Previous Jobs Section -->
            <h3 class="h5 mb-3">Previous Jobs (only if current job is less than 5 years)</h3>
            <p class="text-muted small mb-3">
                Please add previous jobs to cover the remaining experience up to 5 years total.
            </p>

            <div id="work-histories-container">
                @php
                    $savedHistories = old('work_histories', $formData['step_2']['work_histories'] ?? []);
                    $historyCount = !empty($savedHistories) ? count($savedHistories) : 1;
                @endphp

                @for($i = 0; $i < $historyCount; $i++)
                    <div class="repeatable-item work-history-item">
                        <div class="repeatable-item-header">
                            <h4 class="h6 mb-0 text-primary">Previous Job #{{ $i + 1 }}</h4>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-work-history">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>From <span class="text-danger">*</span></label>
                                <input type="date" name="work_histories[{{ $i }}][from_date]" class="form-control" 
                                       value="{{ $savedHistories[$i]['from_date'] ?? '' }}" required>
                                @error("work_histories.$i.from_date")
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>To <span class="text-danger">*</span></label>
                                <input type="date" name="work_histories[{{ $i }}][to_date]" class="form-control" 
                                       value="{{ $savedHistories[$i]['to_date'] ?? '' }}" required>
                                @error("work_histories.$i.to_date")
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Name of Employer <span class="text-danger">*</span></label>
                            <input type="text" name="work_histories[{{ $i }}][employer_name]" class="form-control" 
                                   value="{{ $savedHistories[$i]['employer_name'] ?? '' }}" required>
                            @error("work_histories.$i.employer_name")
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Job Title <span class="text-danger">*</span></label>
                            <input type="text" name="work_histories[{{ $i }}][job_title]" class="form-control" 
                                   value="{{ $savedHistories[$i]['job_title'] ?? '' }}" required>
                            @error("work_histories.$i.job_title")
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Main Responsibilities / Duties <span class="text-danger">*</span></label>
                            <textarea name="work_histories[{{ $i }}][main_responsibilities]" class="form-control" rows="3" required>{{ $savedHistories[$i]['main_responsibilities'] ?? '' }}</textarea>
                            @error("work_histories.$i.main_responsibilities")
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="work_histories[{{ $i }}][employer_address]" class="form-control" rows="2">{{ $savedHistories[$i]['employer_address'] ?? '' }}</textarea>
                            @error("work_histories.$i.employer_address")
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Reason for Leaving</label>
                            <textarea name="work_histories[{{ $i }}][reason_for_leaving]" class="form-control" rows="2">{{ $savedHistories[$i]['reason_for_leaving'] ?? '' }}</textarea>
                            @error("work_histories.$i.reason_for_leaving")
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endfor
            </div>

            <button type="button" id="add-work-history" class="btn btn-outline-primary btn-sm mb-4">
                <i class="fas fa-plus"></i> Add Another Previous Job
            </button>

            <div class="d-flex justify-content-between mt-4 pt-4 border-top">
                <a href="{{ route('job-application.step', 1) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
                <button type="submit" class="btn btn-primary">
                    Next: Education & Training <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
let workHistoryIndex = {{ $historyCount }};

$('#add-work-history').on('click', function() {
    const html = `
        <div class="repeatable-item work-history-item">
            <div class="repeatable-item-header">
                <h4 class="h6 mb-0 text-primary">Previous Job #${workHistoryIndex + 1}</h4>
                <button type="button" class="btn btn-sm btn-outline-danger remove-work-history">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>From <span class="text-danger">*</span></label>
                    <input type="date" name="work_histories[${workHistoryIndex}][from_date]" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>To <span class="text-danger">*</span></label>
                    <input type="date" name="work_histories[${workHistoryIndex}][to_date]" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label>Name of Employer <span class="text-danger">*</span></label>
                <input type="text" name="work_histories[${workHistoryIndex}][employer_name]" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Job Title <span class="text-danger">*</span></label>
                <input type="text" name="work_histories[${workHistoryIndex}][job_title]" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Main Responsibilities / Duties <span class="text-danger">*</span></label>
                <textarea name="work_histories[${workHistoryIndex}][main_responsibilities]" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="work_histories[${workHistoryIndex}][employer_address]" class="form-control" rows="2"></textarea>
            </div>
            <div class="form-group">
                <label>Reason for Leaving</label>
                <textarea name="work_histories[${workHistoryIndex}][reason_for_leaving]" class="form-control" rows="2"></textarea>
            </div>
        </div>
    `;
    
    $('#work-histories-container').append(html);
    workHistoryIndex++;
});

$(document).on('click', '.remove-work-history', function() {
    $(this).closest('.work-history-item').remove();
});
</script>
@endpush