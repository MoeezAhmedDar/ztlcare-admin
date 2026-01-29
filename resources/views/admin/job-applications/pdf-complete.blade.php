<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Job Application - {{ $jobApplication->forename }} {{ $jobApplication->surname }}</title>
    <style>
        @page { margin: 18mm 14mm 26mm 14mm; }
        body { font-family: "DejaVu Sans", sans-serif; font-size: 12px; color: #000; line-height: 1.3; }
        h1 { margin: 10px 0 4px 0; font-size: 18px; text-align: center; font-weight: bold; }
        .job-title { font-size: 15px; color: #006699; text-align: center; margin: 0 0 12px 0; font-weight: bold; }
        h2 { margin: 8px 0 6px 0; font-size: 14px; text-align: center; font-weight: bold; }
        .header { display: table; width: 100%; margin-bottom: 8px; }
        .header-left { display: table-cell; vertical-align: top; width: 55%; font-size: 12px; line-height: 1.3; font-weight: normal; }
        .header-right { display: table-cell; text-align: right; vertical-align: top; }
        .header-right img { width: 165px; }
        .profile-photo-container { text-align: center; margin: 12px 0 18px 0; }
        .profile-photo { max-width: 140px; max-height: 180px; border: 2px solid #7fb7cf; border-radius: 6px; object-fit: cover; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
        .section-title { background: #62c2dd; color: #fff; font-weight: bold; padding: 4px 7px; text-transform: uppercase; font-size: 12px; }
        th, td { border: 1px solid #7fb7cf; padding: 4px 7px; vertical-align: top; font-size: 12px; font-weight: normal; }
        .checkbox { display: inline-block; width: 11px; height: 11px; border: 1px solid #000; text-align: center; line-height: 11px; font-size: 12px; margin-right: 2px; }
        .page-break { page-break-after: always; }
        .footer { position: fixed; bottom: -6mm; left: 14mm; right: 14mm; text-align: center; font-size: 12px; }
        .instruction { font-size: 9px; font-style: italic; text-align: center; margin: 4px 0; }
        ul { margin: 3px 0; padding-left: 12px; font-size: 10px; list-style: none; }
        ul li { margin-bottom: 3px; }
    </style>
</head>
<body>
@php
    $box = fn($checked) => '<span class="checkbox">' . ($checked ? '✓' : '&nbsp;') . '</span>';
    $formatDate = fn($value) => optional($value)->format('d/m/Y') ?? '';
    $prefs = $jobApplication->work_preferences ?? [];
    $pref = fn($label) => in_array($label, $prefs ?? []);
    $logoPath = public_path('img/logo.png');
    $logoExists = file_exists($logoPath);
@endphp

<!-- PAGE 1 -->
<div class="header">
    <div class="header-left">
        358 Brandon Street Motherwell<br>
        North Lanarkshire ML1 1XA<br>
        T: 01698 701199<br>
        E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)
            <img src="{{ $logoPath }}" alt="ZTL Care Logo">
        @endif
    </div>
</div>

<div class="profile-photo-container">
    @if ($jobApplication->profile_photo && file_exists(public_path($jobApplication->profile_photo)))
        <img src="{{ public_path($jobApplication->profile_photo) }}" 
             alt="Applicant Profile Photo" 
             class="profile-photo">
    @else
        <div style="font-style:italic; color:#666; font-size:11px;">
            No profile photo uploaded
        </div>
    @endif
</div>

<h1>Job Application Form</h1>
<h2 class="job-title">
    Position Applying For: {{ $jobApplication->position_applying_for ?? 'Not specified' }}
</h2>

<table>
    <tr><td class="section-title" colspan="2">PERSONAL DETAILS</td></tr>
    <tr>
        <td style="width:50%;">Title: {{ $jobApplication->title ?? '—' }}</td>
        <td style="width:50%;">Date of birth: {{ $formatDate($jobApplication->date_of_birth) }}</td>
    </tr>
    <tr><td colspan="2">Forename: {{ $jobApplication->forename }}</td></tr>
    <tr><td colspan="2">Surname: {{ $jobApplication->surname }}</td></tr>
    <tr><td colspan="2">Previous Name: {{ $jobApplication->previous_name ?? '—' }}</td></tr>
    <tr>
        <td>Gender: {{ $jobApplication->gender ?? '—' }}</td>
        <td>Marital status: {{ $jobApplication->marital_status ?? '—' }}</td>
    </tr>
    <tr><td colspan="2">NI Number: {{ $jobApplication->ni_number ?? '—' }}</td></tr>
</table>

<table>
    <tr><td class="section-title" colspan="2">ADDRESS</td></tr>
    <tr><td colspan="2" style="min-height:30px;">Address: {{ $jobApplication->address ?? '—' }}</td></tr>
    <tr><td colspan="2">Postcode: {{ $jobApplication->postcode ?? '—' }}</td></tr>
</table>

<table>
    <tr><td class="section-title" colspan="2">WAYS TO CONTACT YOU</td></tr>
    <tr>
        <td style="width:50%;">Mobile Number: {{ $jobApplication->mobile_number ?? '—' }}</td>
        <td style="width:50%;">Landline: {{ $jobApplication->landline ?? '—' }}</td>
    </tr>
    <tr><td colspan="2">Email: {{ $jobApplication->email ?? '—' }}</td></tr>
</table>

<table>
    <tr><td class="section-title" colspan="2">EMERGENCY CONTACT</td></tr>
    <tr><td colspan="2">Next of Kin: {{ $jobApplication->next_of_kin_name ?? '—' }}</td></tr>
    <tr>
        <td style="width:50%;">Relationship: {{ $jobApplication->next_of_kin_relationship ?? '—' }}</td>
        <td style="width:50%;">Phone: {{ $jobApplication->next_of_kin_phone ?? '—' }}</td>
    </tr>
    <tr><td colspan="2">Address: {{ $jobApplication->next_of_kin_address ?? '—' }}</td></tr>
    <tr>
        <td style="width:50%;">Postcode: {{ $jobApplication->next_of_kin_postcode ?? '—' }}</td>
        <td style="width:50%;">Email: {{ $jobApplication->next_of_kin_email ?? '—' }}</td>
    </tr>
</table>

<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
<div class="page-break"></div>

<!-- PAGE 2 - WORK HISTORY -->
<div class="header">
    <div class="header-left">
        358 Brandon Street Motherwell<br>
        North Lanarkshire ML1 1XA<br>
        T: 01698 701199<br>
        E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)
            <img src="{{ $logoPath }}" alt="ZTL Care Logo">
        @endif
    </div>
</div>

<h2>WORK HISTORY</h2>
<p class="instruction">Please ensure you complete this section even if you have a CV. Please ensure that you leave no gaps unaccounted for and it covers 5 years.</p>

<table>
    <tr><td class="section-title" colspan="2">CURRENT JOB</td></tr>
    <tr>
        <td style="width:50%;">Job title: {{ $jobApplication->current_job_title ?? '—' }}</td>
        <td style="width:50%;">
            Current Pay: 
            @if($jobApplication->current_pay_amount)
                £{{ number_format($jobApplication->current_pay_amount, 2) }} 
                per {{ $jobApplication->current_pay_frequency ?? '—' }}
            @else
                —
            @endif
        </td>
    </tr>
    <tr>
        <td>Started: {{ $jobApplication->current_from_date }}</td>
        <td>Ended: {{ $jobApplication->current_to_date ? $jobApplication->current_to_date : 'Present' }}</td>
    </tr>
    <tr><td colspan="2">Employer: {{ $jobApplication->current_employer_name ?? '—' }}</td></tr>
    <tr><td colspan="2">Duties: {{ $jobApplication->current_duties ?? '—' }}</td></tr>
    <tr>
        <td>Current Place of Work: {{ $jobApplication->current_place_of_work ?? '—' }}</td>
        <td>Day/Night Shift: {{ $jobApplication->current_shift_type ?? '—' }}</td>
    </tr>
</table>

@foreach($jobApplication->workHistories as $h)
    <table>
        <tr><td class="section-title" colspan="2">PREVIOUS JOB</td></tr>
        <tr>
            <td style="width:50%;">From: {{ optional($h->from_date)->format('m/Y') ?? '—' }}</td>
            <td style="width:50%;">To: {{ optional($h->to_date)->format('m/Y') ?? 'Present' }}</td>
        </tr>
        <tr><td colspan="2">Name of Employer: {{ $h->employer_name ?? '—' }}</td></tr>
        <tr><td colspan="2">Job Title: {{ $h->job_title ?? '—' }}</td></tr>
        <tr><td colspan="2">Main Responsibilities: {{ $h->main_responsibilities ?? '—' }}</td></tr>
        <tr><td colspan="2">Address: {{ $h->employer_address ?? '—' }}</td></tr>
        <tr><td colspan="2">Reason for Leaving: {{ $h->reason_for_leaving ?? '—' }}</td></tr>
    </table>
@endforeach

<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
<div class="page-break"></div>

{{-- PAGE 3 --}}
<!-- <div class="header">
    <div class="header-left">358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA<br>T: 01698 701199<br>E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care</div>
    <div class="header-right">@if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif</div>
</div>
@for($i = 3; $i < 7; $i++)
@php $h = $histories[$i] ?? null; @endphp
<table>
    <tr><td class="section-title" colspan="2">PREVIOUS JOB</td></tr>
    <tr>
        <td style="width:50%;">From: {{ $h ? optional($h->from_date)->format('m/Y') : '' }}</td>
        <td style="width:50%;">To: {{ $h ? optional($h->to_date)->format('m/Y') : '' }}</td>
    </tr>
    <tr><td colspan="2">Name of Employer: {{ $h->employer_name ?? '' }}</td></tr>
    <tr><td colspan="2">Job Title: {{ $h->job_title ?? '' }}</td></tr>
    <tr><td colspan="2">Main Responsibilities: {{ $h->main_responsibilities ?? '' }}</td></tr>
    <tr><td colspan="2">Address: {{ $h->employer_address ?? '' }}</td></tr>
    <tr><td colspan="2">Reason for Leaving: {{ $h->reason_for_leaving ?? '' }}</td></tr>
</table>
@endfor
<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
<div class="page-break"></div> -->

{{-- PAGE 4 --}}
<div class="header">
    <div class="header-left">358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA<br>T: 01698 701199<br>E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care</div>
    <div class="header-right">@if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif</div>
</div>
<h2>YOUR EDUCATION, QUALIFICATION AND TRAINING</h2>
<p class="instruction">Please ensure you list all educational and relevant training undertaken</p>
<table>
    <tr><td class="section-title" colspan="5">EDUCATION</td></tr>
    <tr>
        <td style="width:36%;">Establishment:</td>
        <td style="width:16%;">From:</td>
        <td style="width:16%;">To:</td>
        <td style="width:20%;">Qualification:</td>
        <td style="width:12%;">Grade:</td>
    </tr>
    @php $edus = $jobApplication->educations; @endphp
    @for($i = 0; $i < 7; $i++)
    @php $e = $edus[$i] ?? null; @endphp
    <tr>
        <td style="min-height:22px;">{{ $e->establishment ?? '' }}</td>
        <td>{{ $e->from_date ?? '' }}</td>
        <td>{{ $e->to_date ?? '' }}</td>
        <td>{{ $e->qualification ?? '' }}</td>
        <td>{{ $e->grade ?? '' }}</td>
    </tr>
    @endfor
</table>
@php
    // Get the training array from DB
    $trainings = $jobApplication->training->mandatory_training ?? [];
    
    // If it's stored as JSON string, decode it
    if (is_string($trainings)) {
        $trainings = json_decode($trainings, true) ?? [];
    }

    // Define all possible trainings with their display names
    $trainingList = [
        'moving_handling'               => 'Moving and Handling',
        'basic_life_support'            => 'Basic Life Support',
        'intermediate_life_support'     => 'Intermediate Life Support',
        'advance_life_support'          => 'Advanced Life Support',
        'handling_violence'             => 'Handling Violence and Aggression',
        'fire_safety'                   => 'Fire Safety',
        'coshh'                         => 'COSHH',
        'riddor'                        => 'RIDDOR',
        'data_protection'               => 'Data Protection',
        'complaints_handling'           => 'Complaints Handling',
        'caldicott_protocols'           => 'Caldicott Protocols',
        'infection_control'             => 'Infection Control',
        'lone_worker'                   => 'Lone Worker Training',
        'food_hygiene'                  => 'Food Hygiene (where required to handle food)',
        'personal_safety' => 'Personal Safety (Mental Health and Learning Dis.)',
        'covid_19'                      => 'Covid-19',
    ];
@endphp

<table>
    <tr>
        <td class="section-title">MANDATORY TRAINING</td>
    </tr>
    <tr>
        <td style="font-size:8px; font-style:italic;" colspan="4">
            Please tick if you have completed the following training within the last 12 months, please enclose copies of your training certificates.
        </td>
    </tr>
</table>

<table>
    <?php $chunks = array_chunk($trainingList, 4, true); ?>
    @foreach($chunks as $row)
        <tr>
            @foreach($row as $slug => $label)
                <td style="width:25%;">
                    {{ $label }}: 
                    {!! in_array($slug, $trainings) ? $box(true) : $box(false) !!}
                </td>
            @endforeach

            {{-- Fill remaining cells if last row has fewer than 4 items --}}
            @if(count($row) < 4)
                @for($i = count($row); $i < 4; $i++)
                    <td style="width:25%;"></td>
                @endfor
            @endif
        </tr>
    @endforeach
</table>
<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
<div class="page-break"></div>

{{-- PAGE 5: PROFESSIONAL, BANK, DRIVING, IMMUNISATIONS --}}
<div class="header">
    <div class="header-left">358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA<br>T: 01698 701199<br>E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care</div>
    <div class="header-right">@if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif</div>
</div>
<h2>PROFESSIONAL MEMBERSHIPS</h2>
<p class="instruction">Please enclose, with your application a copy of your registration and membership card</p>
<table>
    <tr><td class="section-title" colspan="2">PROFESSIONAL MEMBERSHIP DETAILS</td></tr>
    <tr><td colspan="2">Professional Body/Type: {{ $jobApplication->professional_body }}</td></tr>
    <tr><td colspan="2">PIN (if applicable): {{ $jobApplication->pin }}</td></tr>
    <tr><td colspan="2">Renewal Date (if applicable): {{ $formatDate($jobApplication->renewal_date) }}</td></tr>
    <tr>
        <td style="width:50%;">Current PVG/DBS: {{ $jobApplication->pvg_number }}</td>
        <td style="width:50%;">Clear: {{ $jobApplication->pvg_clear ? 'Yes' : 'No' }}</td>
    </tr>
    <tr>
        <td>Issue Date: {{ $formatDate($jobApplication->pvg_issue_date) }}</td>
        <td>PVG/DBS Number: {{ $jobApplication->pvg_number }}</td>
    </tr>
    <tr><td colspan="2">Is this certificate registered with the updated service? Yes {!! $box($jobApplication->pvg_updated_service) !!} &nbsp;&nbsp; No {!! $box(!$jobApplication->pvg_updated_service) !!}</td></tr>
</table>
<table>
    <tr><td class="section-title" colspan="2">BANK PAYMENT DETAILS</td></tr>
    <tr><td colspan="2">Name of Bank/Building Society: {{ $jobApplication->bank_name }}</td></tr>
    <tr>
        <td style="width:50%;">Account Name: {{ $jobApplication->account_name }}</td>
        <td>Account Type: Personal</td>
        <!-- <td>Account Type: Personal {!! $box($jobApplication->account_type === 'Personal') !!} &nbsp;&nbsp; LTD. {!! $box($jobApplication->account_type === 'LTD') !!}</td> -->
    </tr>
    <tr><td colspan="2">Branch Address: {{ $jobApplication->bank_branch_address }}</td></tr>
    <tr><td colspan="2">Postcode: {{ $jobApplication->bank_postcode }}</td></tr>
    <tr>
        <td>Account No.: {{ $jobApplication->account_number }}</td>
        <td>Sort code: {{ $jobApplication->sort_code }}</td>
    </tr>
</table>
<table>
    <tr><td class="section-title" colspan="2">DRIVING DETAILS</td></tr>
    <tr><td colspan="2">Do you hold a valid UK driver's licence? Yes {!! $box($jobApplication->has_uk_license) !!} &nbsp;&nbsp; No {!! $box(!$jobApplication->has_uk_license) !!}</td></tr>
    <tr><td colspan="2">Do you have use of a car? Yes {!! $box($jobApplication->has_car) !!} &nbsp;&nbsp; No {!! $box(!$jobApplication->has_car) !!}</td></tr>
</table>
@php $imm = optional($jobApplication->immunisation); @endphp
<table style="page-break-inside: avoid;">
    <tr><td class="section-title" colspan="4">IMMUNISATIONS</td></tr>
    <tr>
        <td colspan="4" style="font-size:8px;">
            Please indicate which of the following Immunisations you have been vaccinated against and include your vaccination reports when returning your registration.
        </td>
    </tr>

    <!-- Yes/No style fields -->
    <tr>
        <td style="width:20%;">Hep B</td>
        <td style="width:30%;">
            Yes {!! $box($imm->hep_b == '1' || $imm->hep_b == 1) !!} 
            &nbsp; No {!! $box($imm->hep_b == '0' || $imm->hep_b == 0) !!}
        </td>
        <td style="width:20%;">TB</td>
        <td>
            Yes {!! $box($imm->tb == '1' || $imm->tb == 1) !!} 
            &nbsp; No {!! $box($imm->tb == '0' || $imm->tb == 0) !!}
        </td>
    </tr>

    <tr>
        <td>Varicella</td>
        <td>
            Yes {!! $box($imm->varicella == '1' || $imm->varicella == 1) !!} 
            &nbsp; No {!! $box($imm->varicella == '0' || $imm->varicella == 0) !!}
        </td>
        <td>Measles</td>
        <td>
            Yes {!! $box($imm->measles == '1' || $imm->measles == 1) !!} 
            &nbsp; No {!! $box($imm->measles == '0' || $imm->measles == 0) !!}
        </td>
    </tr>

    <tr>
        <td>Rubella</td>
        <td colspan="3">
            Yes {!! $box($imm->rubella == '1' || $imm->rubella == 1) !!} 
            &nbsp; No {!! $box($imm->rubella == '0' || $imm->rubella == 0) !!}
        </td>
    </tr>

    <!-- Select-style fields -->
    <tr>
        <td>Hep B Antigen</td>
        <td colspan="3">
            No Proof {!! $box($imm->hep_b_antigen === 'No Proof') !!} 
            &nbsp; Negative {!! $box($imm->hep_b_antigen === 'Negative') !!} 
            &nbsp; Positive {!! $box($imm->hep_b_antigen === 'Positive') !!}
        </td>
    </tr>

    <tr>
        <td>Hep C</td>
        <td colspan="3">
            No Proof {!! $box($imm->hep_c === 'No Proof') !!} 
            &nbsp; Negative {!! $box($imm->hep_c === 'Negative') !!} 
            &nbsp; Positive {!! $box($imm->hep_c === 'Positive') !!}
        </td>
    </tr>

    <tr>
        <td>HIV</td>
        <td colspan="3">
            No Proof {!! $box($imm->hiv === 'No Proof') !!} 
            &nbsp; Negative {!! $box($imm->hiv === 'Negative') !!} 
            &nbsp; Positive {!! $box($imm->hiv === 'Positive') !!}
        </td>
    </tr>

    <tr>
        <td colspan="4" style="font-size:8px;">
            All applications who cannot provide a registered PVG/DBS Number or full immunisation record will be required to complete at their own cost. 
            Candidates will be required to purchase uniform if required at the cost of £20 this will be deducted from your timesheet once you have started working through us.
        </td>
    </tr>

    <tr><td colspan="4">Please sign to say you have read and understood the above</td></tr>

    <!-- Fixed Signature & Date row: compact, same line, no page break -->
    <tr style="page-break-inside: avoid;">
        <td colspan="4" style="padding: 8px 0; font-size: 10px; white-space: nowrap; border-top: none;">
            Signed: {{ $jobApplication->forename . ' ' . $jobApplication->surname }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ $jobApplication->forename . ' ' . $jobApplication->surname }} &nbsp;&nbsp;&nbsp;
            Date: {{ $jobApplication->created_at ? $jobApplication->created_at->format('d/m/Y') : '_________________' }}
        </td>
    </tr>
</table>
<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
<div class="page-break"></div>


{{-- PAGE 6: REGISTRATION DECLARATION FORMS --}}
<div class="header">
    <div class="header-left">358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA<br>T: 01698 701199<br>E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care</div>
    <div class="header-right">@if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif</div>
</div>
<h2>REGISTRATION DECLARATION FORMS</h2>
<p class="instruction">Please read before signing</p>

@php
    // Model already casts JSON to array — no json_decode needed
    $disabilityData      = $jobApplication->disability_declaration      ?? [];
    $healthData          = $jobApplication->health_declaration          ?? [];
    $confData            = $jobApplication->confidentiality_declaration ?? [];
    $photoData           = $jobApplication->photo_consent               ?? [];
    $personalData        = $jobApplication->personal_declaration        ?? [];
    $workingTimeData     = $jobApplication->working_time_declaration    ?? [];
    $otherData           = $jobApplication->other_declaration           ?? [];
    $healthSafetyData    = $jobApplication->health_safety_declaration   ?? [];

    // Use same value for Signed + Print Name (as requested)
    $healthName       = $healthData['signature']       ?? '';
    $healthDate       = $healthData['date']            ?? '';

    $disabilityName   = $disabilityData['signature']   ?? '';
    $disabilityDate   = $disabilityData['date']        ?? '';
    $hasDisability    = $disabilityData['has_disability'] ?? null;

    $confName         = $confData['signature']         ?? '';
    $confDate         = $confData['date']              ?? '';

    $photoName        = $photoData['signature']        ?? '';
    $photoDate        = $photoData['date']             ?? '';

    $personalName     = $personalData['signature']     ?? '';
    $personalDate     = $personalData['date']          ?? '';

    $workingTimeName  = $workingTimeData['signature']  ?? '';
    $workingTimeDate  = $workingTimeData['date']       ?? '';

    $otherName        = $otherData['signature']        ?? '';
    $otherDate        = $otherData['date']             ?? '';

    $healthSafetyName = $healthSafetyData['signature'] ?? '';
    $healthSafetyDate = $healthSafetyData['date']      ?? '';
@endphp

<table>
    <tr><td class="section-title">HEALTH DECLARATIONS</td></tr>
    <tr>
        <td style="font-size:9px;">
            We would ask all OVERSEAS candidates to provide a medical statement from their GP or medical department confirming your state of health. Your details will be passed to our Occupational Health Doctors to establish your fitness for work. Please sign the declaration below to allow ZAN Traders Ltd to release your information for inspection.<br><br>
            I {{ $healthName ?: '_________________' }} consent to ZAN Traders Ltd<br>
            releasing my health and immunisation records for review. I understand that based on this review I may be required to undergo a medical examination to establish my fitness for work.<br><br>
            I confirm that I will immediately inform ZAN Traders Ltd in confidence if I am HIV Positive, Hep B positive or if I have AIDS in accordance with the Department of Health guidelines. I am aware of my obligations regarding MRSA contact and the need for screening. I agree to immediately inform ZAN Traders Ltd should my general condition of health change.<br><br>
            I will inform ZAN Traders Ltd immediately if I discover that I am pregnant. I understand that withholding information or giving false answers may lead to dismissal. I also hereby consent to ZAN Traders Ltd obtaining further information regarding my health from my GP or Occupational Health Department.
        </td>
    </tr>
    <tr>
        <td style="padding: 12px 0; font-size: 10px; white-space: nowrap;">
            Signed: {{ $healthName ?: '_________________' }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ $healthName ?: '_________________' }} &nbsp;&nbsp;&nbsp;
            Date: {{ $healthDate ?: '_________________' }}
        </td>
    </tr>
</table>

<table>
    <tr><td class="section-title">DISABILITY DISCRIMINATION ACT</td></tr>
    <tr>
        <td style="font-size:9px;">
            Applicants with disabilities will be invited for interview if the essential job criteria are met. Do you consider yourself to be a person with a disability as described by the disability discrimination act 1995? i.e. do you consider yourself to be someone who has a physical or mental impairment which has a substantial and long term adverse effect on your ability to carry out normal day to day activities
        </td>
    </tr>
    <tr>
        <td>
            Yes {!! $box($hasDisability === '1' || $hasDisability === 1) !!} 
            &nbsp;&nbsp; 
            No  {!! $box($hasDisability === '0' || $hasDisability === 0) !!}
        </td>
    </tr>
    <tr>
        <td style="padding: 12px 0; font-size: 10px; white-space: nowrap;">
            Signed: {{ $disabilityName ?: '_________________' }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ $disabilityName ?: '_________________' }} &nbsp;&nbsp;&nbsp;
            Date: {{ $disabilityDate ?: '_________________' }}
        </td>
    </tr>
</table>

<table>
    <tr><td class="section-title">CONFIDENTIALITY</td></tr>
    <tr>
        <td style="font-size:9px;">
            I hereby declare that at no time will I divulge to any person, nor use for my own or any other person's benefit, any confidential information...
        </td>
    </tr>
    <tr>
        <td style="padding: 12px 0; font-size: 10px; white-space: nowrap;">
            Signed: {{ $confName ?: '_________________' }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ $confName ?: '_________________' }} &nbsp;&nbsp;&nbsp;
            Date: {{ $confDate ?: '_________________' }}
        </td>
    </tr>
