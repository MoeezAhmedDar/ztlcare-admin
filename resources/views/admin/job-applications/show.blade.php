@extends('layouts.app')

@section('title', 'Job Application - ' . $jobApplication->forename . ' ' . $jobApplication->surname)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800">Job Application: {{ $jobApplication->forename }} {{ $jobApplication->surname }}</h1>
    <div>
        <a href="{{ route('admin.job-applications.export-pdf', $jobApplication) }}" class="btn btn-success">
            <i class="fas fa-file-pdf mr-1"></i> Export PDF
        </a>
        <a href="{{ route('admin.job-applications.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back to List
        </a>
    </div>
</div>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="row mb-4">
    <div class="col-md-8">
        <!-- PROFILE PHOTO DISPLAY -->
        @if($jobApplication->profile_photo)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="h6 mb-0">Profile Photo</h2>
                </div>
                <div class="card-body text-center">
                    <img src="{{ Storage::url($jobApplication->profile_photo) }}" 
                         alt="Profile Photo" 
                         class="img-thumbnail" 
                         style="max-width: 250px; max-height: 300px; object-fit: cover; border: 4px solid #ddd;">
                    <p class="mt-2 small text-muted">Uploaded profile photo</p>
                </div>
            </div>
        @else
            <div class="alert alert-info mb-4">
                No profile photo uploaded by the applicant.
            </div>
        @endif

        <!-- Personal Details + All Document Buttons -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h2 class="h6 mb-0">Personal Details</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Title:</strong> {{ $jobApplication->title ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Forename:</strong> {{ $jobApplication->forename }}</p>
                        <p class="mb-2"><strong>Surname:</strong> {{ $jobApplication->surname }}</p>
                        <p class="mb-2"><strong>Previous Name:</strong> {{ $jobApplication->previous_name ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Date of Birth:</strong> {{ optional($jobApplication->date_of_birth)->format('d M Y') ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Gender:</strong> {{ $jobApplication->gender ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Marital Status:</strong> {{ $jobApplication->marital_status ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>NI Number:</strong> {{ $jobApplication->ni_number ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Mobile:</strong> {{ $jobApplication->mobile_number ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Landline:</strong> {{ $jobApplication->landline ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Email:</strong> {{ $jobApplication->email ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Address:</strong> {{ $jobApplication->address ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Postcode:</strong> {{ $jobApplication->postcode ?? 'N/A' }}</p>
                    </div>
                </div>

                @if($jobApplication->next_of_kin_name)
                    <hr class="my-3">
                    <h3 class="h6 text-primary">Emergency Contact</h3>
                    <p class="mb-2"><strong>Name:</strong> {{ $jobApplication->next_of_kin_name }}</p>
                    <p class="mb-2"><strong>Relationship:</strong> {{ $jobApplication->next_of_kin_relationship ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Phone:</strong> {{ $jobApplication->next_of_kin_phone ?? 'N/A' }}</p>
                @endif

                <!-- Document Downloads -->
                <div class="mt-4">
                    <h4 class="h6 text-primary mb-3">Uploaded Documents</h4>

                    <!-- Registration Certificate -->
                    @if($jobApplication->registration_certificate_path)
                        <a href="{{ Storage::url($jobApplication->registration_certificate_path) }}" 
                           target="_blank" 
                           class="btn btn-primary mr-3 mb-2">
                            <i class="fas fa-file-download mr-2"></i> Download Registration Certificate
                        </a>
                    @else
                        <span class="text-muted d-block mb-2">No registration certificate uploaded</span>
                    @endif

                    <!-- Right to Work Proof -->
                    @if($jobApplication->right_to_work_proof_path)
                        <a href="{{ Storage::url($jobApplication->right_to_work_proof_path) }}" 
                           target="_blank" 
                           class="btn btn-primary mb-2">
                            <i class="fas fa-file-download mr-2"></i> Download Right to Work Proof
                        </a>
                    @else
                        <span class="text-muted d-block mb-2">No right to work proof uploaded</span>
                    @endif

                    <!-- Right to Work Share Code -->
                    @if($jobApplication->right_to_work_share_code)
                        <p class="mb-1 mt-3"><strong>Right to Work Share Code:</strong> {{ $jobApplication->right_to_work_share_code }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Work History -->
        @if($jobApplication->workHistories->isNotEmpty() || $jobApplication->current_job_title)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="h6 mb-0">Work History</h2>
                </div>
                <div class="card-body">
                    @if($jobApplication->current_job_title)
                        <h3 class="h6 text-primary">Current Job</h3>
                        <p class="mb-1"><strong>Title:</strong> {{ $jobApplication->current_job_title }}</p>
                        <p class="mb-1"><strong>Pay:</strong> £{{ $jobApplication->current_pay_amount ?? 'N/A' }} {{ $jobApplication->current_pay_frequency ?? '' }}</p>
                        <p class="mb-3"><strong>Place of Work:</strong> {{ $jobApplication->current_place_of_work ?? 'N/A' }}</p>
                    @endif

                    @if($jobApplication->workHistories->isNotEmpty())
                        <h3 class="h6 text-primary mt-3">Previous Jobs</h3>
                        @foreach($jobApplication->workHistories as $history)
                            <div class="border-left border-primary pl-3 mb-3">
                                <p class="mb-1"><strong>{{ $history->job_title }}</strong> at {{ $history->employer_name }}</p>
                                <p class="mb-1 small text-muted">{{ optional($history->from_date)->format('M Y') }} - {{ optional($history->to_date)->format('M Y') }}</p>
                                @if($history->main_responsibilities)
                                    <p class="mb-1 small">{{ $history->main_responsibilities }}</p>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif

        <!-- Education -->
        @if($jobApplication->educations->isNotEmpty())
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="h6 mb-0">Education & Qualifications</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Establishment</th>
                                    <th>Period</th>
                                    <th>Qualification</th>
                                    <th>Grade</th>
                                    <th>Certificate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobApplication->educations as $education)
                                    <tr>
                                        <td>{{ $education->establishment ?? '—' }}</td>
                                        <td>
                                            {{ $education->from_date ?? '?' }} 
                                            @if($education->from_date || $education->to_date) - @endif
                                            {{ $education->to_date ?? 'Present' }}
                                        </td>
                                        <td>{{ $education->qualification ?? '—' }}</td>
                                        <td>{{ $education->grade ?? '—' }}</td>
                                        <td>
                                            @if($education->certificate_path)
                                                <a href="{{ Storage::url($education->certificate_path) }}" 
                                                   target="_blank" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-download"></i> View / Download
                                                </a>
                                            @else
                                                <span class="text-muted small">No certificate</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Training -->
        @if($jobApplication->training)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="h6 mb-0">Training</h2>
                </div>
                <div class="card-body">
                    @if(!empty($jobApplication->training->mandatory_training))
                        <p class="mb-2"><strong>Mandatory Training Completed:</strong></p>
                        <ul class="mb-0">
                            @foreach($jobApplication->training->mandatory_training as $training)
                                <li>{{ str_replace('_', ' ', ucfirst($training)) }}</li>
                            @endforeach
                        </ul>
                    @endif
                    @if($jobApplication->training->other_training)
                        <p class="mt-3 mb-2"><strong>Other Training:</strong></p>
                        <p class="mb-0">{{ $jobApplication->training->other_training }}</p>
                    @endif
                </div>
            </div>
        @endif

        <!-- References -->
        @if($jobApplication->references->isNotEmpty())
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="h6 mb-0">References</h2>
                </div>
                <div class="card-body">
                    @foreach($jobApplication->references as $reference)
                        <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <p class="mb-1"><strong>Reference {{ $reference->reference_number }}</strong></p>
                            <p class="mb-1">{{ $reference->name }} - {{ $reference->position }}</p>
                            <p class="mb-1 small">{{ $reference->telephone }} | {{ $reference->email }}</p>
                            <p class="mb-0 small text-muted">May contact now: {{ $reference->may_contact_now ? 'Yes' : 'No' }}</p>
                        </div>
                    @endforeach

                    <!-- Character Reference Certificate -->
                    <div class="mt-4 pt-3 border-top">
                        <p class="mb-1"><strong>Reference of character certificate:</strong> 
                            <span class="badge badge-{{ $jobApplication->character_reference_certificate === 'yes' ? 'success' : ($jobApplication->character_reference_certificate === 'no' ? 'danger' : 'secondary') }}">
                                {{ $jobApplication->character_reference_certificate ? ucfirst($jobApplication->character_reference_certificate) : 'Not specified' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Update Status -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h2 class="h6 mb-0">Update Status</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.job-applications.update-status', $jobApplication) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="pending" {{ $jobApplication->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="under_review" {{ $jobApplication->status === 'under_review' ? 'selected' : '' }}>Under Review</option>
                            <option value="approved" {{ $jobApplication->status === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $jobApplication->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="admin_notes">Admin Notes</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control" rows="4">{{ $jobApplication->admin_notes }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Update Status</button>
                </form>
            </div>
        </div>

        <!-- Application Info -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h2 class="h6 mb-0">Application Info</h2>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Applied:</strong> {{ $jobApplication->created_at->format('d M Y H:i') }}</p>
                <p class="mb-2"><strong>Updated:</strong> {{ $jobApplication->updated_at->format('d M Y H:i') }}</p>
                <p class="mb-2"><strong>Status:</strong> 
                    <span class="badge badge-{{ $jobApplication->status === 'pending' ? 'warning' : ($jobApplication->status === 'approved' ? 'success' : ($jobApplication->status === 'rejected' ? 'danger' : 'info')) }}">
                        {{ str_replace('_', ' ', ucfirst($jobApplication->status)) }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Availability -->
        @if($jobApplication->work_preferences || $jobApplication->start_date)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h2 class="h6 mb-0">Availability</h2>
                </div>
                <div class="card-body">
                    @if($jobApplication->work_preferences)
                        <p class="mb-2"><strong>Preferences:</strong></p>
                        <ul class="mb-2">
                            @foreach($jobApplication->work_preferences as $pref)
                                <li class="small">{{ $pref }}</li>
                            @endforeach
                        </ul>
                    @endif
                    @if($jobApplication->start_date)
                        <p class="mb-2"><strong>Can Start:</strong> {{ $jobApplication->start_date->format('d M Y') }}</p>
                    @endif
                </div>
            </div>
        @endif

        <!-- Delete Button -->
        <form action="{{ route('admin.job-applications.destroy', $jobApplication) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this application?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-block">Delete Application</button>
        </form>
    </div>
</div>
@endsection