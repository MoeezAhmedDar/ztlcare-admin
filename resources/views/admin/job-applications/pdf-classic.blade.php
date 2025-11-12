<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Job Application - {{ $jobApplication->forename }} {{ $jobApplication->surname }}</title>
    <style>
        @page {
            margin: 20mm 15mm 22mm 15mm;
        }
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 9px;
            color: #000;
            line-height: 1.2;
        }
        h1 { 
            margin: 8px 0 10px 0; 
            font-size: 20px; 
            letter-spacing: 0.5px; 
            text-align: center;
        }
        h2 {
            font-size: 16px;
            text-align: center;
            margin: 10px 0 8px 0;
        }
        p { margin: 0; }
        .header {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        .header-left {
            display: table-cell;
            vertical-align: top;
            width: 55%;
            font-size: 9px;
            line-height: 1.3;
        }
        .header-left strong {
            font-size: 10px;
        }
        .header-right {
            display: table-cell;
            text-align: right;
            vertical-align: top;
        }
        .header-right img {
            width: 140px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .section-title {
            background: #62c2dd;
            color: #fff;
            font-weight: bold;
            padding: 5px 8px;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: 0.4px;
        }
        th, td {
            border: 1px solid #7fb7cf;
            padding: 4px 6px;
            vertical-align: top;
        }
        .label {
            background: #e7f3f9;
            font-weight: bold;
            font-size: 9px;
        }
        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            text-align: center;
            line-height: 12px;
            font-size: 10px;
            margin-right: 3px;
        }
        .page-break { 
            page-break-after: always; 
        }
        .footer {
            position: fixed;
            bottom: 8mm;
            left: 15mm;
            right: 15mm;
            text-align: center;
            font-size: 9px;
            color: #000;
        }
        .footer strong {
            font-weight: bold;
        }
        .instruction-text {
            font-size: 9px;
            font-style: italic;
            text-align: center;
            margin: 5px 0;
        }
        ul {
            margin: 5px 0;
            padding-left: 15px;
        }
        ul li {
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
@php
    $box = fn($checked) => '<span class="checkbox">' . ($checked ? '✓' : '&nbsp;') . '</span>';
    $yesNo = fn($value) => $box((bool)$value) . ' Yes&nbsp;&nbsp;' . $box(isset($value) ? !(bool)$value : false) . ' No';
    $formatDate = fn($value) => optional($value)->format('d/m/Y') ?? '';
    $prefs = $jobApplication->work_preferences ?? [];
    $pref = fn($label) => in_array($label, $prefs ?? []);
    $declaration = fn($group) => [
        'signature' => data_get($jobApplication, $group.'.signature'),
        'date' => optional(data_get($jobApplication, $group.'.date'))->format('d/m/Y'),
        'print' => data_get($jobApplication, $group.'.print'),
    ];
    $health = $declaration('health_declaration');
    $disability = $declaration('disability_declaration');
    $confidentiality = $declaration('confidentiality_declaration');
    $photo = $declaration('photo_consent');
    $personal = $declaration('personal_declaration');
    $working = $declaration('working_time_declaration');
    $otherDecl = $declaration('other_declaration');
    $healthSafety = $declaration('health_safety_declaration');
    $rightToWorkOptions = [
        'EU Citizen' => 'EU Citizen (Visa)',
        'Spouse of EU Citizen' => 'Spouse of an EU Citizen (Visa)',
        'Work Permit' => 'Work Permit',
        'Permit-free Visa' => 'Permit-free Visa',
        'Right of Abode' => 'Right of Abode in the UK',
        'Doctor Prior to 1985' => 'Admitted to UK as Doctor Prior to 1985',
    ];
    $rightToWork = $jobApplication->right_to_work_status;
    $imm = optional($jobApplication->immunisation);
    $immOptions = [
        'Yes' => fn($value) => strtolower($value ?? '') === 'yes' || $value === true,
        'No' => fn($value) => strtolower($value ?? '') === 'no' || $value === false,
        'No Proof' => fn($value) => strtolower($value ?? '') === 'no_proof',
        'Negative' => fn($value) => strtolower($value ?? '') === 'negative',
        'Positive' => fn($value) => strtolower($value ?? '') === 'positive',
    ];
    $immunisationRow = function ($label, $value, $extended = false) use ($immOptions, $box) {
        $options = $extended ? ['No Proof', 'Negative', 'Positive'] : ['Yes', 'No'];
        $cells = [];
        foreach ($options as $opt) {
            $check = $immOptions[$opt];
            $cells[] = $box($check($value)) . ' ' . $opt;
        }
        return [$label, implode(' &nbsp; ', $cells)];
    };
    $boolAnswer = fn($value, $details = '') => [
        $yesNo($value),
        trim($details ?? '') !== '' ? $details : 'N/A',
    ];
    $statusBadge = strtoupper(str_replace('_', ' ', $jobApplication->status));
    $logoPath = public_path('img/logo.png');
    $logoExists = file_exists($logoPath);
@endphp

{{-- PAGE 1: PERSONAL DETAILS --}}
<div class="header">
    <div class="header-left">
        <strong>358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA</strong><br>
        <strong>T:</strong> 01698 701199<br>
        <strong>E:</strong> info@ztl.care <strong>W:</strong> www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)
            <img src="{{ $logoPath }}" alt="ZTL Care Logo">
        @endif
    </div>
</div>

<h1>Job Application Form</h1>

<table>
    <tr><td class="section-title" colspan="2">PERSONAL DETAILS</td></tr>
    <tr>
        <td class="label" style="width:25%;">Title:</td>
        <td style="width:25%;">{{ $jobApplication->title }}</td>
        <td class="label" style="width:25%;">Date of birth:</td>
        <td>{{ $formatDate($jobApplication->date_of_birth) }}</td>
    </tr>
    <tr>
        <td class="label">Forename:</td>
        <td>{{ $jobApplication->forename }}</td>
        <td class="label">Surname:</td>
        <td>{{ $jobApplication->surname }}</td>
    </tr>
    <tr>
        <td class="label">Previous Name:</td>
        <td colspan="3">{{ $jobApplication->previous_name }}</td>
    </tr>
    <tr>
        <td class="label">Gender:</td>
        <td>{{ $jobApplication->gender }}</td>
        <td class="label">Marital status:</td>
        <td>{{ $jobApplication->marital_status }}</td>
    </tr>
    <tr>
        <td class="label">NI Number:</td>
        <td colspan="3">{{ $jobApplication->ni_number }}</td>
    </tr>
</table>

<table>
    <tr><td class="section-title" colspan="2">ADDRESS:</td></tr>
    <tr>
        <td colspan="2" style="min-height:35px;">{{ $jobApplication->address }}</td>
    </tr>
    <tr>
        <td class="label" style="width:25%;">Postcode:</td>
        <td>{{ $jobApplication->postcode }}</td>
    </tr>
</table>

<table>
    <tr><td class="section-title" colspan="2">WAYS TO CONTACT YOU:</td></tr>
    <tr>
        <td class="label" style="width:25%;">Mobile Number</td>
        <td>{{ $jobApplication->mobile_number }}</td>
    </tr>
    <tr>
        <td class="label">Landline:</td>
        <td>{{ $jobApplication->landline }}</td>
    </tr>
    <tr>
        <td class="label">Email:</td>
        <td>{{ $jobApplication->email }}</td>
    </tr>
</table>

<table>
    <tr><td class="section-title" colspan="2">EMERGENCY CONTACT:</td></tr>
    <tr>
        <td class="label" style="width:25%;">Next of Kin:</td>
        <td>{{ $jobApplication->next_of_kin_name }}</td>
    </tr>
    <tr>
        <td class="label">Name:</td>
        <td>{{ $jobApplication->next_of_kin_name }}</td>
    </tr>
    <tr>
        <td class="label">Relationship:</td>
        <td style="width:25%;">{{ $jobApplication->next_of_kin_relationship }}</td>
        <td class="label" style="width:25%;">Phone:</td>
        <td>{{ $jobApplication->next_of_kin_phone }}</td>
    </tr>
    <tr>
        <td class="label">Address:</td>
        <td colspan="3">{{ $jobApplication->next_of_kin_address }}</td>
    </tr>
    <tr>
        <td class="label">Postcode:</td>
        <td>{{ $jobApplication->next_of_kin_postcode }}</td>
        <td class="label">Email:</td>
        <td>{{ $jobApplication->next_of_kin_email }}</td>
    </tr>
</table>

<div class="page-break"></div>

{{-- PAGE 2: WORK HISTORY --}}
<div class="header">
    <div class="header-left">
        <strong>358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA</strong><br>
        <strong>T:</strong> 01698 701199<br>
        <strong>E:</strong> info@ztl.care <strong>W:</strong> www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)
            <img src="{{ $logoPath }}" alt="ZTL Care Logo">
        @endif
    </div>
