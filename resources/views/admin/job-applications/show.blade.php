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

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="row mb-4">
        <div class="col-md-8">

            <!-- Uploaded Documents & Certificates -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="h6 mb-0">Uploaded Documents & Certificates</h2>
                </div>
                <div class="card-body">
                    <div class="row g-4">

                        <!-- Profile Photo -->
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Profile Photo</h5>
                            @if ($jobApplication->profile_photo)
                                <img src="{{ asset($jobApplication->profile_photo) }}" 
                                     alt="Profile Photo"
                                     class="img-thumbnail img-fluid mb-3"
                                     style="max-width: 220px; max-height: 280px; object-fit: cover;">
                                <div>
                                    <a href="{{ asset($jobApplication->profile_photo) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download me-1"></i> Download
                                    </a>
                                </div>
                            @else
                                <div class="alert alert-info small">No profile photo uploaded</div>
                            @endif
                        </div>

                        <!-- Registration Certificate -->
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Registration Certificate</h5>
                            @if ($jobApplication->registration_certificate_path)
                                <a href="{{ asset($jobApplication->registration_certificate_path) }}" target="_blank" class="btn btn-primary btn-sm mb-2">
                                    <i class="fas fa-file-download me-2"></i> Download Registration Certificate
                                </a>
                            @else
                                <div class="alert alert-info small p-2">No registration certificate uploaded</div>
                            @endif
                        </div>

                        <!-- Right to Work Proof -->
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Right to Work Proof</h5>
                            @if ($jobApplication->right_to_work_proof_path)
                                <a href="{{ asset($jobApplication->right_to_work_proof_path) }}" target="_blank" class="btn btn-primary btn-sm mb-2">
                                    <i class="fas fa-file-download me-2"></i> Download Right to Work Proof
                                </a>
                            @else
                                <div class="alert alert-info small p-2">No right to work proof uploaded</div>
                            @endif

                            @if ($jobApplication->right_to_work_share_code)
                                <p class="mt-2 mb-0"><strong>Share Code:</strong> <span class="badge bg-info">{{ $jobApplication->right_to_work_share_code }}</span></p>
                            @endif
                        </div>

                        <div class="col-12 mt-3 small text-muted">
                            Additional documents (PVG certificate, immunisation records, training certificates) should be requested if not yet received.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Education & Qualifications -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="h6 mb-0">Education & Qualifications</h2>
                </div>
                <div class="card-body">
                    @if ($jobApplication->educations->isNotEmpty())
                        <div class="table-responsive mb-4">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Establishment</th>
                                        <th>From – To</th>
                                        <th>Qualification</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobApplication->educations as $edu)
                                        <tr>
                                            <td>{{ $edu->establishment ?? '—' }}</td>
                                            <td>
                                                {{ $edu->from_date ?? '?' }}
                                                @if ($edu->from_date || $edu->to_date) – @endif
                                                {{ $edu->to_date ?? 'Present' }}
                                            </td>
                                            <td>{{ $edu->qualification ?? '—' }}</td>
                                            <td>{{ $edu->grade ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <h5 class="text-primary mb-3">Uploaded Education Certificates</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Establishment</th>
                                        <th>Qualification</th>
                                        <th>Certificate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobApplication->educations as $edu)
                                        <tr>
                                            <td>{{ $edu->establishment ?? '—' }}</td>
                                            <td>{{ $edu->qualification ?? '—' }}</td>
                                            <td>
                                                @if ($edu->certificate_path)
                                                    <a href="{{ asset($edu->certificate_path) }}" 
                                                       target="_blank" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-download me-1"></i> Download
                                                    </a>
                                                    <small class="d-block mt-1 text-muted">
                                                        {{ basename($edu->certificate_path) }}
                                                    </small>
                                                @else
                                                    <span class="text-muted small">No certificate uploaded</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info small mb-0">
                            No education or qualifications recorded for this application.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Personal Details -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="h6 mb-0">Personal Details</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Title:</strong> {{ $jobApplication->title ?? 'N/A' }}</p>
                            <p><strong>Position Applying For:</strong> {{ $jobApplication->position_applying_for ?? 'N/A' }}</p>
                            <p><strong>Forename:</strong> {{ $jobApplication->forename }}</p>
                            <p><strong>Surname:</strong> {{ $jobApplication->surname }}</p>
                            <p><strong>Previous Name:</strong> {{ $jobApplication->previous_name ?? 'N/A' }}</p>
                            <p><strong>Date of Birth:</strong> {{ optional($jobApplication->date_of_birth)->format('d/m/Y') ?? 'N/A' }}</p>
                            <p><strong>Gender:</strong> {{ $jobApplication->gender ?? 'N/A' }}</p>
                            <p><strong>Marital Status:</strong> {{ $jobApplication->marital_status ?? 'N/A' }}</p>
                            <p><strong>NI Number:</strong> {{ $jobApplication->ni_number ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Mobile:</strong> {{ $jobApplication->mobile_number ?? 'N/A' }}</p>
                            <p><strong>Landline:</strong> {{ $jobApplication->landline ?? 'N/A' }}</p>
                            <p><strong>Email:</strong> {{ $jobApplication->email ?? 'N/A' }}</p>
                            <p><strong>Address:</strong> {{ $jobApplication->address ?? 'N/A' }}</p>
                            <p><strong>Postcode:</strong> {{ $jobApplication->postcode ?? 'N/A' }}</p>
                        </div>
                    </div>

                    @if ($jobApplication->next_of_kin_name)
                        <hr>
                        <h5 class="text-primary">Emergency Contact</h5>
                        <p><strong>Name:</strong> {{ $jobApplication->next_of_kin_name }}</p>
                        <p><strong>Relationship:</strong> {{ $jobApplication->next_of_kin_relationship ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ $jobApplication->next_of_kin_phone ?? 'N/A' }}</p>
                        <p><strong>Address:</strong> {{ $jobApplication->next_of_kin_address ?? 'N/A' }}</p>
                    @endif
                </div>
            </div>

            <!-- PVG / Disclosure & Professional Registration -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="h6 mb-0">PVG / Disclosure & Professional Registration</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>PVG Number:</strong> {{ $jobApplication->pvg_number ?? 'N/A' }}</p>
                            <p><strong>Issue Date:</strong> {{ optional($jobApplication->pvg_issue_date)->format('d/m/Y') ?? 'N/A' }}</p>
                            <p><strong>Clear/Satisfactory:</strong> {{ $jobApplication->pvg_clear ? 'Yes' : 'No' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Update Service:</strong> {{ $jobApplication->pvg_updated_service ? 'Yes' : 'No' }}</p>
                            <p><strong>Professional Body:</strong> {{ $jobApplication->professional_body ?? 'N/A' }}</p>
                            <p><strong>PIN:</strong> {{ $jobApplication->pin ?? 'N/A' }}</p>
                            <p><strong>Renewal Date:</strong> {{ optional($jobApplication->renewal_date)->format('d/m/Y') ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Immunisations -->
            @php $imm = optional($jobApplication->immunisation); @endphp
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="h6 mb-0">Immunisations</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Hep B:</strong> {{ $imm->hep_b ? 'Yes' : 'No' }}</p>
                            <p><strong>TB:</strong> {{ $imm->tb ? 'Yes' : 'No' }}</p>
                            <p><strong>Varicella:</strong> {{ $imm->varicella ? 'Yes' : 'No' }}</p>
                            <p><strong>Measles:</strong> {{ $imm->measles ? 'Yes' : 'No' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Rubella:</strong> {{ $imm->rubella ? 'Yes' : 'No' }}</p>
                            <p><strong>Hep B Antigen:</strong> {{ $imm->hep_b_antigen ?? 'N/A' }}</p>
                            <p><strong>Hep C:</strong> {{ $imm->hep_c ?? 'N/A' }}</p>
                            <p><strong>HIV:</strong> {{ $imm->hiv ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <small class="text-muted d-block mt-3">Please ensure vaccination records are uploaded / requested if required.</small>
                </div>
            </div>

            <!-- Bank Details -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="h6 mb-0">Bank Details</h2>
                </div>
                <div class="card-body">
                    <p><strong>Bank Name:</strong> {{ $jobApplication->bank_name ?? 'N/A' }}</p>
                    <p><strong>Account Name:</strong> {{ $jobApplication->account_name ?? 'N/A' }}</p>
                    <p><strong>Sort Code:</strong> {{ $jobApplication->sort_code ?? 'N/A' }}</p>
                    <p><strong>Account Number:</strong> {{ $jobApplication->account_number ?? 'N/A' }}</p>
                    <p><strong>Branch Address:</strong> {{ $jobApplication->bank_branch_address ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Driving Details -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="h6 mb-0">Driving Details</h2>
                </div>
                <div class="card-body">
                    <p><strong>Valid UK Licence:</strong> {{ $jobApplication->has_uk_license ? 'Yes' : 'No' }}</p>
                    <p><strong>Use of Car:</strong> {{ $jobApplication->has_car ? 'Yes' : 'No' }}</p>
                </div>
            </div>

            <!-- Work History - Enhanced -->
            @if ($jobApplication->current_job_title || $jobApplication->workHistories->isNotEmpty())
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h6 mb-0">Work History</h2>
                    </div>
                    <div class="card-body">

                        @if ($jobApplication->current_job_title)
                            <h5 class="text-primary mb-3">Current / Most Recent Job</h5>
                            
                            <div class="mb-4 p-3 border rounded bg-light">
                                <h6 class="font-weight-bold text-primary mb-3" style="font-size: 1.25rem;">
                                    {{ $jobApplication->current_job_title }}
                                </h6>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <strong>Employer:</strong> 
                                            {{ $jobApplication->current_employer_name ?? 'Not specified' }}
                                        </p>
                                        <p class="mb-2">
                                            <strong>Started:</strong> 
                                            {{ $jobApplication->current_from_date }}
                                        </p>
                                        <p class="mb-2">
                                            <strong>Ended:</strong> 
                                            {{ $jobApplication->current_to_date }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <strong>Pay:</strong> 
                                            @if ($jobApplication->current_pay_amount)
                                                £{{ number_format($jobApplication->current_pay_amount, 2) }}
                                                <span>
                                                    per {{ $jobApplication->current_pay_frequency }}
                                                </span>
                                            @else
                                                Not specified
                                            @endif
                                        </p>
                                        <p class="mb-2">
                                            <strong>Shift Type:</strong> 
                                            {{ $jobApplication->current_shift_type ?? 'Not specified' }}
                                        </p>
                                        <p class="mb-2">
                                            <strong>Place of Work / Location:</strong> 
                                            {{ $jobApplication->current_place_of_work ?? 'Not specified' }}
                                        </p>
                                    </div>
                                </div>

                                <hr class="my-3">

                                <p class="mb-1"><strong>Main Duties / Responsibilities:</strong></p>
                                <p class="small text-muted">{{ $jobApplication->current_duties ?? 'Not provided' }}</p>
                            </div>
                        @endif

                        @if ($jobApplication->workHistories->isNotEmpty())
                            <h5 class="text-primary mt-5 mb-3">Previous Employment</h5>
                            @foreach ($jobApplication->workHistories as $history)
                                <div class="border-left border-primary pl-3 mb-4">
                                    <strong class="d-block mb-1">{{ $history->job_title ?? '—' }}</strong>
                                    <div class="small text-muted mb-2">
                                        {{ $history->employer_name ?? '—' }}
                                        •
                                        {{ optional($history->from_date)->format('m/Y') }} 
                                        – 
                                        {{ optional($history->to_date)->format('m/Y') ?? 'Present' }}
                                    </div>
                                    <p class="small mb-2">
                                        {{ $history->main_responsibilities ?? 'No responsibilities listed' }}
                                    </p>
                                    @if ($history->reason_for_leaving)
                                        <p class="small mb-0">
                                            <strong>Reason for leaving:</strong> {{ $history->reason_for_leaving }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            @endif

            <!-- Training -->
            @if ($jobApplication->training)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h6 mb-0">Mandatory & Other Training</h2>
                    </div>
                    <div class="card-body">
                        @if (!empty($jobApplication->training->mandatory_training ?? []))
                            <p><strong>Mandatory Training (last 12 months):</strong></p>
                            <ul class="list-unstyled">
                                @foreach ($jobApplication->training->mandatory_training as $t)
                                    <li>✓ {{ str_replace('_', ' ', ucwords($t)) }}</li>
                                @endforeach
                            </ul>
                        @endif
                        @if ($jobApplication->training->other_training)
                            <p class="mt-3"><strong>Other Training:</strong> {{ $jobApplication->training->other_training }}</p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- References -->
            @if ($jobApplication->references->isNotEmpty())
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h6 mb-0">References</h2>
                    </div>
                    <div class="card-body">
                        @foreach ($jobApplication->references as $ref)
                            <div class="mb-4 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                                <h6>Reference {{ $ref->reference_number ?? $loop->iteration }}</h6>
                                <p class="mb-1"><strong>{{ $ref->name }}</strong> – {{ $ref->position }}</p>
                                <p class="mb-1 small">{{ $ref->company_address ?? '' }}</p>
                                <p class="mb-1 small"><strong>Phone:</strong> {{ $ref->telephone ?? 'N/A' }} | <strong>Email:</strong> {{ $ref->email ?? 'N/A' }}</p>
                                <p class="mb-0 small">Contact now? <strong>{{ $ref->may_contact_now ? 'Yes' : 'No' }}</strong></p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Availability -->
            @if ($jobApplication->work_preferences || $jobApplication->availability_other || $jobApplication->start_date)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h6 mb-0">Availability & Preferences</h2>
                    </div>
                    <div class="card-body">
                        @php
                            $morning = in_array('Morning (M-F)', $jobApplication->work_preferences ?? []) 
                                || in_array('Morning (Monday-Sunday)', $jobApplication->work_preferences ?? []);
                            
                            $evenings = in_array('Evenings (M-F)', $jobApplication->work_preferences ?? []) 
                                || in_array('Evenings (Monday-Sunday)', $jobApplication->work_preferences ?? []);
                        @endphp

                        @if ($morning || $evenings)
                            <p><strong>Preferred Shifts:</strong></p>
                            <ul class="list-unstyled">
                                @if ($morning)
                                    <li>✓ Morning (Monday-Sunday)</li>
                                @endif
                                @if ($evenings)
                                    <li>✓ Evenings (Monday-Sunday)</li>
                                @endif
                            </ul>
                        @endif

                        @if ($jobApplication->availability_other)
                            <p class="mt-3"><strong>Other Availability:</strong> {{ $jobApplication->availability_other }}</p>
                        @endif

                        <p><strong>Can Start:</strong> {{ optional($jobApplication->start_date)->format('d/m/Y') ?? 'N/A' }}</p>
                    </div>
                </div>
            @endif

        </div>

        <!-- Sidebar -->
        <div class="col-md-4">

            <!-- Update Status -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h2 class="h6 mb-0">Update Application Status</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.job-applications.update-status', $jobApplication) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="pending" {{ $jobApplication->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="under_review" {{ $jobApplication->status === 'under_review' ? 'selected' : '' }}>Under Review</option>
                                <option value="approved" {{ $jobApplication->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $jobApplication->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="admin_notes">Admin Notes</label>
                            <textarea name="admin_notes" id="admin_notes" class="form-control" rows="4">{{ $jobApplication->admin_notes }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Application Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h2 class="h6 mb-0">Application Information</h2>
                </div>
                <div class="card-body">
                    <p><strong>Applied:</strong> {{ $jobApplication->created_at->format('d M Y H:i') }}</p>
                    <p><strong>Last Updated:</strong> {{ $jobApplication->updated_at->format('d M Y H:i') }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $jobApplication->status === 'pending' ? 'warning' : ($jobApplication->status === 'approved' ? 'success' : 'danger') }}">
                            {{ ucfirst(str_replace('_', ' ', $jobApplication->status)) }}
                        </span>
                    </p>
                    <hr>
                    <p><strong>Right to Work Status:</strong> {{ $jobApplication->right_to_work_status ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Delete Button -->
            <form action="{{ route('admin.job-applications.destroy', $jobApplication) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to permanently delete this application?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-block">Delete Application</button>
            </form>
        </div>
    </div>
@endsection