<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Job Application Form</title>
    <style>
        @page { margin: 18mm 14mm 26mm 14mm; }
        body { font-family: "DejaVu Sans", sans-serif; font-size: 12px; color: #000; line-height: 1.3; }
        h1 { margin: 10px 0 12px 0; font-size: 18px; text-align: center; font-weight: bold; }
        h2 { margin: 8px 0 6px 0; font-size: 14px; text-align: center; font-weight: bold; }
        .header { display: table; width: 100%; margin-bottom: 8px; }
        .header-left { display: table-cell; vertical-align: top; width: 55%; font-size: 12px; line-height: 1.3; font-weight: normal; }
        .header-right { display: table-cell; text-align: right; vertical-align: top; }
        .header-right img { width: 165px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
        .section-title { background: #62c2dd; color: #fff; font-weight: bold; padding: 4px 7px; text-transform: uppercase; font-size: 12px; }
        th, td { border: 1px solid #7fb7cf; padding: 4px 7px; vertical-align: top; font-size: 12px; font-weight: normal; }
        .checkbox { display: inline-block; width: 11px; height: 11px; border: 1px solid #000; text-align: center; line-height: 11px; font-size: 12px; margin-right: 2px; }
        .page-break { page-break-after: always; }
        .footer { position: fixed; bottom: -6mm; left: 14mm; right: 14mm; text-align: center; font-size: 12px; }
        .instruction { font-size: 9px; font-style: italic; text-align: center; margin: 4px 0; }
    </style>
</head>
<body>
@php
    $isBlank = $isBlankPreview ?? false;

    // Placeholder helper
    $ph = function($value, $length = 25) use ($isBlank) {
        return $isBlank ? str_repeat('_', $length) : ($value ?? '');
    };

    // Date formatter
    $formatDate = function($value) use ($isBlank) {
        return $isBlank ? 'DD / MM / YYYY' : (optional($value)->format('d/m/Y') ?? '');
    };

    // Checkbox (unchecked in blank mode)
    $box = fn($checked = false) => '<span class="checkbox">' . ($checked ? '✓' : '&nbsp;') . '</span>';

    $prefs = $isBlank ? [] : ($jobApplication->work_preferences ?? []);
    $pref = fn($label) => in_array($label, $prefs);

    $logoPath = public_path('img/logo.png');
    $logoExists = file_exists($logoPath);

    // Blank signature/date helpers
    $blankSig = '___________________________';
    $blankDate = '_______________';
@endphp

{{-- PAGE 1 --}}
<div class="header">
    <div class="header-left">358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA<br>T: 01698 701199<br>E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care</div>
    <div class="header-right">@if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif</div>
</div>
<h1>Job Application Form</h1>

<table>
    <tr><td class="section-title" colspan="2">PERSONAL DETAILS</td></tr>
    <tr>
        <td style="width:50%;">Title: {{ $ph($jobApplication->title, 10) }}</td>
        <td style="width:50%;">Date of birth: {{ $formatDate($jobApplication->date_of_birth) }}</td>
    </tr>
    <tr><td colspan="2">Forename: {{ $ph($jobApplication->forename) }}</td></tr>
    <tr><td colspan="2">Surname: {{ $ph($jobApplication->surname) }}</td></tr>
    <tr><td colspan="2">Previous Name: {{ $ph($jobApplication->previous_name) }}</td></tr>
    <tr>
        <td>Gender: {{ $ph($jobApplication->gender, 15) }}</td>
        <td>Marital status: {{ $ph($jobApplication->marital_status, 15) }}</td>
    </tr>
    <tr><td colspan="2">NI Number: {{ $ph($jobApplication->ni_number, 20) }}</td></tr>
</table>

<table>
    <tr><td class="section-title" colspan="2">ADDRESS</td></tr>
    <tr><td colspan="2" style="min-height:30px;">Address: {{ $ph($jobApplication->address, 60) }}</td></tr>
    <tr><td colspan="2">Postcode: {{ $ph($jobApplication->postcode, 10) }}</td></tr>
</table>

<table>
    <tr><td class="section-title" colspan="2">WAYS TO CONTACT YOU</td></tr>
    <tr>
        <td style="width:50%;">Mobile Number: {{ $ph($jobApplication->mobile_number, 15) }}</td>
        <td style="width:50%;">Landline: {{ $ph($jobApplication->landline, 15) }}</td>
    </tr>
    <tr><td colspan="2">Email: {{ $ph($jobApplication->email, 40) }}</td></tr>
</table>

<table>
    <tr><td class="section-title" colspan="2">EMERGENCY CONTACT</td></tr>
    <tr><td colspan="2">Next of Kin: {{ $ph($jobApplication->next_of_kin_name) }}</td></tr>
    <tr><td colspan="2">Name: {{ $ph($jobApplication->next_of_kin_name) }}</td></tr>
    <tr>
        <td style="width:50%;">Relationship: {{ $ph($jobApplication->next_of_kin_relationship, 20) }}</td>
        <td style="width:50%;">Phone: {{ $ph($jobApplication->next_of_kin_phone, 15) }}</td>
    </tr>
    <tr><td colspan="2">Address: {{ $ph($jobApplication->next_of_kin_address, 60) }}</td></tr>
    <tr>
        <td style="width:50%;">Postcode: {{ $ph($jobApplication->next_of_kin_postcode, 10) }}</td>
        <td style="width:50%;">Email: {{ $ph($jobApplication->next_of_kin_email, 40) }}</td>
    </tr>
</table>

<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
<div class="page-break"></div>

{{-- PAGE 2 – WORK HISTORY --}}
<div class="header">
    <div class="header-left">358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA<br>T: 01698 701199<br>E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care</div>
    <div class="header-right">@if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif</div>
</div>

<h2>WORK HISTORY</h2>
<p class="instruction">Please ensure you complete this section even if you have a CV. Please ensure that you leave no gaps unaccounted for and it covers 10 years.</p>

<table>
    <tr><td class="section-title" colspan="2">CURRENT JOB</td></tr>
    <tr>
        <td style="width:50%;">Job title: {{ $ph($jobApplication->current_job_title, 30) }}</td>
        <td style="width:50%;">Current Pay p/h: £{{ $ph($jobApplication->current_pay_amount, 8) }}</td>
    </tr>
    <tr><td colspan="2">Duties: {{ $ph($jobApplication->current_duties, 80) }}</td></tr>
    <tr>
        <td>Current Place of Work: {{ $ph($jobApplication->current_place_of_work, 40) }}</td>
        <td>Day/Night Shift: {{ $ph($jobApplication->current_shift_type, 15) }}</td>
    </tr>
</table>

@for($i = 0; $i < 3; $i++)
    <table>
        <tr><td class="section-title" colspan="2">PREVIOUS JOB</td></tr>
        <tr>
            <td style="width:50%;">From: {{ $isBlank ? 'MM/YYYY' : '' }}</td>
            <td style="width:50%;">To: {{ $isBlank ? 'MM/YYYY' : '' }}</td>
        </tr>
        <tr><td colspan="2">Name of Employer: {{ $ph('', 40) }}</td></tr>
        <tr><td colspan="2">Job Title: {{ $ph('', 30) }}</td></tr>
        <tr><td colspan="2">Main Responsibilities: {{ $ph('', 80) }}</td></tr>
        <tr><td colspan="2">Address: {{ $ph('', 60) }}</td></tr>
        <tr><td colspan="2">Reason for Leaving: {{ $ph('', 40) }}</td></tr>
    </table>
@endfor

<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
<div class="page-break"></div>

{{-- PAGE 4 – EDUCATION & TRAINING --}}
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
    @for($i = 0; $i < 7; $i++)
    <tr>
        <td style="min-height:22px;">{{ $ph('', 35) }}</td>
        <td>{{ $isBlank ? 'YYYY' : '' }}</td>
        <td>{{ $isBlank ? 'YYYY' : '' }}</td>
        <td>{{ $ph('', 25) }}</td>
        <td>{{ $ph('', 10) }}</td>
    </tr>
    @endfor
</table>

@php
    $trainingList = [
        'moving_handling' => 'Moving and Handling',
        'basic_life_support' => 'Basic Life Support',
        'intermediate_life_support' => 'Intermediate Life Support',
        'advance_life_support' => 'Advanced Life Support',
        'handling_violence' => 'Handling Violence and Aggression',
        'fire_safety' => 'Fire Safety',
        'coshh' => 'COSHH',
        'riddor' => 'RIDDOR',
        'data_protection' => 'Data Protection',
        'complaints_handling' => 'Complaints Handling',
        'caldicott_protocols' => 'Caldicott Protocols',
        'infection_control' => 'Infection Control',
        'lone_worker' => 'Lone Worker Training',
        'food_hygiene' => 'Food Hygiene (where required to handle food)',
        'personal_safety' => 'Personal Safety (Mental Health and Learning Dis.)',
        'covid_19' => 'Covid-19',
    ];
@endphp

<table>
    <tr><td class="section-title">MANDATORY TRAINING</td></tr>
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
                    {{ $label }}: {!! $box(false) !!}
                </td>
            @endforeach
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

{{-- PAGE 5 – PROFESSIONAL, BANK, DRIVING, IMMUNISATIONS --}}
<div class="header">
    <div class="header-left">358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA<br>T: 01698 701199<br>E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care</div>
    <div class="header-right">@if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif</div>
</div>

<h2>PROFESSIONAL MEMBERSHIPS</h2>
<p class="instruction">Please enclose, with your application a copy of your registration and membership card</p>

<table>
    <tr><td class="section-title" colspan="2">PROFESSIONAL MEMBERSHIP DETAILS</td></tr>
    <tr><td colspan="2">Professional Body/Type: {{ $ph($jobApplication->professional_body, 40) }}</td></tr>
    <tr><td colspan="2">PIN (if applicable): {{ $ph($jobApplication->pin, 20) }}</td></tr>
    <tr><td colspan="2">Renewal Date (if applicable): {{ $formatDate($jobApplication->renewal_date) }}</td></tr>
    <tr>
        <td style="width:50%;">Current PVG/DBS: {{ $ph($jobApplication->pvg_number, 20) }}</td>
        <td style="width:50%;">Clear: {!! $box(false) !!} Yes &nbsp;&nbsp; {!! $box(false) !!} No</td>
    </tr>
    <tr>
        <td>Issue Date: {{ $formatDate($jobApplication->pvg_issue_date) }}</td>
        <td>PVG/DBS Number: {{ $ph($jobApplication->pvg_number, 20) }}</td>
    </tr>
    <tr><td colspan="2">Registered with update service? {!! $box(false) !!} Yes &nbsp;&nbsp; {!! $box(false) !!} No</td></tr>
</table>

<table>
    <tr><td class="section-title" colspan="2">BANK PAYMENT DETAILS</td></tr>
    <tr><td colspan="2">Name of Bank/Building Society: {{ $ph($jobApplication->bank_name, 40) }}</td></tr>
    <tr>
        <td style="width:50%;">Account Name: {{ $ph($jobApplication->account_name, 30) }}</td>
        <td>Account Type: Personal</td>
    </tr>
    <tr><td colspan="2">Branch Address: {{ $ph($jobApplication->bank_branch_address, 60) }}</td></tr>
    <tr><td colspan="2">Postcode: {{ $ph($jobApplication->bank_postcode, 10) }}</td></tr>
    <tr>
        <td>Account No.: {{ $ph($jobApplication->account_number, 15) }}</td>
        <td>Sort code: {{ $ph($jobApplication->sort_code, 10) }}</td>
    </tr>
</table>

<table>
    <tr><td class="section-title" colspan="2">DRIVING DETAILS</td></tr>
    <tr><td colspan="2">Do you hold a valid UK driver's licence? {!! $box(false) !!} Yes &nbsp;&nbsp; {!! $box(false) !!} No</td></tr>
    <tr><td colspan="2">Do you have use of a car? {!! $box(false) !!} Yes &nbsp;&nbsp; {!! $box(false) !!} No</td></tr>
</table>

@php $imm = optional($jobApplication->immunisation); @endphp
<table style="page-break-inside: avoid;">
    <tr><td class="section-title" colspan="4">IMMUNISATIONS</td></tr>
    <tr>
        <td colspan="4" style="font-size:8px;">
            Please indicate which of the following Immunisations you have been vaccinated against and include your vaccination reports when returning your registration.
        </td>
    </tr>

    <tr>
        <td style="width:20%;">Hep B</td>
        <td style="width:30%;">Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td>
        <td style="width:20%;">TB</td>
        <td>Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td>
    </tr>

    <tr>
        <td>Varicella</td>
        <td>Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td>
        <td>Measles</td>
        <td>Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td>
    </tr>

    <tr>
        <td>Rubella</td>
        <td colspan="3">Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td>
    </tr>

    <tr>
        <td>Hep B Antigen</td>
        <td colspan="3">
            No Proof {!! $box(false) !!} &nbsp; Negative {!! $box(false) !!} &nbsp; Positive {!! $box(false) !!}
        </td>
    </tr>

    <tr>
        <td>Hep C</td>
        <td colspan="3">
            No Proof {!! $box(false) !!} &nbsp; Negative {!! $box(false) !!} &nbsp; Positive {!! $box(false) !!}
        </td>
    </tr>

    <tr>
        <td>HIV</td>
        <td colspan="3">
            No Proof {!! $box(false) !!} &nbsp; Negative {!! $box(false) !!} &nbsp; Positive {!! $box(false) !!}
        </td>
    </tr>

    <tr>
        <td colspan="4" style="font-size:8px;">
            All applications who cannot provide a registered PVG/DBS Number or full immunisation record will be required to complete at their own cost. 
            Candidates will be required to purchase uniform if required at the cost of £20 this will be deducted from your timesheet once you have started working through us.
        </td>
    </tr>

    <tr><td colspan="4">Please sign to say you have read and understood the above</td></tr>

    <tr style="page-break-inside: avoid;">
        <td colspan="4" style="padding: 8px 0; font-size: 10px; white-space: nowrap; border-top: none;">
            Signed: {{ $isBlank ? $blankSig : ($jobApplication->forename . ' ' . $jobApplication->surname) }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ $isBlank ? $blankSig : ($jobApplication->forename . ' ' . $jobApplication->surname) }} &nbsp;&nbsp;&nbsp;
            Date: {{ $isBlank ? $blankDate : ($jobApplication->created_at ? $jobApplication->created_at->format('d/m/Y') : '_________________') }}
        </td>
    </tr>
</table>

<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
<div class="page-break"></div>

{{-- PAGE 6 – REGISTRATION DECLARATION FORMS --}}
<div class="header">
    <div class="header-left">358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA<br>T: 01698 701199<br>E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care</div>
    <div class="header-right">@if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif</div>
</div>

<h2>REGISTRATION DECLARATION FORMS</h2>
<p class="instruction">Please read before signing</p>

<table>
    <tr><td class="section-title">HEALTH DECLARATIONS</td></tr>
    <tr>
        <td style="font-size:9px;">
            We would ask all OVERSEAS candidates to provide a medical statement from their GP or medical department confirming your state of health. Your details will be passed to our Occupational Health Doctors to establish your fitness for work. Please sign the declaration below to allow ZAN Traders Ltd to release your information for inspection.<br><br>
            I {{ $isBlank ? $blankSig : ($healthName ?: '_________________') }} consent to ZAN Traders Ltd<br>
            releasing my health and immunisation records for review. I understand that based on this review I may be required to undergo a medical examination to establish my fitness for work.<br><br>
            I confirm that I will immediately inform ZAN Traders Ltd in confidence if I am HIV Positive, Hep B positive or if I have AIDS in accordance with the Department of Health guidelines. I am aware of my obligations regarding MRSA contact and the need for screening. I agree to immediately inform ZAN Traders Ltd should my general condition of health change.<br><br>
            I will inform ZAN Traders Ltd immediately if I discover that I am pregnant. I understand that withholding information or giving false answers may lead to dismissal. I also hereby consent to ZAN Traders Ltd obtaining further information regarding my health from my GP or Occupational Health Department.
        </td>
    </tr>
    <tr>
        <td style="padding: 12px 0; font-size: 10px; white-space: nowrap;">
            Signed: {{ $isBlank ? $blankSig : ($healthName ?: '_________________') }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ $isBlank ? $blankSig : ($healthName ?: '_________________') }} &nbsp;&nbsp;&nbsp;
            Date: {{ $isBlank ? $blankDate : ($healthDate ?: '_________________') }}
        </td>
    </tr>
</table>

<table>
    <tr><td class="section-title">DISABILITY DISCRIMINATION ACT</td></tr>
    <tr>
        <td style="font-size:9px;">
            Applicants with disabilities will be invited for interview if the essential job criteria are met. Do you consider yourself to be a person with a disability as described by the disability discrimination act 1995? ...
        </td>
    </tr>
    <tr>
        <td>
            Yes {!! $box(false) !!} &nbsp;&nbsp; 
            No {!! $box(false) !!}
        </td>
    </tr>
    <tr>
        <td style="padding: 12px 0; font-size: 10px; white-space: nowrap;">
            Signed: {{ $isBlank ? $blankSig : ($disabilityName ?: '_________________') }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ $isBlank ? $blankSig : ($disabilityName ?: '_________________') }} &nbsp;&nbsp;&nbsp;
            Date: {{ $isBlank ? $blankDate : ($disabilityDate ?: '_________________') }}
        </td>
    </tr>
</table>

<!-- Repeat the same pattern for all other declarations -->

<table>
    <tr><td class="section-title">CONFIDENTIALITY</td></tr>
    <tr>
        <td style="font-size:9px;">
            I hereby declare that at no time will I divulge to any person...
        </td>
    </tr>
    <tr>
        <td style="padding: 12px 0; font-size: 10px; white-space: nowrap;">
            Signed: {{ $isBlank ? $blankSig : ($confName ?: '_________________') }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ $isBlank ? $blankSig : ($confName ?: '_________________') }} &nbsp;&nbsp;&nbsp;
            Date: {{ $isBlank ? $blankDate : ($confDate ?: '_________________') }}
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
            Signed: {{ '_________________' }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ '_________________' }} &nbsp;&nbsp;&nbsp;
            Date: {{ '_________________' }}
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
            Signed: {{ '_________________' }} &nbsp;&nbsp;&nbsp;
            Print Name: '_________________' }} &nbsp;&nbsp;&nbsp;
            Date: {{ '_________________' }}
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
            Signed: {{  '_________________' }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ '_________________' }} &nbsp;&nbsp;&nbsp;
            Date: {{ '_________________' }}
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
            Signed: {{ '_________________' }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ '_________________' }} &nbsp;&nbsp;&nbsp;
            Date: {{ '_________________' }}
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
            Signed: {{'_________________' }} &nbsp;&nbsp;&nbsp;
            Print Name: {{ '_________________' }} &nbsp;&nbsp;&nbsp;
            Date: {{ '_________________' }}
        </td>
    </tr>