</div>

<h2>WORK HISTORY</h2>
<p class="instruction-text">Please ensure you complete this section even if you have a CV. Please ensure that you leave no gaps unaccounted for and it covers 10 years.</p>

<table>
    <tr><td class="section-title" colspan="2">CURRENT JOB</td></tr>
    <tr>
        <td class="label" style="width:30%;">Job title:</td>
        <td style="width:40%;">{{ $jobApplication->current_job_title }}</td>
        <td class="label" style="width:30%;">Current Pay p/h: £</td>
        <td>{{ $jobApplication->current_pay }}</td>
    </tr>
    <tr>
        <td class="label">Duties:</td>
        <td colspan="3">{{ $jobApplication->current_duties }}</td>
    </tr>
    <tr>
        <td class="label">Current Place of Work:</td>
        <td>{{ $jobApplication->current_place_of_work }}</td>
        <td class="label">Day/Night Shift:</td>
        <td>{{ $jobApplication->current_shift_type }}</td>
    </tr>
</table>

@php
    $workHistories = $jobApplication->workHistories;
    $historyCount = $workHistories->count();
    // Show at least 4 previous job blocks
    $minBlocks = 4;
    $blocksToShow = max($minBlocks, $historyCount);
@endphp

@for($i = 0; $i < min(3, $blocksToShow); $i++)
    @php $history = $workHistories[$i] ?? null; @endphp
    <table>
        <tr><td class="section-title" colspan="2">PREVIOUS JOB</td></tr>
        <tr>
            <td class="label" style="width:30%;">From:</td>
            <td style="width:20%;">{{ $history ? optional($history->from_date)->format('m/Y') : '' }}</td>
            <td class="label" style="width:30%;">To:</td>
            <td>{{ $history ? optional($history->to_date)->format('m/Y') : '' }}</td>
        </tr>
        <tr>
            <td class="label">Name of Employer:</td>
            <td colspan="3">{{ $history->employer_name ?? '' }}</td>
        </tr>
        <tr>
            <td class="label">Job Title:</td>
            <td colspan="3">{{ $history->job_title ?? '' }}</td>
        </tr>
        <tr>
            <td class="label">Main Responsibilities:</td>
            <td colspan="3">{{ $history->main_responsibilities ?? '' }}</td>
        </tr>
        <tr>
            <td class="label">Address:</td>
            <td colspan="3">{{ $history->employer_address ?? '' }}</td>
        </tr>
        <tr>
            <td class="label">Reason for Leaving:</td>
            <td colspan="3">{{ $history->reason_for_leaving ?? '' }}</td>
        </tr>
    </table>