</table>

<table>
    <tr><td class="section-title">CONSENT FOR THE USE OF STAFF PHOTOGRAPHIC IMAGES</td></tr>
    <tr>
        <td style="font-size:9px;">
            To comply with the principle, set out in the Data Protection Act 2018 and GDPR...
        </td>
    </tr>
    <tr>
        <td style="padding: 12px 0; font-size: 10px; white-space: nowrap;">
            Signed: {{ $photoName ?: '_________________' }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ $photoName ?: '_________________' }} &nbsp;&nbsp;&nbsp;
            Date: {{ $photoDate ?: '_________________' }}
        </td>
    </tr>
</table>

<table>
    <tr><td class="section-title">PERSONAL DECLARATIONS</td></tr>
    <tr>
        <td style="font-size:9px;">
            I hereby confirm that the information provided on my application is correct and true...
        </td>
    </tr>
    <tr>
        <td style="padding: 12px 0; font-size: 10px; white-space: nowrap;">
            Signed: {{ $personalName ?: '_________________' }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ $personalName ?: '_________________' }} &nbsp;&nbsp;&nbsp;
            Date: {{ $personalDate ?: '_________________' }}
        </td>
    </tr>
</table>

<table>
    <tr><td class="section-title">WORKING TIME REGULATIONS DECLARATIONS</td></tr>
    <tr>
        <td style="font-size:9px;">
            For the purposes of the Working Time Regulations 1998 (as amended) I, consent to work...
        </td>
    </tr>
    <tr>
        <td style="padding: 12px 0; font-size: 10px; white-space: nowrap;">
            Signed: {{ $workingTimeName ?: '_________________' }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ $workingTimeName ?: '_________________' }} &nbsp;&nbsp;&nbsp;
            Date: {{ $workingTimeDate ?: '_________________' }}
        </td>
    </tr>
