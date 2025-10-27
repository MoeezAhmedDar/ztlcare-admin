@extends('layouts.public')

@section('title', 'Job Application - Work History')

@section('content')
<div class="form-container">
    <div class="form-header">
        <h1>Job Application Form</h1>
        <p>ZAN Traders Ltd - ZTL Care</p>
    </div>

    @include('job-application.partials.progress', ['currentStep' => 2])

    <div class="form-body">
        <h2 class="form-section-title">Work History</h2>
        <p class="text-muted mb-4">Please ensure you complete this section even if you have a CV. Please ensure that you leave no gaps unaccounted for and it covers 10 years.</p>

        <form action="{{ route('job-application.store-step', 2) }}" method="POST">
            @csrf

            <div class="card mb-4">
                <div class="card-header card-header-custom">
                    Current Job
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="current_job_title">Job Title</label>
                            <input type="text" name="current_job_title" id="current_job_title" class="form-control" value="{{ old('current_job_title', $formData['step_2']['current_job_title'] ?? '') }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="current_pay">Current Pay p/h (£)</label>
                            <input type="number" step="0.01" name="current_pay" id="current_pay" class="form-control" value="{{ old('current_pay', $formData['step_2']['current_pay'] ?? '') }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="current_shift_type">Day/Night Shift</label>
                            <select name="current_shift_type" id="current_shift_type" class="form-control">
                                <option value="">Select</option>
                                <option value="Day" {{ old('current_shift_type', $formData['step_2']['current_shift_type'] ?? '') === 'Day' ? 'selected' : '' }}>Day</option>
                                <option value="Night" {{ old('current_shift_type', $formData['step_2']['current_shift_type'] ?? '') === 'Night' ? 'selected' : '' }}>Night</option>
                                <option value="Both" {{ old('current_shift_type', $formData['step_2']['current_shift_type'] ?? '') === 'Both' ? 'selected' : '' }}>Both</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="current_duties">Duties</label>
                        <textarea name="current_duties" id="current_duties" class="form-control" rows="3">{{ old('current_duties', $formData['step_2']['current_duties'] ?? '') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="current_place_of_work">Current Place of Work</label>
                        <input type="text" name="current_place_of_work" id="current_place_of_work" class="form-control" value="{{ old('current_place_of_work', $formData['step_2']['current_place_of_work'] ?? '') }}">
                    </div>
                </div>
            </div>

            <h3 class="h5 mb-3">Previous Jobs</h3>
            <p class="text-muted small mb-3">Please list your previous employment history for the last 10 years</p>

            <div id="work-histories-container">
                @php
                    $savedHistories = old('work_histories', $formData['step_2']['work_histories'] ?? []);
                    $historyCount = !empty($savedHistories) ? count($savedHistories) : 7;
                @endphp

                @for($i = 0; $i < $historyCount; $i++)
                    <div class="repeatable-item work-history-item">
                        <div class="repeatable-item-header">
                            <h4 class="h6 mb-0 text-primary">Previous Job #{{ $i + 1 }}</h4>
                            @if($i > 0)
                                <button type="button" class="btn btn-sm btn-outline-danger remove-work-history">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            @endif
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>From</label>
                                <input type="date" name="work_histories[{{ $i }}][from_date]" class="form-control" value="{{ $savedHistories[$i]['from_date'] ?? '' }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>To</label>
                                <input type="date" name="work_histories[{{ $i }}][to_date]" class="form-control" value="{{ $savedHistories[$i]['to_date'] ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Name of Employer</label>
                            <input type="text" name="work_histories[{{ $i }}][employer_name]" class="form-control" value="{{ $savedHistories[$i]['employer_name'] ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Job Title</label>
                            <input type="text" name="work_histories[{{ $i }}][job_title]" class="form-control" value="{{ $savedHistories[$i]['job_title'] ?? '' }}">
                        </div>

                        <div class="form-group">
                            <label>Main Responsibilities</label>
                            <textarea name="work_histories[{{ $i }}][main_responsibilities]" class="form-control" rows="2">{{ $savedHistories[$i]['main_responsibilities'] ?? '' }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="work_histories[{{ $i }}][employer_address]" class="form-control" rows="2">{{ $savedHistories[$i]['employer_address'] ?? '' }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Reason for Leaving</label>
                            <textarea name="work_histories[{{ $i }}][reason_for_leaving]" class="form-control" rows="2">{{ $savedHistories[$i]['reason_for_leaving'] ?? '' }}</textarea>
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
                    <label>From</label>
                    <input type="date" name="work_histories[${workHistoryIndex}][from_date]" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>To</label>
                    <input type="date" name="work_histories[${workHistoryIndex}][to_date]" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Name of Employer</label>
                <input type="text" name="work_histories[${workHistoryIndex}][employer_name]" class="form-control">
            </div>
            <div class="form-group">
                <label>Job Title</label>
                <input type="text" name="work_histories[${workHistoryIndex}][job_title]" class="form-control">
            </div>
            <div class="form-group">
                <label>Main Responsibilities</label>
                <textarea name="work_histories[${workHistoryIndex}][main_responsibilities]" class="form-control" rows="2"></textarea>
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