@endfor

@if($blocksToShow > 3)
    <div class="page-break"></div>
    
    {{-- PAGE 3: MORE WORK HISTORY --}}
    @for($i = 3; $i < $blocksToShow; $i++)
        @php $history = $workHistories[$i] ?? null; @endphp
        <table>
            <tr><td class="section-title" colspan="2">PREVIOUS JOB</td></tr>
            <tr>
                <td class="label" style="width:30%;">From:</td>
                <td style="width:20%;">{{ $history ? optional($history->from_date)->format('m/Y') : '' }}</td>
                <td class="label" style="width:30%;">To:</td>
                <td>{{ $history ? optional($history->to_date)->format('m/Y') : '' }}</td>
            </tr>
            <tr>
                <td class="label">Name of Employer:</td>
                <td colspan="3">{{ $history->employer_name ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Job Title:</td>
                <td colspan="3">{{ $history->job_title ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Main Responsibilities:</td>
                <td colspan="3">{{ $history->main_responsibilities ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Address:</td>
                <td colspan="3">{{ $history->employer_address ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Reason for Leaving:</td>
                <td colspan="3">{{ $history->reason_for_leaving ?? '' }}</td>
            </tr>
        </table>
    @endfor
@endif

<div class="page-break"></div>

<table>
    <tr><td class="section-title" colspan="6">Professional Memberships</td></tr>
    <tr>
        <td class="label">Professional body/type</td><td colspan="2">{{ $jobApplication->professional_body }}</td>
        <td class="label">PIN</td><td colspan="2">{{ $jobApplication->pin }}</td>
    </tr>
    <tr>
        <td class="label">Renewal date</td><td colspan="2">{{ $formatDate($jobApplication->renewal_date) }}</td>
        <td class="label">Current PVG/DBS</td><td colspan="2">{{ $jobApplication->pvg_number }}</td>
    </tr>
    <tr>
        <td class="label">Issue date</td><td>{{ $formatDate($jobApplication->pvg_issue_date) }}</td>
        <td class="label">Clear</td><td>{!! $yesNo($jobApplication->pvg_clear) !!}</td>
        <td class="label">Updated service?</td><td>{!! $yesNo($jobApplication->pvg_updated_service) !!}</td>
    </tr>
</table>

<table>
    <tr><td class="section-title" colspan="6">Bank Payment Details</td></tr>
    <tr>
        <td class="label">Bank / Building society</td><td colspan="2">{{ $jobApplication->bank_name }}</td>
        <td class="label">Account name</td><td colspan="2">{{ $jobApplication->account_name }}</td>
    </tr>
    <tr>
        <td class="label">Account type</td><td colspan="2">{!! $box(optional($jobApplication)->account_type === 'Personal') !!} Personal &nbsp;&nbsp; {!! $box(optional($jobApplication)->account_type === 'LTD') !!} LTD.</td>
        <td class="label">Branch address</td><td colspan="2">{{ $jobApplication->bank_branch_address }}</td>
    </tr>
    <tr>
        <td class="label">Postcode</td><td>{{ $jobApplication->bank_postcode }}</td>
        <td class="label">Account no.</td><td>{{ $jobApplication->account_number }}</td>
        <td class="label">Sort code</td><td>{{ $jobApplication->sort_code }}</td>
    </tr>
</table>

<table>
    <tr><td class="section-title" colspan="6">Driving Details</td></tr>
    <tr>
        <td class="label">Valid UK driver's licence?</td><td colspan="2">{!! $yesNo($jobApplication->has_uk_license) !!}</td>
        <td class="label">Do you have use of a car?</td><td colspan="2">{!! $yesNo($jobApplication->has_car) !!}</td>
    </tr>
</table>

<table>
    <tr><td class="section-title" colspan="6">Immunisations</td></tr>
    @php
        $rows = [
            $immunisationRow('Hep B', $imm->hep_b ?? null),
            $immunisationRow('TB', $imm->tb ?? null),
            $immunisationRow('Varicella', $imm->varicella ?? null),
            $immunisationRow('Measles', $imm->measles ?? null),
            $immunisationRow('Rubella', $imm->rubella ?? null),
            $immunisationRow('Hep B Antigen', $imm->hep_b_antigen ?? null, true),
            $immunisationRow('Hep C', $imm->hep_c ?? null, true),
            $immunisationRow('HIV', $imm->hiv ?? null, true),
        ];
    @endphp
    @foreach($rows as [$label, $cells])
        <tr>
            <td class="label">{{ $label }}</td>
            <td colspan="5">{!! $cells !!}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="6">All applicants who cannot provide a registered PVG/DBS Number or full immunisation record will be required to complete at their own cost. Candidates must purchase uniform (£20) which will be deducted from first timesheet once working.</td>
    </tr>
    <tr>
        <td colspan="6">Please sign to say you have read and understood the above: Your Signature _______________________ Date ____________</td>
    </tr>
</table>

<div class="page-break"></div>

<table>
    <tr><td class="section-title" colspan="6">Availability</td></tr>
    <tr><td colspan="6">1. Please indicate when you would like to work. Please tick all relevant boxes.</td></tr>
    <tr>
        <td class="label">Morning (M-F)</td><td>{!! $box($pref('Morning (M-F)')) !!}</td>
        <td class="label">Evenings (M-F)</td><td>{!! $box($pref('Evenings (M-F)')) !!}</td>
        <td class="label">Nights (M-F)</td><td>{!! $box($pref('Nights (M-F)')) !!}</td>
    </tr>
    <tr>
        <td class="label">Morning (SAT-SUN)</td><td>{!! $box($pref('Morning (SAT-SUN)')) !!}</td>
        <td class="label">Evenings (SAT-SUN)</td><td>{!! $box($pref('Evenings (SAT-SUN)')) !!}</td>
        <td class="label">Other</td><td colspan="2">{{ $jobApplication->availability_other }}</td>
    </tr>
    <tr><td colspan="6">3. Availability</td></tr>
    <tr>
        <td class="label">Start date</td><td colspan="2">{{ $formatDate($jobApplication->start_date) }}</td>
        <td class="label">Interview availability</td><td colspan="2">{{ $formatDate($jobApplication->interview_availability) }}</td>
    </tr>
    <tr>
        <td class="label">Holiday booked?</td><td colspan="2">{!! $yesNo($jobApplication->has_holidays_booked) !!}</td>
        <td class="label">If yes, dates</td><td colspan="2">{{ $jobApplication->holidays_dates }}</td>
    </tr>
</table>

<table>
    <tr><td class="section-title" colspan="6">References</td></tr>
    <tr class="inner-title">
        <td>Name</td><td>Position</td><td>Company & Address</td><td>Telephone</td><td>Email</td><td>May we contact?</td>
    </tr>
    @php $references = $jobApplication->references; @endphp
    @forelse($references as $reference)
        <tr>
            <td>{{ $reference->name }}</td>
            <td>{{ $reference->position }}</td>
            <td>{{ $reference->company_address }}</td>
            <td>{{ $reference->telephone }}</td>
            <td>{{ $reference->email }}</td>
            <td>{!! $yesNo($reference->may_contact_now) !!}</td>
        </tr>
    @empty
        <tr><td colspan="6">No references supplied.</td></tr>
    @endforelse
</table>

<table>
    <tr><td class="section-title" colspan="6">For Office Use Only</td></tr>
    <tr>
        <td class="label">Application received date</td><td>{{ $jobApplication->created_at->format('d/m/Y') }}</td>
        <td class="label">Interview date</td><td></td>
        <td class="label">Outcome</td><td></td>
    </tr>
</table>

<div class="page-break"></div>

<table>
    <tr><td class="section-title" colspan="6">Working Time Regulations Declaration</td></tr>
    <tr>
        <td colspan="6">For the purposes of the Working Time Regulations 1998 (as amended) I consent to work more than an average of 48 hours per week, averaged over 17 weeks. I understand that I may withdraw this consent by giving ZAN Traders Ltd not less than three months' notice at any time.</td>
    </tr>
    <tr>
        <td>Signed: {{ $working['signature'] }}</td>
        <td>Print name: {{ $working['print'] }}</td>
        <td>Date: {{ $working['date'] }}</td>
        <td colspan="3"></td>
    </tr>
</table>

<table>
    <tr><td class="section-title" colspan="6">Other Declarations</td></tr>
    <tr>
        <td colspan="6">I consent to work more than the maximum number of hours permitted to work at night under the directive. I understand I am under no obligation to sign either declaration.</td>
    </tr>
    <tr>
        <td>Signed: {{ $otherDecl['signature'] }}</td>
        <td>Print name: {{ $otherDecl['print'] }}</td>
        <td>Date: {{ $otherDecl['date'] }}</td>
        <td colspan="3"></td>
    </tr>
</table>

<table>
    <tr><td class="section-title" colspan="6">Health &amp; Safety</td></tr>
    <tr>
        <td colspan="6">Each agency worker has a responsibility at the start of their first shift to become familiar with the Client's details including medical details.</td>
    </tr>
    <tr>
        <td>Signed: {{ $healthSafety['signature'] }}</td>
        <td>Print name: {{ $healthSafety['print'] }}</td>
        <td>Date: {{ $healthSafety['date'] }}</td>
        <td colspan="3"></td>
    </tr>
</table>

<table>
    <tr><td class="section-title" colspan="6">Right to Work in the UK</td></tr>
    <tr><td colspan="6">Please indicate your entitlement for working in the UK:</td></tr>
    @foreach($rightToWorkOptions as $key => $label)
        <tr>
            <td colspan="6">{!! $box($rightToWork === $key) !!} {{ $label }}</td>
        </tr>
    @endforeach
</table>

<table>
    <tr><td class="section-title" colspan="6">Rehabilitation of Offenders Act 1974</td></tr>
    <tr><td colspan="6">Because of the nature of this work please answer all five questions.</td></tr>
    @php
        [$convictionsAnswer, $convictionsDetails] = $boolAnswer($jobApplication->has_convictions, $jobApplication->convictions_details);
        [$disciplinaryAnswer, $disciplinaryDetails] = $boolAnswer($jobApplication->has_disciplinary, $jobApplication->disciplinary_details);
        [$chargesAnswer, $chargesDetails] = $boolAnswer($jobApplication->has_criminal_charges, $jobApplication->criminal_charges_details);
        [$policeConsentAnswer] = $boolAnswer($jobApplication->consents_police_check);
        [$policeCheckedAnswer, $policeCheckedDetails] = $boolAnswer($jobApplication->police_checked_recently, $jobApplication->police_check_details);
    @endphp
    <tr>
        <td class="label">1. Do you have any convictions, cautions or bindovers?</td>
        <td colspan="2">{!! $convictionsAnswer !!}</td>
        <td class="label">Details</td>
        <td colspan="2">{{ $convictionsDetails }}</td>
    </tr>
    <tr>
        <td class="label">2. Have you ever had disciplinary action taken against you?</td>
        <td colspan="2">{!! $disciplinaryAnswer !!}</td>
        <td class="label">Details</td>
        <td colspan="2">{{ $disciplinaryDetails }}</td>
    </tr>
    <tr>
        <td class="label">3. Are you currently subject to criminal charges or disciplinary action?</td>
        <td colspan="2">{!! $chargesAnswer !!}</td>
        <td class="label">Details</td>
        <td colspan="2">{{ $chargesDetails }}</td>
    </tr>
    <tr>
        <td class="label">4. Do you consent to ZAN Traders Ltd requesting a police check?</td>
        <td colspan="2">{!! $policeConsentAnswer !!}</td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td class="label">5. Have you been police checked in the last three years?</td>
        <td colspan="2">{!! $policeCheckedAnswer !!}</td>
        <td class="label">If so, by whom?</td>
        <td colspan="2">{{ $policeCheckedDetails }}</td>
    </tr>
</table>

<div class="page-break"></div>

<table>
    <tr><td class="section-title" colspan="6">Registration Declaration Forms</td></tr>
    <tr><td class="inner-title" colspan="6">Health Declarations</td></tr>
    <tr>
        <td colspan="6">We would ask all overseas candidates to provide a medical statement from their GP confirming fitness for work. By signing below you consent to ZAN Traders Ltd releasing your health records for review and to obtain information from your GP / Occupational Health Department if required.</td>
    </tr>
    <tr>
        <td>Signed: {{ $health['signature'] }}</td>
        <td>Print name: {{ $health['print'] }}</td>
        <td>Date: {{ $health['date'] }}</td>
        <td colspan="3"></td>
    </tr>
    <tr><td class="inner-title" colspan="6">Disability Discrimination Act 1995</td></tr>
    <tr>
        <td colspan="3">Do you consider yourself to be a person with a disability as described by the Act?</td>
        <td colspan="3">{!! $yesNo(data_get($jobApplication, 'disability_declaration.has_disability')) !!}</td>
    </tr>
    <tr>
        <td>Signed: {{ $disability['signature'] }}</td>
        <td>Print name: {{ $disability['print'] }}</td>
        <td>Date: {{ $disability['date'] }}</td>
        <td colspan="3"></td>
    </tr>
    <tr><td class="inner-title" colspan="6">Confidentiality</td></tr>
    <tr><td colspan="6">I declare that at no time will I divulge to any person, nor use for my own or any other person's benefit, any confidential information relating to ZAN Traders Ltd or their employees.</td></tr>
    <tr>
        <td>Signed: {{ $confidentiality['signature'] }}</td>
        <td>Print name: {{ $confidentiality['print'] }}</td>
        <td>Date: {{ $confidentiality['date'] }}</td>
        <td colspan="3"></td>
    </tr>
    <tr><td class="inner-title" colspan="6">Consent for the Use of Staff Photographic Images</td></tr>
    <tr><td colspan="6">I authorise ZAN Traders Ltd to use my image in publications, promotions, social media, advertising, website and any other digital media.</td></tr>
    <tr>
        <td>Signed: {{ $photo['signature'] }}</td>
        <td>Print name: {{ $photo['print'] }}</td>
        <td>Date: {{ $photo['date'] }}</td>
        <td colspan="3"></td>
    </tr>
    <tr><td class="inner-title" colspan="6">Personal Declarations</td></tr>
    <tr><td colspan="6">I confirm the information provided on my application is correct and true. I understand providing false information may result in termination of any placement.</td></tr>
    <tr>
        <td>Signed: {{ $personal['signature'] }}</td>
        <td>Print name: {{ $personal['print'] }}</td>
        <td>Date: {{ $personal['date'] }}</td>
        <td colspan="3"></td>
    </tr>
</table>

<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>

</body>
</html>