</table>

<table>
    <tr><td class="section-title">OTHER DECLARATIONS</td></tr>
    <tr>
        <td style="font-size:9px;">
            In addition, I also consent to work more than the maximum number of hours permitted...
        </td>
    </tr>
    <tr>
        <td style="padding: 12px 0; font-size: 10px; white-space: nowrap;">
            Signed: {{ $otherName ?: '_________________' }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ $otherName ?: '_________________' }} &nbsp;&nbsp;&nbsp;
            Date: {{ $otherDate ?: '_________________' }}
        </td>
    </tr>
</table>

<table>
    <tr><td class="section-title">HEALTH AND SAFETY</td></tr>
    <tr>
        <td style="font-size:9px;">
            Each agency worker has a responsibility at the start of their first shift...
        </td>
    </tr>
    <tr>
        <td style="padding: 12px 0; font-size: 10px; white-space: nowrap;">
            Signed: {{ $healthSafetyName ?: '_________________' }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ $healthSafetyName ?: '_________________' }} &nbsp;&nbsp;&nbsp;
            Date: {{ $healthSafetyDate ?: '_________________' }}
        </td>
    </tr>
</table>

<table>
    <tr><td class="section-title">RIGHT TO WORK IN THE UK</td></tr>
    <tr>
        <td style="font-size:9px;">
            Please complete this form, regardless of your nationality, as it is a legal requirement. If you are an overseas national or require a work permit to work in the UK, please include copies of supporting documentation.<br>
            Your entitlement for working in the UK is based upon what status:
        </td>
    </tr>
    <tr>
        <td style="padding: 8px 0; font-size: 10px;">
            EU Citizen (Visa): {!! $box($jobApplication->right_to_work_status === 'EU Citizen' || $jobApplication->right_to_work_status === 'EU Citizen (Visa)') !!} 
              Spouse of an EU Citizen (Visa): {!! $box($jobApplication->right_to_work_status === 'Spouse of EU Citizen' || $jobApplication->right_to_work_status === 'Spouse of an EU Citizen (Visa)') !!} 
              Work Permit: {!! $box($jobApplication->right_to_work_status === 'Work Permit') !!}
        </td>
    </tr>
    <tr>
        <td style="padding: 8px 0 12px 0; font-size: 10px;">
            Permit-free Visa: {!! $box($jobApplication->right_to_work_status === 'Permit-free Visa') !!} 
              Indefinite leave to remain in uk: {!! $box($jobApplication->right_to_work_status === 'Right of Abode' || $jobApplication->right_to_work_status === 'Right of Abode in the UK') !!} 
              Admitted to UK as Doctor Prior to 1985: {!! $box($jobApplication->right_to_work_status === 'Doctor Prior to 1985' || $jobApplication->right_to_work_status === 'Admitted to UK as Doctor Prior to 1985') !!}
        </td>
    </tr>
