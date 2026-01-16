<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Job Application - {{ $jobApplication->forename }} {{ $jobApplication->surname }}</title>
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
        ul { margin: 3px 0; padding-left: 12px; font-size: 10px; list-style: none; }
        ul li { margin-bottom: 3px; }
        .checklist-box { border: 1px solid #7fb7cf; padding: 10px 12px; margin-bottom: 8px; }
        .checklist-box .instruction { text-align: left; margin-bottom: 8px; }
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

{{-- PAGE 1 --}}
<div class="header">
    <div class="header-left">358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA<br>T: 01698 701199<br>E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care</div>
    <div class="header-right">@if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif</div>
</div>
<h1>Job Application Form</h1>
<table>
    <tr><td class="section-title" colspan="2">PERSONAL DETAILS</td></tr>
    <tr>
        <td style="width:50%;">Title: {{ $jobApplication->title }}</td>
        <td style="width:50%;">Date of birth: {{ $formatDate($jobApplication->date_of_birth) }}</td>
    </tr>
    <tr><td colspan="2">Forename: {{ $jobApplication->forename }}</td></tr>
    <tr><td colspan="2">Surname: {{ $jobApplication->surname }}</td></tr>
    <tr><td colspan="2">Previous Name: {{ $jobApplication->previous_name }}</td></tr>
    <tr>
        <td>Gender: {{ $jobApplication->gender }}</td>
        <td>Marital status: {{ $jobApplication->marital_status }}</td>
    </tr>
    <tr><td colspan="2">NI Number: {{ $jobApplication->ni_number }}</td></tr>
</table>
<table>
    <tr><td class="section-title" colspan="2">ADDRESS</td></tr>
    <tr><td colspan="2" style="min-height:30px;">Address: {{ $jobApplication->address }}</td></tr>
    <tr><td colspan="2">Postcode: {{ $jobApplication->postcode }}</td></tr>
</table>
<table>
    <tr><td class="section-title" colspan="2">WAYS TO CONTACT YOU</td></tr>
    <tr>
        <td style="width:50%;">Mobile Number: {{ $jobApplication->mobile_number }}</td>
        <td style="width:50%;">Landline: {{ $jobApplication->landline }}</td>
    </tr>
    <tr><td colspan="2">Email: {{ $jobApplication->email }}</td></tr>
</table>
<table>
    <tr><td class="section-title" colspan="2">EMERGENCY CONTACT</td></tr>
    <tr><td colspan="2">Next of Kin: {{ $jobApplication->next_of_kin_name }}</td></tr>
    <tr><td colspan="2">Name: {{ $jobApplication->next_of_kin_name }}</td></tr>
    <tr>
        <td style="width:50%;">Relationship: {{ $jobApplication->next_of_kin_relationship }}</td>
        <td style="width:50%;">Phone: {{ $jobApplication->next_of_kin_phone }}</td>
    </tr>
    <tr><td colspan="2">Address: {{ $jobApplication->next_of_kin_address }}</td></tr>
    <tr>
        <td style="width:50%;">Postcode: {{ $jobApplication->next_of_kin_postcode }}</td>
        <td style="width:50%;">Email: {{ $jobApplication->next_of_kin_email }}</td>
    </tr>
</table>
<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
<div class="page-break"></div>

{{-- PAGE 2 --}}
<div class="header">
    <div class="header-left">358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA<br>T: 01698 701199<br>E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care</div>
    <div class="header-right">@if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif</div>
</div>
<h2>WORK HISTORY</h2>
<p class="instruction">Please ensure you complete this section even if you have a CV. Please ensure that you leave no gaps unaccounted for and it covers 10 years.</p>
<table>
    <tr><td class="section-title" colspan="2">CURRENT JOB</td></tr>
    <tr>
        <td style="width:50%;">Job title: {{ $jobApplication->current_job_title }}</td>
        <td style="width:50%;">Current Pay p/h: £{{ $jobApplication->current_pay }}</td>
    </tr>
    <tr><td colspan="2">Duties: {{ $jobApplication->current_duties }}</td></tr>
    <tr>
        <td>Current Place of Work: {{ $jobApplication->current_place_of_work }}</td>
        <td>Day/Night Shift: {{ $jobApplication->current_shift_type }}</td>
    </tr>
</table>
@php $histories = $jobApplication->workHistories; @endphp
@for($i = 0; $i < 3; $i++)
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
<div class="page-break"></div>

{{-- PAGE 3 --}}
<div class="header">
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
<div class="page-break"></div>

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
<table>
    <tr><td class="section-title">MANDATORY TRAINING</td></tr>
    <tr><td style="font-size:8px; font-style:italic;">Please tick if you have completed the following training within the last 12 months, please enclose copies of your training certificates.</td></tr>
</table>
<table>
    <tr>
        <td style="width:25%;">Moving and Handling: {!! $box(false) !!}</td>
        <td style="width:25%;">Basic Life Support: {!! $box(false) !!}</td>
        <td style="width:25%;">Intermediate Life Support: {!! $box(false) !!}</td>
        <td style="width:25%;">Advance Life Support: {!! $box(false) !!}</td>
    </tr>
    <tr>
        <td>Complaints Handling: {!! $box(false) !!}</td>
        <td>Handling Violence and Aggression: {!! $box(false) !!}</td>
        <td>Fire safety: {!! $box(false) !!}</td>
        <td>COSHH: {!! $box(false) !!}</td>
    </tr>
    <tr>
        <td>RIDDOR: {!! $box(false) !!}</td>
        <td>Caldicott Protocols: {!! $box(false) !!}</td>
        <td>Data Protection: {!! $box(false) !!}</td>
        <td>Infection Control: {!! $box(false) !!}</td>
    </tr>
    <tr>
        <td>Lone Worker Training: {!! $box(false) !!}</td>
        <td>Food Hygiene (where required to handle food): {!! $box(false) !!}</td>
        <td>Personal Safety (Mental Health and Learning Dis.): {!! $box(false) !!}</td>
        <td>Covid-19: {!! $box(false) !!}</td>
    </tr>
</table>
<table>
    <tr>
        <td style="width:30%;">Other (please list):</td>
        <td style="min-height:32px;">{{ optional($jobApplication->training)->other_training }}</td>
    </tr>
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
        <td>Account Type: Personal {!! $box($jobApplication->account_type === 'Personal') !!} &nbsp;&nbsp; LTD. {!! $box($jobApplication->account_type === 'LTD') !!}</td>
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
<table>
    <tr><td class="section-title" colspan="4">IMMUNISATIONS</td></tr>
    <tr><td colspan="4" style="font-size:8px;">Please indicate which off the following Immunisations you have been vaccinated against and include your vaccination reports when returning your registration.</td></tr>
    <tr><td style="width:20%;">Hep B</td><td style="width:30%;">Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td><td style="width:20%;">TB</td><td>Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td></tr>
    <tr><td>Varicella</td><td>Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td><td>Measles</td><td>Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td></tr>
    <tr><td>Rubella</td><td colspan="3">Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td></tr>
    <tr><td>Hep B Antigen</td><td colspan="3">No Proof {!! $box(false) !!} &nbsp; Negative {!! $box(false) !!} &nbsp; Positive {!! $box(false) !!}</td></tr>
    <tr><td>Hep C</td><td colspan="3">No Proof {!! $box(false) !!} &nbsp; Negative {!! $box(false) !!} &nbsp; Positive {!! $box(false) !!}</td></tr>
    <tr><td>HIV</td><td colspan="3">No Proof {!! $box(false) !!} &nbsp; Negative {!! $box(false) !!} &nbsp; Positive {!! $box(false) !!}</td></tr>
    <tr><td colspan="4" style="font-size:8px;">All applications who cannot provide a registered PVG/DBS Number or full immunisation record will be required to complete at their own cost. Candidates will be required to purchase uniform if required at the cost of £20 this will be deducted from your timesheet once you have started working through us.</td></tr>
    <tr><td colspan="4">Please sign to say you have read and understood the above</td></tr>
    <tr><td colspan="2">Your Signature: ______________________</td><td colspan="2">Date: ____________</td></tr>
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
<table>
    <tr><td class="section-title">HEALTH DECLARATIONS</td></tr>
    <tr><td style="font-size:9px;">We would ask all OVERSEAS candidates to provide a medical statement from their GP or medical department confirming your state of health. Your details will be passed to our Occupational Health Doctors to establish your fitness for work. Please sign the declaration below to allow ZAN Traders Ltd to release your information for inspection.<br><br>I ........................................................................................................................ consent to ZAN Traders Ltd<br>releasing my health and immunisation records for review. I understand that based on this review I may be required to undergo a medical examination to establish my fitness for work.<br><br>I confirm that I will immediately inform ZAN Traders Ltd in confidence if I am HIV Positive, Hep B positive or if I have AIDS in accordance with the Department of Health guidelines. I am aware of my obligations regarding MRSA contact and the need for screening. I agree to immediately inform ZAN Traders Ltd should my general condition of health change.<br><br>I will inform ZAN Traders Ltd immediately if I discover that I am pregnant. I understand that withholding information or giving false answers may lead to dismissal. I also hereby consent to ZAN Traders Ltd obtaining further information regarding my health from my GP or Occupational Health Department.</td></tr>
    <tr><td>Signed: _________________ &nbsp;&nbsp; Print Name: _________________ &nbsp;&nbsp; Date: _________________</td></tr>
</table>
<table>
    <tr><td class="section-title">DISABILITY DISCRIMINATION ACT</td></tr>
    <tr><td style="font-size:9px;">Applicants with disabilities will be invited for interview if the essential job criteria are met. Do you consider yourself to be a person with a disability as described by the disability discrimination act 1995? i.e. do you consider yourself to be someone who has a physical or mental impairment which has a substantial and long term adverse effect on your ability to carry out normal day to day activities</td></tr>
    <tr><td>Yes {!! $box(false) !!} &nbsp;&nbsp; No {!! $box(false) !!}</td></tr>
    <tr><td>Signed: _________________ &nbsp;&nbsp; Print Name: _________________ &nbsp;&nbsp; Date: _________________</td></tr>
</table>
<table>
    <tr><td class="section-title">CONFIDENTIALITY</td></tr>
    <tr><td style="font-size:9px;">I hereby declare that at no time will I divulge to any person, nor use for my own or any other person's benefit, any confidential information in relation to ZAN Traders Ltd or in relation to any of their employees, business affairs, transactions, or finances which I may acquire during the term of my agreement with ZAN Traders Ltd under the Terms of Engagement.</td></tr>
    <tr><td>Signed: _________________ &nbsp;&nbsp; Print Name: _________________ &nbsp;&nbsp; Date: _________________</td></tr>
</table>
<table>
    <tr><td class="section-title">CONSENT FOR THE USE OF STAFF PHOTOGRAPHIC IMAGES</td></tr>
    <tr><td style="font-size:9px;">To comply with the principle, set out in the Data Protection Act 2018 and GDPR, ZAN Traders Ltd requires consent to take and use staff photographic images. By signing this declaration, you authorise ZAN Traders Ltd to use your images in publications, promotions, social media, advertising, website and any other digital media or filming which ZAN Traders Ltd approves and authorise. If you should wish to withdraw your consent at any time, please contact us at info@ztl.care. Please note that although your images will be removed from our data base on request, we cannot guarantee it will not be in circulation in any media produced prior to your request.<br><br>I hereby consent for my photographic images to be used as stated above.</td></tr>
    <tr><td>Signed: _________________ &nbsp;&nbsp; Print Name: _________________ &nbsp;&nbsp; Date: _________________</td></tr>
</table>
<table>
    <tr><td class="section-title">PERSONAL DECLARATIONS</td></tr>
    <tr><td style="font-size:9px;">I hereby confirm that the information provided on my application is correct and true to the best of my knowledge and that I have not withheld any information that should be considered when offering me work.<br><br>I understand that providing false or inaccurate information may result in the termination of any placement. I agree that I will make best endeavours to make myself aware of the Health & Safety procedures for each client I am assigned to.<br><br>I confirm that I have read and understood the Terms of Engagement and the terms of the declaration and agree to be bound by them.</td></tr>
</table>
 <table>
        <tr><td>Signed: _________________ &nbsp;&nbsp; Print Name: _________________ &nbsp;&nbsp; Date: _________________</td></tr>
    </table>
    <table>
        <tr><td class="section-title">WORKING TIME REGULATIONS DECLARATIONS</td></tr>
        <tr><td style="font-size:9px;">For the purposes of the Working Time Regulations 1998 (as amended) I, consent to work more than an average of 48 hours per week, averaged over 17 weeks. I understand that I may withdraw this consent by giving ZAN Traders Ltd not less than three months' notice at any time.</td></tr>
        <tr><td>Signed: _________________ &nbsp;&nbsp; Print Name: _________________ &nbsp;&nbsp; Date: _________________</td></tr>
    </table>
</div>
<table>
    <tr><td class="section-title">OTHER DECLARATIONS</td></tr>
    <tr><td style="font-size:9px;">In addition, I also consent to work more than the maximum number of hours permitted to work at night under the directive. Please note you are under no obligation to sign either declaration.</td></tr>
    <tr><td>Signed: _________________ &nbsp;&nbsp; Print Name: _________________ &nbsp;&nbsp; Date: _________________</td></tr>
</table>
<table>
    <tr><td class="section-title">HEALTH AND SAFETY</td></tr>
    <tr><td style="font-size:9px;">Each agency worker has a responsibility at the start of their first shift to become familiar with the Client's details including medical details.</td></tr>
    <tr><td>Signed: _________________ &nbsp;&nbsp; Print Name: _________________ &nbsp;&nbsp; Date: _________________</td></tr>
</table>
<table>
    <tr><td class="section-title">RIGHT TO WORK IN THE UK</td></tr>
    <tr><td style="font-size:9px;">Please complete this form, regardless of your nationality, as it is a legal requirement. If you are an overseas national or require a work permit to work in the UK, please include copies of supporting documentation.<br>Your entitlement for working in the UK is based upon what status:</td></tr>
    <tr><td>EU Citizen (Visa): {!! $box(false) !!} &nbsp;&nbsp; Spouse of an EU Citizen (Visa): {!! $box(false) !!} &nbsp;&nbsp; Work Permit: {!! $box(false) !!}</td></tr>
    <tr><td>Permit-free Visa: {!! $box(false) !!} &nbsp;&nbsp; Right of Abode in the UK: {!! $box(false) !!} &nbsp;&nbsp; Admitted to UK as Doctor Prior to 1985: {!! $box(false) !!}</td></tr>
</table>
<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>
<div class="page-break"></div>

{{-- PAGE 7: MORE DECLARATIONS --}}
<div class="header">
    <div class="header-left">358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA<br>T: 01698 701199<br>E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care</div>
    <div class="header-right">@if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif</div>
</div>     
<table> 
    <tr><td class="section-title" colspan="2">REHABILITATION OF OFFENDERS ACT 1974 – Please answer all five questions</td></tr>
    <tr><td colspan="2" style="font-size:8px;">Because of the nature of the work for which you are applying, Section 4(2), and further Orders made by the Secretary of State under the provision of this section of the Rehabilitation of Offenders Act (1974) (Exceptions) Order 1975 apply. Applicants are therefore required to give information about convictions which for other purposes are "spent" under the provisions of the Act. Any information given will be completely confidential and will be considered only in relation for positions to which the order applies.</td></tr>
    <tr><td class="label" style="width:70%;">1. Do you have any convictions, cautions or bindovers?</td><td style="width:30%;">Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td></tr>
    <tr><td colspan="2">If yes, please give details...</td></tr>
    <tr><td colspan="2" style="min-height:20px;"></td></tr>
    <tr><td class="label">2. Have you ever had disciplinary action taken against you?</td><td>Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td></tr>
    <tr><td colspan="2">If yes, please give details...</td></tr>
    <tr><td colspan="2" style="min-height:20px;"></td></tr>
    <tr><td class="label">3. Are you at present the subject of criminal charges or disciplinary action?</td><td>Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td></tr>
    <tr><td colspan="2">If yes, please give details...</td></tr>
    <tr><td colspan="2" style="min-height:20px;"></td></tr>
    <tr><td class="label">4. Do you consent to ZAN Traders Ltd requesting a police check and any appropriate references on your behalf?</td><td>Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td></tr>
    <tr><td class="label">5. Have you been police checked in the last three years?</td><td>Yes {!! $box(false) !!} &nbsp; No {!! $box(false) !!}</td></tr>
    <tr><td colspan="2">If so, by whom...</td></tr>
    <tr><td colspan="2" style="min-height:20px;"></td></tr>
    <tr><td colspan="2">Signed: _________________________<br><br>Print Name: _________________________</td></tr>
    <tr><td colspan="2">Date: _________________________</td></tr>
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
    <tr><td colspan="2" style="font-size:8px;">Give details of the names/addresses of two work-related Referees. One of the Referees should be your current employer, or if presently unemployed or self-employed, your last employer</td></tr>
    <tr><td class="label" style="width:50%;">Name:</td><td class="label">Name:</td></tr>
    <tr><td>{{ $jobApplication->references[0]->name ?? '' }}</td><td>{{ $jobApplication->references[1]->name ?? '' }}</td></tr>
    <tr><td class="label">Position:</td><td class="label">Position:</td></tr>
    <tr><td>{{ $jobApplication->references[0]->position ?? '' }}</td><td>{{ $jobApplication->references[1]->position ?? '' }}</td></tr>
    <tr><td class="label">Company Name and Address:</td><td class="label">Company Name and Address:</td></tr>
    <tr><td>{{ $jobApplication->references[0]->company_address ?? '' }}</td><td>{{ $jobApplication->references[1]->company_address ?? '' }}</td></tr>
    <tr><td class="label">Telephone Number</td><td class="label">Telephone Number</td></tr>
    <tr><td>{{ $jobApplication->references[0]->telephone ?? '' }}</td><td>{{ $jobApplication->references[1]->telephone ?? '' }}</td></tr>
    <tr><td class="label">Email Address:</td><td class="label">Email Address:</td></tr>
    <tr><td>{{ $jobApplication->references[0]->email ?? '' }}</td><td>{{ $jobApplication->references[1]->email ?? '' }}</td></tr>
    <tr><td class="label">May we contact the above person now?</td><td class="label">May we contact the above person now?</td></tr>
    <tr><td>Yes {!! $box(false) !!} &nbsp;&nbsp; No {!! $box(false) !!}</td><td>Yes {!! $box(false) !!} &nbsp;&nbsp; No {!! $box(false) !!}</td></tr>
</table>
<table>
    <tr><td class="section-title" colspan="3">FOR OFFICE USE ONLY</td></tr>
    <tr><td class="label" style="width:40%;">Application received date:</td><td class="label" style="width:30%;">Interview date:</td><td class="label" style="width:30%;">Outcome:</td></tr>
    <tr><td>{{ $jobApplication->created_at->format('d/m/Y') }}</td><td></td><td></td></tr>
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
    <tr><td>Morning (M-F) {!! $box($pref('Morning (M-F)')) !!}</td></tr>
    <tr><td>EVENINGS (M-F) {!! $box($pref('Evenings (M-F)')) !!}</td></tr>
    <tr><td>NIGHTS (M-F) {!! $box($pref('Nights (M-F)')) !!}</td></tr>
    <tr><td>Morning (SAT-SUN) {!! $box($pref('Morning (SAT-SUN)')) !!}</td></tr>
    <tr><td>EVENINGS (SAT-SUN) {!! $box($pref('Evenings (SAT-SUN)')) !!}</td></tr>
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
<div class="page-break"></div>

{{-- PAGE 10: REGISTRATION CHECKLIST --}}
<div class="header">
    <div class="header-left">358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA<br>T: 01698 701199<br>E: info@ztl.care&nbsp;&nbsp;W: www.ztl.care</div>
    <div class="header-right">@if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif</div>
</div>
<h2>REGISTRATION CHECKLIST</h2>
<div class="checklist-box">
<p class="instruction">To complete your registration, you will be required to provide the following documentation</p>
<ul>
    <li>{!! $box(false) !!} Completed Registration Form – signed in all requested areas</li>
    <li>{!! $box(false) !!} CV – E-mailed in word format</li>
    <li>{!! $box(false) !!} Your Right to work in the UK as well as your passport, we need a copy of the photo page and the outside of the passport.</li>
    <li>{!! $box(false) !!} Birth Certificate and Driving Licence</li>
    <li>{!! $box(false) !!} HPC or NMC Entry Certificate and up to date renewal card – SSSC for Carers.</li>
    <li>{!! $box(false) !!} Copy of your most recent PVG/DBS Number – less than 1 year old</li>
    <li>{!! $box(false) !!} Training Qualifications – Diploma/Degree/NVQ – Any other training Certificates</li>
    <li>{!! $box(false) !!} Mandatory Training Certificates > 1 Year to be completed</li>
    <li style="margin-left:15px;">• Manual Handling</li>
    <li style="margin-left:15px;">• Basic Life Support, Paediatrics need Paeds Life support and Midwives Newborn Life Support</li>
    <li style="font-size:8px;">Data Protection, Complaints Handling, COSHH, Fire, Infection Control, Loneworker, Riddor, Violence and Aggression, Health & Safety, Safeguarding</li>
    <li style="font-size:8px;">Children & Young People Level 2 minimum (if you need to update these please let us know and we will arrange this for you) &nbsp; Mental Health Nurses will need Restraint Training</li>
    <li>{!! $box(false) !!} Immunisations</li>
    <li style="margin-left:15px;">• Hep B</li>
    <li style="margin-left:15px;">• Varicella</li>
    <li style="margin-left:15px;">• Evidence of BCG – OR completed TB form, or confirmation on Letter Head paper, including your details and the GMC NMC number of the practitioner confirming the scar</li>
    <li style="margin-left:15px;">• Measles &nbsp;&nbsp;&nbsp; Rubella</li>
    <li>{!! $box(false) !!} EPP Candidates (IVS = identification was shown at time of blood test)</li>
    <li style="margin-left:15px;">• Hep B Surface Antigen (IVS)</li>
    <li style="margin-left:15px;">• Hep C (IVS) &nbsp;&nbsp; HIV (IVS)</li>
    <li>{!! $box(false) !!} 2x Passport Size Photos</li>
    <li>{!! $box(false) !!} Proof of National Insurance Number</li>
    <li>{!! $box(false) !!} 2x Reference forms.</li>
    <li style="font-size:8px;">Please ask 2 senior members of staff to complete the reference forms and return them to us. This is to speed up your application. If we apply for them ourselves, we often struggle to get them returned and it delays the process. We are happy to apply for them if it is not possible for you to get them. Please ensure they include verification. We will contact the referee to verify once they have been received. All references will be verified by a member of the compliance team, via phone or e-mail.</li>
    <li>{!! $box(false) !!} To be paid through a Limited Company please ensure you send</li>
    <li style="margin-left:15px;">• Certificate of Incorporation</li>
    <li style="margin-left:15px;">• Evidence of limited bank details and company name i.e. bank statement or blank cheque</li>
    <li>{!! $box(false) !!} VAT Certificate</li>
    <li>{!! $box(false) !!} Signed Self Billing Form (enclosed)</li>
    <li>{!! $box(false) !!} One Photo ID.</li>
    <li>{!! $box(false) !!} Two proof of address.</li>
</ul>
</div>
<div class="footer">ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong></div>

</body>
</html>