</table>
<table>
    <tr><td class="section-title">RIGHT TO WORK IN THE UK</td></tr>
    <tr>
        <td style="font-size:9px;">
            Please complete this form, regardless of your nationality...
        </td>
    </tr>
    <tr>
        <td style="padding: 8px 0; font-size: 10px;">
            EU Citizen (Visa): {!! $box(false) !!} 
              Spouse of an EU Citizen (Visa): {!! $box(false) !!} 
              Work Permit: {!! $box(false) !!}
        </td>
    </tr>
    <tr>
        <td style="padding: 8px 0 12px 0; font-size: 10px;">
            Permit-free Visa: {!! $box(false) !!} 
              Indefinite leave to remain: {!! $box(false) !!} 
              Admitted to UK as Doctor Prior to 1985: {!! $box(false) !!}
        </td>
    </tr>
</table>

<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
<div class="page-break"></div>

{{-- PAGE 7 – REHABILITATION OF OFFENDERS ACT --}}
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

    <tr>
        <td class="label" style="width:70%;">1. Do you have any convictions, cautions or bindovers?</td>
        <td style="width:30%;">Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="font-size:9px; padding: 6px 0;">
            If yes, please give details...<br>{{ $ph('', 90) }}
        </td>
    </tr>

    <tr>
        <td class="label">2. Have you ever had disciplinary action taken against you?</td>
        <td>Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="font-size:9px; padding: 6px 0;">
            If yes, please give details...<br>{{ $ph('', 90) }}
        </td>
    </tr>

    <tr>
        <td class="label">3. Are you at present the subject of criminal charges or disciplinary action?</td>
        <td>Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="font-size:9px; padding: 6px 0;">
            If yes, please give details...<br>{{ $ph('', 90) }}
        </td>
    </tr>

    <tr>
        <td class="label">4. Do you consent to ZAN Traders Ltd requesting a police check and any appropriate references on your behalf?</td>
        <td>Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td>
    </tr>

    <tr>
        <td class="label">5. Have you been police checked in the last three years?</td>
        <td>Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td>
    </tr>
    <tr>
        <td colspan="2" style="font-size:9px; padding: 6px 0;">
            If so, by whom...<br>{{ $ph('', 50) }}
        </td>
    </tr>