</table>

<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
<div class="page-break"></div>

{{-- PAGE 7: REHABILITATION OF OFFENDERS ACT --}}
<div class="header">
    <div class="header-left">358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA<br>T: 01698 701199<br>E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care</div>
    <div class="header-right">@if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif</div>
</div>     

<table> 
    <tr>
        <td class="section-title" colspan="2">REHABILITATION OF OFFENDERS ACT 1974 – Please answer all five questions</td>
    </tr>
    <tr>
        <td colspan="2" style="font-size:8px;">
            Because of the nature of the work for which you are applying, Section 4(2), and further Orders made by the Secretary of State under the provision of this section of the Rehabilitation of Offenders Act (1974) (Exceptions) Order 1975 apply. Applicants are therefore required to give information about convictions which for other purposes are "spent" under the provisions of the Act. Any information given will be completely confidential and will be considered only in relation for positions to which the order applies.
        </td>
    </tr>

    <!-- Question 1 -->
    <tr>
        <td class="label" style="width:70%;">
            1. Do you have any convictions, cautions or bindovers?
        </td>
        <td style="width:30%;">
            Yes {!! $box($jobApplication->has_convictions === true || $jobApplication->has_convictions == 1) !!} 
              No {!! $box($jobApplication->has_convictions === false || $jobApplication->has_convictions == 0) !!}
        </td>
    </tr>
    <tr>
        <td colspan="2" style="font-size:9px; padding: 6px 0;">
            If yes, please give details...<br>
            {{ $jobApplication->convictions_details ?? '' }}
        </td>
    </tr>

    <!-- Question 2 -->
    <tr>
        <td class="label">
            2. Have you ever had disciplinary action taken against you?
        </td>
        <td>
            Yes {!! $box($jobApplication->has_disciplinary === true || $jobApplication->has_disciplinary == 1) !!} 
              No {!! $box($jobApplication->has_disciplinary === false || $jobApplication->has_disciplinary == 0) !!}
        </td>
    </tr>
    <tr>
        <td colspan="2" style="font-size:9px; padding: 6px 0;">
            If yes, please give details...<br>
            {{ $jobApplication->disciplinary_details ?? '' }}
        </td>
    </tr>

    <!-- Question 3 -->
    <tr>
        <td class="label">
            3. Are you at present the subject of criminal charges or disciplinary action?
        </td>
        <td>
            Yes {!! $box($jobApplication->has_criminal_charges === true || $jobApplication->has_criminal_charges == 1) !!} 
              No {!! $box($jobApplication->has_criminal_charges === false || $jobApplication->has_criminal_charges == 0) !!}
        </td>
    </tr>
    <tr>
        <td colspan="2" style="font-size:9px; padding: 6px 0;">
            If yes, please give details...<br>
            {{ $jobApplication->criminal_charges_details ?? '' }}
        </td>
    </tr>

    <!-- Question 4 -->
    <tr>
        <td class="label">
            4. Do you consent to ZAN Traders Ltd requesting a police check and any appropriate references on your behalf?
        </td>
        <td>
            Yes {!! $box($jobApplication->consents_police_check === true || $jobApplication->consents_police_check == 1) !!} 
              No {!! $box($jobApplication->consents_police_check === false || $jobApplication->consents_police_check == 0) !!}
        </td>
    </tr>

    <!-- Question 5 -->
    <tr>
        <td class="label">
            5. Have you been police checked in the last three years?
        </td>
        <td>
            Yes {!! $box($jobApplication->police_checked_recently === true || $jobApplication->police_checked_recently == 1) !!} 
              No {!! $box($jobApplication->police_checked_recently === false || $jobApplication->police_checked_recently == 0) !!}
        </td>
    </tr>
    <tr>
        <td colspan="2" style="font-size:9px; padding: 6px 0;">
            If so, by whom...<br>
            {{ $jobApplication->police_check_details ?? '' }}
        </td>
    </tr>

    <!-- Signature area -->
    <!-- <tr>
        <td colspan="2" style="padding: 16px 0 8px 0; font-size: 10px;">
            Signed: _________________________<br><br>
            Print Name: _________________________<br><br>
            Date: _________________________
        </td>
    </tr> -->
