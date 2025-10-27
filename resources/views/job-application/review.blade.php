@extends('layouts.public')

@section('title', 'Job Application - Review & Submit')

@section('content')
<div class="form-container">
    <div class="form-header">
        <h1>Review Your Application</h1>
        <p>Please review all information before submitting</p>
    </div>

    <div class="form-body">
        <form action="{{ route('job-application.submit') }}" method="POST">
            @csrf

            @foreach($steps as $stepNum => $stepName)
                @php
                    $stepData = $formData['step_' . $stepNum] ?? [];
                @endphp

                @if(!empty($stepData))
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background: #f8f9fc;">
                            <h3 class="h6 mb-0 text-primary">{{ $stepName }}</h3>
                            <a href="{{ route('job-application.step', $stepNum) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                        <div class="card-body">
                            @if($stepNum == 1)
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Name:</strong> {{ $stepData['title'] ?? '' }} {{ $stepData['forename'] ?? '' }} {{ $stepData['surname'] ?? '' }}</p>
                                        <p class="mb-1"><strong>Date of Birth:</strong> {{ $stepData['date_of_birth'] ?? 'N/A' }}</p>
                                        <p class="mb-1"><strong>Email:</strong> {{ $stepData['email'] ?? 'N/A' }}</p>
                                        <p class="mb-1"><strong>Mobile:</strong> {{ $stepData['mobile_number'] ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Address:</strong> {{ $stepData['address'] ?? 'N/A' }}</p>
                                        <p class="mb-1"><strong>Postcode:</strong> {{ $stepData['postcode'] ?? 'N/A' }}</p>
                                        <p class="mb-1"><strong>NI Number:</strong> {{ $stepData['ni_number'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @elseif($stepNum == 2)
                                <p class="mb-2"><strong>Current Job:</strong> {{ $stepData['current_job_title'] ?? 'N/A' }}</p>
                                <p class="mb-2"><strong>Previous Jobs Listed:</strong> {{ count($stepData['work_histories'] ?? []) }}</p>
                            @elseif($stepNum == 3)
                                <p class="mb-2"><strong>Education Records:</strong> {{ count($stepData['educations'] ?? []) }}</p>
                                <p class="mb-2"><strong>Mandatory Training Completed:</strong> {{ count($stepData['mandatory_training'] ?? []) }} items</p>
                            @elseif($stepNum == 4)
                                <p class="mb-2"><strong>Professional Body:</strong> {{ $stepData['professional_body'] ?? 'N/A' }}</p>
                                <p class="mb-2"><strong>PVG/DBS Number:</strong> {{ $stepData['pvg_number'] ?? 'N/A' }}</p>
                                <p class="mb-2"><strong>Bank Account:</strong> {{ $stepData['account_name'] ?? 'N/A' }}</p>
                            @elseif($stepNum == 5)
                                <p class="mb-2"><strong>Declarations:</strong> All required declarations completed</p>
                                <p class="mb-2"><strong>Right to Work:</strong> {{ $stepData['right_to_work_status'] ?? 'Not specified' }}</p>
                            @elseif($stepNum == 6)
                                <p class="mb-2"><strong>References:</strong> {{ count($stepData['references'] ?? []) }} provided</p>
                                <p class="mb-2"><strong>Start Date:</strong> {{ $stepData['start_date'] ?? 'N/A' }}</p>
                                <p class="mb-2"><strong>Work Preferences:</strong> {{ count($stepData['work_preferences'] ?? []) }} selected</p>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach

            <div class="alert alert-info mt-4">
                <i class="fas fa-info-circle"></i> By submitting this application, you confirm that all information provided is accurate and complete to the best of your knowledge.
            </div>

            <div class="d-flex justify-content-between mt-4 pt-4 border-top">
                <a href="{{ route('job-application.step', 6) }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Edit
                </a>
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-paper-plane mr-2"></i> Submit Application
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