</table>

<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
<div class="page-break"></div>

{{-- PAGE 8 – REFERENCES --}}
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
        <td>{{ $ph('', 30) }}</td>
        <td>{{ $ph('', 30) }}</td>
    </tr>

    <tr><td class="label">Position:</td><td class="label">Position:</td></tr>
    <tr>
        <td>{{ $ph('', 30) }}</td>
        <td>{{ $ph('', 30) }}</td>
    </tr>

    <tr><td class="label">Company Name and Address:</td><td class="label">Company Name and Address:</td></tr>
    <tr>
        <td>{{ $ph('', 50) }}</td>
        <td>{{ $ph('', 50) }}</td>
    </tr>

    <tr><td class="label">Telephone Number</td><td class="label">Telephone Number</td></tr>
    <tr>
        <td>{{ $ph('', 20) }}</td>
        <td>{{ $ph('', 20) }}</td>
    </tr>

    <tr><td class="label">Email Address:</td><td class="label">Email Address:</td></tr>
    <tr>
        <td>{{ $ph('', 35) }}</td>
        <td>{{ $ph('', 35) }}</td>
    </tr>

    <tr><td class="label">May we contact the above person now?</td><td class="label">May we contact the above person now?</td></tr>
    <tr>
        <td>Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td>
        <td>Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td>
    </tr>

    <!-- Reference 2 – same structure -->
    <tr><td class="label" style="width:50%;">Name:</td><td class="label" style="width:50%;">Name:</td></tr>
    <tr>
        <td>{{ $ph('', 30) }}</td>
        <td>{{ $ph('', 30) }}</td>
    </tr>
    <!-- ... repeat Position, Company, Phone, Email, Contact now ... -->