</table>

<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
<div class="page-break"></div>



{{-- PAGE 8: REFERENCES --}}
<div class="header">
    <div class="header-left">358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA<br>T: 01698 701199<br>E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care</div>
    <div class="header-right">@if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif</div>
</div>

<table>
    <tr><td class="section-title" colspan="2">REFERENCE</td></tr>
    <tr><td colspan="2" style="font-size:8px;">
        Give details of the names/addresses of two work-related Referees. One of the Referees should be your current employer, or if presently unemployed or self-employed, your last employer
    </td></tr>

    <!-- Reference 1 -->
    <tr><td class="label" style="width:50%;">Name:</td><td class="label" style="width:50%;">Name:</td></tr>
    <tr>
        <td>{{ $jobApplication->references[0]->name ?? '' }}</td>
        <td>{{ $jobApplication->references[1]->name ?? '' }}</td>
    </tr>

    <tr><td class="label">Position:</td><td class="label">Position:</td></tr>
    <tr>
        <td>{{ $jobApplication->references[0]->position ?? '' }}</td>
        <td>{{ $jobApplication->references[1]->position ?? '' }}</td>
    </tr>

    <tr><td class="label">Company Name and Address:</td><td class="label">Company Name and Address:</td></tr>
    <tr>
        <td>{{ $jobApplication->references[0]->company_address ?? '' }}</td>
        <td>{{ $jobApplication->references[1]->company_address ?? '' }}</td>
    </tr>

    <tr><td class="label">Telephone Number</td><td class="label">Telephone Number</td></tr>
    <tr>
        <td>{{ $jobApplication->references[0]->telephone ?? '' }}</td>
        <td>{{ $jobApplication->references[1]->telephone ?? '' }}</td>
    </tr>

    <tr><td class="label">Email Address:</td><td class="label">Email Address:</td></tr>
    <tr>
        <td>{{ $jobApplication->references[0]->email ?? '' }}</td>
        <td>{{ $jobApplication->references[1]->email ?? '' }}</td>
    </tr>

    <tr><td class="label">May we contact the above person now?</td><td class="label">May we contact the above person now?</td></tr>
    <tr>
        <td>
            Yes {!! $box($jobApplication->references[0]->may_contact_now ?? false) !!} 
              No {!! $box(!($jobApplication->references[0]->may_contact_now ?? false)) !!}
        </td>
        <td>
            Yes {!! $box($jobApplication->references[1]->may_contact_now ?? false) !!} 
              No {!! $box(!($jobApplication->references[1]->may_contact_now ?? false)) !!}
        </td>
    </tr>
