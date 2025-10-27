<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Job Application - {{ $jobApplication->forename }} {{ $jobApplication->surname }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.3;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        .header h1 {
            color: #667eea;
            margin: 0 0 5px 0;
            font-size: 18px;
        }
        .header p {
            margin: 0;
            color: #666;
            font-size: 9px;
        }
        .section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        .section-title {
            background: #f8f9fc;
            padding: 6px 8px;
            font-weight: bold;
            color: #667eea;
            border-left: 4px solid #667eea;
            margin-bottom: 8px;
            font-size: 12px;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 4px 8px 4px 0;
            width: 35%;
            color: #555;
        }
        .info-value {
            display: table-cell;
            padding: 4px 0;
        }
        .item-box {
            border: 1px solid #e3e6f0;
            padding: 8px;
            margin-bottom: 8px;
            background: #f8f9fc;
        }
        .item-title {
            font-weight: bold;
            color: #667eea;
            margin-bottom: 4px;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            display: inline-block;
        }
        .badge-pending { background: #f6c23e; color: white; }
        .badge-under-review { background: #36b9cc; color: white; }
        .badge-approved { background: #1cc88a; color: white; }
        .badge-rejected { background: #e74a3b; color: white; }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #999;
            padding: 8px 0;
            border-top: 1px solid #e3e6f0;
        }
        .page-break {
            page-break-after: always;
        }
        .checklist {
            list-style: none;
            padding: 0;
        }
        .checklist li {
            padding: 2px 0;
        }
        .checklist li:before {
            content: "✓ ";
            color: #1cc88a;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Job Application Form</h1>
        <p>ZAN Traders Ltd - ZTL Care | 358 Brandon Street, Motherwell, ML1 1XA</p>
    </div>

    <div class="section">
        <div class="section-title">Application Status</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Status:</div>
                <div class="info-value">
                    <span class="badge badge-{{ str_replace('_', '-', $jobApplication->status) }}">
                        {{ strtoupper(str_replace('_', ' ', $jobApplication->status)) }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Applied On:</div>
                <div class="info-value">{{ $jobApplication->created_at->format('d M Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Application ID:</div>
                <div class="info-value">#{{ $jobApplication->id }}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Personal Details</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Full Name:</div>
                <div class="info-value">{{ $jobApplication->title }} {{ $jobApplication->forename }} {{ $jobApplication->surname }}</div>
            </div>
            @if($jobApplication->previous_name)
                <div class="info-row">
                    <div class="info-label">Previous Name:</div>
                    <div class="info-value">{{ $jobApplication->previous_name }}</div>
                </div>
            @endif
            <div class="info-row">
                <div class="info-label">Date of Birth:</div>
                <div class="info-value">{{ optional($jobApplication->date_of_birth)->format('d M Y') ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Gender:</div>
                <div class="info-value">{{ $jobApplication->gender ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Marital Status:</div>
                <div class="info-value">{{ $jobApplication->marital_status ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">NI Number:</div>
                <div class="info-value">{{ $jobApplication->ni_number ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Contact Information</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Mobile:</div>
                <div class="info-value">{{ $jobApplication->mobile_number }}</div>
            </div>
            @if($jobApplication->landline)
                <div class="info-row">
                    <div class="info-label">Landline:</div>
                    <div class="info-value">{{ $jobApplication->landline }}</div>
                </div>
            @endif
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $jobApplication->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Address:</div>
                <div class="info-value">{{ $jobApplication->address ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Postcode:</div>
                <div class="info-value">{{ $jobApplication->postcode ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    @if($jobApplication->next_of_kin_name)
        <div class="section">
            <div class="section-title">Emergency Contact</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Name:</div>
                    <div class="info-value">{{ $jobApplication->next_of_kin_name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Relationship:</div>
                    <div class="info-value">{{ $jobApplication->next_of_kin_relationship ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Phone:</div>
                    <div class="info-value">{{ $jobApplication->next_of_kin_phone ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
    @endif

    @if($jobApplication->current_job_title || $jobApplication->workHistories->isNotEmpty())
        <div class="page-break"></div>
        <div class="section">
            <div class="section-title">Employment History</div>
            
            @if($jobApplication->current_job_title)
                <div class="item-box">
                    <div class="item-title">Current Job</div>
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">Job Title:</div>
                            <div class="info-value">{{ $jobApplication->current_job_title }}</div>
                        </div>
                        @if($jobApplication->current_pay)
                            <div class="info-row">
                                <div class="info-label">Pay:</div>
                                <div class="info-value">£{{ $jobApplication->current_pay }}/hour</div>
                            </div>
                        @endif
                        @if($jobApplication->current_place_of_work)
                            <div class="info-row">
                                <div class="info-label">Place of Work:</div>
                                <div class="info-value">{{ $jobApplication->current_place_of_work }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @foreach($jobApplication->workHistories as $history)
                <div class="item-box">
                    <div class="item-title">{{ $history->job_title }} at {{ $history->employer_name }}</div>
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">Period:</div>
                            <div class="info-value">
                                {{ optional($history->from_date)->format('M Y') }} - {{ optional($history->to_date)->format('M Y') }}
                            </div>
                        </div>
                        @if($history->main_responsibilities)
                            <div class="info-row">
                                <div class="info-label">Responsibilities:</div>
                                <div class="info-value">{{ $history->main_responsibilities }}</div>
                            </div>
                        @endif
                        @if($history->reason_for_leaving)
                            <div class="info-row">
                                <div class="info-label">Reason for Leaving:</div>
                                <div class="info-value">{{ $history->reason_for_leaving }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($jobApplication->educations->isNotEmpty())
        <div class="section">
            <div class="section-title">Education</div>
            @foreach($jobApplication->educations as $education)
                <div class="item-box">
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">Institution:</div>
                            <div class="info-value">{{ $education->establishment }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Period:</div>
                            <div class="info-value">{{ $education->from_date }} - {{ $education->to_date }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Qualification:</div>
                            <div class="info-value">{{ $education->qualification }} ({{ $education->grade }})</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($jobApplication->training && !empty($jobApplication->training->mandatory_training))
        <div class="section">
            <div class="section-title">Mandatory Training Completed</div>
            <ul class="checklist">
                @foreach($jobApplication->training->mandatory_training as $training)
                    <li>{{ str_replace('_', ' ', ucwords($training, '_')) }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($jobApplication->professional_body || $jobApplication->pvg_number)
        <div class="page-break"></div>
        <div class="section">
            <div class="section-title">Professional Details</div>
            <div class="info-grid">
                @if($jobApplication->professional_body)
                    <div class="info-row">
                        <div class="info-label">Professional Body:</div>
                        <div class="info-value">{{ $jobApplication->professional_body }}</div>
                    </div>
                @endif
                @if($jobApplication->pin)
                    <div class="info-row">
                        <div class="info-label">PIN:</div>
                        <div class="info-value">{{ $jobApplication->pin }}</div>
                    </div>
                @endif
                @if($jobApplication->pvg_number)
                    <div class="info-row">
                        <div class="info-label">PVG/DBS Number:</div>
                        <div class="info-value">{{ $jobApplication->pvg_number }}</div>
                    </div>
                @endif
                @if($jobApplication->pvg_issue_date)
                    <div class="info-row">
                        <div class="info-label">PVG Issue Date:</div>
                        <div class="info-value">{{ $jobApplication->pvg_issue_date->format('d M Y') }}</div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if($jobApplication->bank_name)
        <div class="section">
            <div class="section-title">Bank Details</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Bank Name:</div>
                    <div class="info-value">{{ $jobApplication->bank_name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Account Name:</div>
                    <div class="info-value">{{ $jobApplication->account_name }}</div>
                </div>
                @if($jobApplication->account_number)
                    <div class="info-row">
                        <div class="info-label">Account Number:</div>
                        <div class="info-value">{{ $jobApplication->account_number }}</div>
                    </div>
                @endif
                @if($jobApplication->sort_code)
                    <div class="info-row">
                        <div class="info-label">Sort Code:</div>
                        <div class="info-value">{{ $jobApplication->sort_code }}</div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if($jobApplication->references->isNotEmpty())
        <div class="section">
            <div class="section-title">References</div>
            @foreach($jobApplication->references as $reference)
                <div class="item-box">
                    <div class="item-title">Reference {{ $reference->reference_number }}</div>
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">Name:</div>
                            <div class="info-value">{{ $reference->name }} ({{ $reference->position }})</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Contact:</div>
                            <div class="info-value">{{ $reference->telephone }} | {{ $reference->email }}</div>
                        </div>
                        @if($reference->company_address)
                            <div class="info-row">
                                <div class="info-label">Company:</div>
                                <div class="info-value">{{ $reference->company_address }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($jobApplication->work_preferences)
        <div class="section">
            <div class="section-title">Availability</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Work Preferences:</div>
                    <div class="info-value">{{ implode(', ', $jobApplication->work_preferences) }}</div>
                </div>
                @if($jobApplication->start_date)
                    <div class="info-row">
                        <div class="info-label">Can Start:</div>
                        <div class="info-value">{{ $jobApplication->start_date->format('d M Y') }}</div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div class="footer">
        Generated on {{ now()->format('d M Y H:i') }} | ZTL Care - Application ID: {{ $jobApplication->id }}
    </div>
</body>
</html>