</table>

<table>
    <tr><td class="section-title" colspan="3">FOR OFFICE USE ONLY</td></tr>
    <tr>
        <td class="label" style="width:40%;">Application received date:</td>
        <td class="label" style="width:30%;">Interview date:</td>
        <td class="label" style="width:30%;">Outcome:</td>
    </tr>
    <tr>
        <td>{{ $isBlank ? 'DD/MM/YYYY' : '' }}</td>
        <td></td>
        <td></td>
    </tr>
</table>

<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
<div class="page-break"></div>

{{-- PAGE 9 – AVAILABILITY --}}
<div class="header">
    <div class="header-left">358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA<br>T: 01698 701199<br>E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care</div>
    <div class="header-right">@if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif</div>
</div>

<h2>AVAILABILITY</h2>
<table>
    <tr><td class="section-title">1. Please indicate when you would like to work. Please tick all relevant boxes.</td></tr>
    <tr><td>Morning (Monday-Sunday) {!! $box(false) !!}</td></tr>
    <tr><td>EVENINGS (Monday-Sunday) {!! $box(false) !!}</td></tr>
    <tr><td class="label">OTHER (Please specify):</td></tr>
    <tr><td style="min-height:40px;">{{ $ph('', 60) }}</td></tr>
</table>

<table>
    <tr><td class="section-title">3. Availability</td></tr>
    <tr><td class="label" style="width:50%;">When can you start to work:</td><td>{{ $formatDate($jobApplication->start_date) }}</td></tr>
    <tr><td class="label">When can you attend an interview:</td><td>{{ $formatDate($jobApplication->interview_availability) }}</td></tr>
    <tr><td class="label">Do you have any holiday booked?</td><td>Yes {!! $box(false) !!} &nbsp;&nbsp; No {!! $box(false) !!}</td></tr>
    <tr><td class="label">If yes, please provide the dates:</td><td>{{ $ph('', 40) }}</td></tr>
</table>

<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
</body>
</html>