</table>

<table>
    <tr><td class="section-title" colspan="3">FOR OFFICE USE ONLY</td></tr>
    <tr>
        <td class="label" style="width:40%;">Application received date:</td>
        <td class="label" style="width:30%;">Interview date:</td>
        <td class="label" style="width:30%;">Outcome:</td>
    </tr>
    <tr>
        <td>{{ $jobApplication->created_at ? $jobApplication->created_at->format('d/m/Y') : '' }}</td>
        <td></td>
        <td></td>
    </tr>
</table>

<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
<div class="page-break"></div>

{{-- PAGE 9: AVAILABILITY --}}
<div class="header">
    <div class="header-left">358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA<br>T: 01698 701199<br>E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care</div>
    <div class="header-right">@if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif</div>
</div>
<h2>AVAILABILITY</h2>
<table>
    <tr><td class="section-title">1. Please indicate when you would like to work. Please tick all relevant boxes.</td></tr>
    <tr><td>Morning (Monday-Sunday) {!! $box($pref('Morning (M-F)')) !!}</td></tr>
    <tr><td>EVENINGS (Monday-Sunday) {!! $box($pref('Evenings (M-F)')) !!}</td></tr>
    <!-- <tr><td>NIGHTS (M-F) {!! $box($pref('Nights (M-F)')) !!}</td></tr>
    <tr><td>Morning (SAT-SUN) {!! $box($pref('Morning (SAT-SUN)')) !!}</td></tr>
    <tr><td>EVENINGS (SAT-SUN) {!! $box($pref('Evenings (SAT-SUN)')) !!}</td></tr> -->
    <tr><td class="label">OTHER (Please specify):</td></tr>
    <tr><td style="min-height:40px;">{{ $jobApplication->availability_other }}</td></tr>
</table>
<table>
    <tr><td class="section-title">3. Availability</td></tr>
    <tr><td class="label" style="width:50%;">When can you start to work:</td><td>{{ $formatDate($jobApplication->start_date) }}</td></tr>
    <tr><td class="label">When can you attend an interview:</td><td>{{ $formatDate($jobApplication->interview_availability) }}</td></tr>
    <tr><td class="label">Do you have any holiday booked?</td><td>Yes {!! $box($jobApplication->has_holidays_booked) !!} &nbsp;&nbsp; No {!! $box(!$jobApplication->has_holidays_booked) !!}</td></tr>
    <tr><td class="label">If yes, please provide the dates:</td><td>{{ $jobApplication->holidays_dates }}</td></tr>
</table>
<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
</body>
</html>
