<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Interview Questionnaire - {{ $interview->candidate_name }}</title>
    <style>
        @page { 
            size: A4 landscape;
            margin: 15mm 12mm;
        }
        body { 
            font-family: "DejaVu Sans", sans-serif; 
            font-size: 12px; 
            color: #000; 
            line-height: 1.2; 
        }
        .header { 
            display: table; 
            width: 100%; 
            margin-bottom: 8px; 
        }
        .header-left { 
            display: table-cell; 
            vertical-align: top; 
            width: 50%; 
            font-size: 12px; 
            line-height: 1.3; 
        }
        .header-left strong { 
            font-size: 12.5px; 
        }
        .header-right { 
            display: table-cell; 
            text-align: right; 
            vertical-align: top; 
        }
        .header-right img { 
            width: 110px; 
        }
        h1 { 
            text-align: center; 
            font-size: 14px; 
            margin: 8px 0 10px 0; 
            font-weight: bold;
        }
        h2 { 
            font-size: 11px; 
            margin: 8px 0 6px 0; 
            text-decoration: underline;
            font-weight: bold;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 6px; 
        }
        th, td { 
            border: 1px solid #7fb7cf; 
            padding: 3px 5px; 
            vertical-align: top; 
            font-size: 12px; 
        }
        .section-header { 
            background: #7fc4dd; 
            color: #000; 
            font-weight: bold; 
            padding: 4px 6px; 
            font-size: 12px; 
        }
        .label-col { 
            background: #d5eef7; 
            font-weight: bold; 
            width: 35%; 
        }
        .score-col {
            width: 8%;
            text-align: center;
            background: #f9f9f9;
        }
        .page-break { 
            page-break-after: always; 
        }
        .footer { 
            position: fixed; 
            bottom: 5mm; 
            left: 12mm; 
            right: 12mm; 
            text-align: center; 
            font-size: 12px; 
            color: #000; 
        }
        .bullet-list { 
            margin: 2px 0; 
            padding-left: 10px; 
            font-size: 10px; 
        }
        .bullet-list li { 
            margin-bottom: 1px; 
        }
        .criteria-table td {
            font-size: 10px;
            padding: 2px 4px;
        }
        .intro-section {
            font-size: 10px;
            margin-bottom: 6px;
        }
        .intro-section li {
            margin-bottom: 2px;
        }
    </style>
</head>
<body>
@php
    $logoPath = public_path('img/logo.png');
    $logoExists = file_exists($logoPath);
    $formatDate = fn($value) => optional($value)->format('d/m/Y') ?? '';
@endphp

{{-- PAGE 1: HEADER & SCORING CRITERIA --}}
<div class="header">
    <div class="header-left">
        <strong>358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA</strong><br>
        <strong>T:</strong> 01698 701199<br>
        <strong>E:</strong> info@ztl.care <strong>W:</strong> www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif
    </div>
</div>

<h1>Interview Questionnaire – Carer Support Worker</h1>

<table>
    <tr>
        <td class="section-header" style="width:20%;">Recruiters Name:</td>
        <td style="width:30%;">{{ $interview->recruiter_name }}</td>
        <td class="section-header" style="width:20%;">Date of Interview:</td>
        <td style="width:30%;">{{ $formatDate($interview->interview_date) }}</td>
    </tr>
    <tr>
        <td class="section-header">Candidates Name:</td>
        <td colspan="3">{{ $interview->candidate_name }}</td>
    </tr>
    <tr>
        <td class="section-header">Location/Branch:</td>
        <td colspan="3">{{ $interview->location }}</td>
    </tr>
    <tr>
        <td class="section-header">Outcome:</td>
        <td colspan="3">(Please Circle) &nbsp;&nbsp; Offer &nbsp;&nbsp; Reject</td>
    </tr>
</table>

<h2>Notes to interviewer</h2>
<p style="font-size:8px; margin-bottom:4px;">The following guidance should be used to ensure consistency and equal opportunities for all candidates. There are model answers provided in the left-hand column. The following criteria should be used as a scoring guide with a maximum award of 3 points per question.</p>

<table class="criteria-table">
    <tr class="section-header">
        <th style="width:10%;">Score</th>
        <th>Criteria for determining score</th>
    </tr>
    <tr>
        <td style="text-align:center; font-weight:bold;">0</td>
        <td><strong>Poor</strong> - Failed to answer the question/ failed to demonstrate any knowledge in area/failed to provide or identify any of the sample answers</td>
    </tr>
    <tr>
        <td style="text-align:center; font-weight:bold;">1</td>
        <td><strong>Average</strong> - Demonstrated limited knowledge in area/answer was brief with little detail/1-2 sample answers given</td>
    </tr>
    <tr>
        <td style="text-align:center; font-weight:bold;">2</td>
        <td><strong>Good</strong> - Demonstrated sound knowledge in area/answer was detailed and included sound explanation/ 2-4 sample answers given</td>
    </tr>
    <tr>
        <td style="text-align:center; font-weight:bold;">3</td>
        <td><strong>Excellent</strong> - Demonstrated extensive knowledge in area/answer was in depth with rationale and relevant example(s)/ 4+ sample answers provided</td>
    </tr>
</table>

<div class="page-break"></div>

{{-- PAGE 2: INTRODUCTIONS & OPENING QUESTIONS --}}
<div class="header">
    <div class="header-left">
        <strong>358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA</strong><br>
        <strong>T:</strong> 01698 701199<br>
        <strong>E:</strong> info@ztl.care <strong>W:</strong> www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif
    </div>
</div>

<h2>Introductions</h2>
<ul class="intro-section">
    <li>• Introduce yourself and the interview panel & explain your role within <strong>ZAN Traders Ltd.</strong></li>
    <li>• Ask if the interviewee needs anything prior to starting and check all mobile phones are switched off.</li>
    <li>• Provide an overview of the recruitment process, including details/format of any assessments & timings.</li>
    <li>• Explain that you will be looking for them to provide specific examples to support what they are saying throughout the interview & notes will be taken.</li>
    <li>• Advise that there will be time at the end to pick up on any questions that have not been answered.</li>
    <li>• Ask interviewee if they require any support/assistance for the interview.</li>
</ul>

<table>
    <tr><td class="section-header" colspan="2">A. Career history/ Opening questions:</td></tr>
    <tr>
        <td style="width:60%;">Did you manage to read through the Staff Handbook?</td>
        <td style="width:40%;">YES &nbsp;&nbsp;&nbsp;&nbsp; NO</td>
    </tr>
    <tr>
        <td>Tell me a bit about yourself?</td>
        <td style="min-height:30px;"></td>
    </tr>
    <tr>
        <td>Are you currently employed?</td>
        <td>YES &nbsp;&nbsp;&nbsp;&nbsp; NO</td>
    </tr>
    <tr>
        <td>What is your current or most recent role?</td>
        <td style="min-height:20px;"></td>
    </tr>
    <tr>
        <td>Why do you want to change from your current role?</td>
        <td style="min-height:20px;"></td>
    </tr>
    <tr>
        <td>What had interested you about the role/why have you applied?</td>
        <td style="min-height:20px;"></td>
    </tr>
    <tr>
        <td colspan="2">
            <strong>Discuss CV.</strong>
            <ul class="bullet-list">
                <li>• Previous experience in the care sector</li>
                <li>• Gaps in employment</li>
            </ul>
        </td>
    </tr>
</table>

<div class="page-break"></div>

{{-- PAGE 3: ROLE-BASED COMPETENCY QUESTIONS (1-5) --}}
<div class="header">
    <div class="header-left">
        <strong>358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA</strong><br>
        <strong>T:</strong> 01698 701199<br>
        <strong>E:</strong> info@ztl.care <strong>W:</strong> www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif
    </div>
</div>

<table>
    <tr>
        <td class="section-header" colspan="3">B. Role based competency questions (Please complete below section with both comment and scores)</td>
    </tr>
    <tr class="section-header">
        <th style="width:25%;">Key Skill area being assessed</th>
        <th style="width:67%;">Question</th>
        <th style="width:8%;">Score</th>
    </tr>
    <tr>
        <td class="label-col">
            <strong>Role skills/suitability</strong><br>
            <ul class="bullet-list">
                <li>Good listener</li>
                <li>Communication</li>
                <li>Patience</li>
                <li>Motivated</li>
                <li>Flexible</li>
                <li>Friendly</li>
                <li>Committed</li>
                <li>Empathy</li>
                <li>Caring</li>
                <li>Punctual</li>
            </ul>
        </td>
        <td>
            <strong>1. What qualities/skills do you think that makes a good care worker?</strong><br>
            <div style="min-height:40px; border-top:1px solid #ccc; margin-top:3px; padding-top:3px;"></div>
        </td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="label-col"></td>
        <td>
            <strong>2. What are your strength and weaknesses?</strong><br>
            <div style="min-height:40px; border-top:1px solid #ccc; margin-top:3px; padding-top:3px;"></div>
        </td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="label-col">
            <strong>Teamwork</strong><br>
            <ul class="bullet-list">
                <li>Utilize all communication channels</li>
                <li>Be supportive/open</li>
                <li>Listen & respect others' views and opinions</li>
                <li>Encourage/motivate</li>
                <li>Be flexible</li>
                <li>Friendly</li>
                <li>Sharing</li>
            </ul>
        </td>
        <td>
            <strong>3. What do you think makes a good team player?</strong><br>
            <div style="min-height:40px; border-top:1px solid #ccc; margin-top:3px; padding-top:3px;"></div>
        </td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="label-col"></td>
        <td>
            <strong>4. Give an example of where you supported your team?</strong><br>
            <div style="min-height:40px; border-top:1px solid #ccc; margin-top:3px; padding-top:3px;"></div>
        </td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="label-col">
            <strong>Problem solving/initiative</strong><br>
            <ul class="bullet-list">
                <li>Think on feet</li>
                <li>Think outside of box/creative ideas</li>
                <li>Be resilient – don't give up</li>
                <li>Identify range of options/solutions</li>
                <li>Decision making skills</li>
                <li>Access the degree of the problem</li>
            </ul>
        </td>
        <td>
            <strong>5. Tell us about a situation you were required to use your initiative</strong><br>
            <div style="min-height:40px; border-top:1px solid #ccc; margin-top:3px; padding-top:3px;"></div>
        </td>
        <td class="score-col"></td>
    </tr>
</table>

<div class="page-break"></div>

{{-- PAGE 4: COMPETENCY QUESTIONS (6-10) --}}
<div class="header">
    <div class="header-left">
        <strong>358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA</strong><br>
        <strong>T:</strong> 01698 701199<br>
        <strong>E:</strong> info@ztl.care <strong>W:</strong> www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif
    </div>
</div>

<table>
    <tr>
        <td class="label-col" style="width:25%;">
            <strong>Call the office</strong><br>
            <strong>Get medical help</strong>
        </td>
        <td style="width:67%;">
            <strong>6. You entered a Service User's room and found him/her unconscious/unresponsive what would be the first action you would take?</strong><br>
            <div style="min-height:30px; border-top:1px solid #ccc; margin-top:3px; padding-top:3px;"></div>
        </td>
        <td class="score-col" style="width:8%;"></td>
    </tr>
    <tr>
        <td class="label-col">
            <strong>Try to calm situation, give space and time</strong><br>
            <strong>Show empathy</strong><br>
            <strong>Listen</strong><br>
            <strong>Understand situation</strong><br>
            <strong>Divert attention to positive activity</strong><br>
            <strong>Remove from environment/situation</strong>
        </td>
        <td>
            <strong>7. If you were unable to gain access entering in an allocated service. What would you do?</strong><br>
            <div style="min-height:30px; border-top:1px solid #ccc; margin-top:3px; padding-top:3px;"></div>
        </td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="label-col"></td>
        <td>
            <strong>8. How would you deal with a Service User that was aggressive?</strong><br>
            <div style="min-height:30px; border-top:1px solid #ccc; margin-top:3px; padding-top:3px;"></div>
        </td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="label-col">
            <strong>Communication</strong><br>
            <ul class="bullet-list" style="font-style:italic;">
                <li>Listening</li>
                <li>Talking</li>
                <li>Makaton</li>
                <li>Signing</li>
                <li>Touch</li>
                <li>Eye contact</li>
                <li>Objects/symbols</li>
                <li>Pictures/ photos</li>
                <li>PCs, electronic devices</li>
                <li>Show range of options</li>
                <li>Body language techniques</li>
                <li>Interaction with colleagues</li>
                <li>Inform the office</li>
                <li>Makes notes in the care plan</li>
                <li>Get medical assistance</li>
            </ul>
        </td>
        <td>
            <strong>9. How would you support individuals with limited communication skills? If they were unable to speak, hear or see.</strong><br>
            <div style="min-height:40px; border-top:1px solid #ccc; margin-top:3px; padding-top:3px;"></div>
        </td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="label-col"></td>
        <td>
            <strong>10. How would you inform the team of any issues/problems/concerns that you may of have about the service user?</strong><br>
            <div style="min-height:30px; border-top:1px solid #ccc; margin-top:3px; padding-top:3px;"></div>
        </td>
        <td class="score-col"></td>
    </tr>
</table>

<div class="page-break"></div>

{{-- PAGE 5: COMPETENCY QUESTIONS (11-13) --}}
<div class="header">
    <div class="header-left">
        <strong>358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA</strong><br>
        <strong>T:</strong> 01698 701199<br>
        <strong>E:</strong> info@ztl.care <strong>W:</strong> www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif
    </div>
</div>

<table>
    <tr>
        <td class="label-col" style="width:25%;">
            <strong>Prompting Independence</strong><br>
            <ul class="bullet-list" style="font-style:italic;">
                <li>Balancing right to make choices & duty of care</li>
                <li>Encourage informed choices</li>
                <li>Listen to and show respect to individuals we support</li>
                <li>Activities with and not for the individuals we support</li>
                <li>Speaking to other relevant people (e.g., relevant professionals or family carers</li>
                <li>Mental support</li>
                <li>Cooking for them</li>
                <li>Communication</li>
            </ul>
        </td>
        <td style="width:67%;">
            <strong>11. How would you promote the independence of a service user?</strong><br>
            <div style="min-height:40px; border-top:1px solid #ccc; margin-top:3px; padding-top:3px;"></div>
        </td>
        <td class="score-col" style="width:8%;"></td>
    </tr>
    <tr>
        <td class="label-col">
            <strong>Assessing risk</strong><br>
            <strong>Report it to the office</strong><br>
            <strong>Assess if there is imminent danger</strong><br>
            <strong>Speak to maintenance person from that service; inform the manager of the service</strong>
        </td>
        <td>
            <strong>12. What would you do if you will find a faulty equipment in an allocated service?</strong><br>
            <div style="min-height:40px; border-top:1px solid #ccc; margin-top:3px; padding-top:3px;"></div>
        </td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="label-col">
            <strong>Hygiene/Diet</strong><br>
            <ul class="bullet-list">
                <li>Wear gloves</li>
                <li>Hand Washing</li>
                <li>Aprons</li>
                <li>Uniforms</li>
                <li>Nutrition and Hydration</li>
                <li>Promoting a well-balanced diet which will meet the service User's needs.</li>
            </ul>
        </td>
        <td>
            <strong>13. What is your understanding about Dietitians and supplements? How would you support a service user who is at high risk of malnutrition?</strong><br>
            <div style="min-height:40px; border-top:1px solid #ccc; margin-top:3px; padding-top:3px;"></div>
        </td>
        <td class="score-col"></td>
    </tr>
</table>

<div class="page-break"></div>

{{-- PAGE 6: COMPETENCY QUESTIONS (14-16) --}}
<div class="header">
    <div class="header-left">
        <strong>358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA</strong><br>
        <strong>T:</strong> 01698 701199<br>
        <strong>E:</strong> info@ztl.care <strong>W:</strong> www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif
    </div>
</div>

<table>
    <tr>
        <td class="label-col" style="width:25%;">
            <strong>Abuse</strong><br>
            <ul class="bullet-list" style="font-style:italic;">
                <li>Violation of human/civil rights</li>
                <li>Many forms single/ repeated act</li>
                <li>Can be subtle</li>
                <li>Omission to act</li>
                <li>Crossed boundaries</li>
                <li>Can be: Physical/Sexual/Verbal/Psychological/ Emotional/financial/ theft/ Neglect</li>
            </ul>
        </td>
        <td style="width:67%;">
            <strong>14 Can you give me 3 types of abuse?</strong><br>
            <div style="min-height:40px; border-top:1px solid #ccc; margin-top:3px; padding-top:3px;"></div>
        </td>
        <td class="score-col" style="width:8%;"></td>
    </tr>
    <tr>
        <td class="label-col">
            <strong>Act immediately</strong><br>
            <strong>Report it to Line Mgr.</strong><br>
            <strong>Refer to whistleblowing policy</strong>
        </td>
        <td>
            <strong>15. What should you do if you suspected a Service User is being abused?</strong><br>
            <div style="min-height:40px; border-top:1px solid #ccc; margin-top:3px; padding-top:3px;"></div>
        </td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="label-col">
            <strong>Mental Heath</strong><br>
            <ul class="bullet-list">
                <li>Dementia</li>
                <li>Depression</li>
                <li>Anger</li>
                <li>Drugs</li>
                <li>Eating disorder</li>
                <li>Panic attacks</li>
            </ul>
        </td>
        <td>
            <strong>16. You identify a resident with advanced dementia and challenging behavior in a communal area being aggressive near others. How would you manage this situation?</strong><br>
            <div style="min-height:40px; border-top:1px solid #ccc; margin-top:3px; padding-top:3px;"></div>
        </td>
        <td class="score-col"></td>
    </tr>
</table>

<div class="page-break"></div>

{{-- PAGE 7: MANDATORY QUESTIONS --}}
<div class="header">
    <div class="header-left">
        <strong>358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA</strong><br>
        <strong>T:</strong> 01698 701199<br>
        <strong>E:</strong> info@ztl.care <strong>W:</strong> www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif
    </div>
</div>

<table>
    <tr><td class="section-header" colspan="2">C. Mandatory Questions:</td><td class="section-header" style="width:35%;">Answers:</td></tr>
    <tr>
        <td style="width:5%;">1.</td>
        <td style="width:60%;">Are you prepared to travel within this role?</td>
        <td></td>
    </tr>
    <tr>
        <td>2.</td>
        <td>Are you prepared to support individuals in all needs required?</td>
        <td></td>
    </tr>
    <tr>
        <td>3.</td>
        <td>Does the candidate have any Holidays/Annual Leave planned for the next 12 months?</td>
        <td></td>
    </tr>
    <tr>
        <td>4.</td>
        <td>Advise candidate of hourly rate & any enhancements</td>
        <td></td>
    </tr>
    <tr>
        <td>5.</td>
        <td>Discuss any cautions/ convictions/reprimands declared on application & details that would appear on your Disclosure Scotland.</td>
        <td></td>
    </tr>
    <tr>
        <td>6.</td>
        <td>Have you explained the 0-hr contract?</td>
        <td></td>
    </tr>
    <tr>
        <td>7.</td>
        <td>What is your notice period to current Job?</td>
        <td></td>
    </tr>
    <tr>
        <td>8.</td>
        <td>Do you have any questions that you may want to ask?</td>
        <td></td>
    </tr>
    <tr>
        <td>9.</td>
        <td>Uniform Size</td>
        <td></td>
    </tr>
</table>

<div class="page-break"></div>

{{-- PAGE 8: SUMMARY & SCORING --}}
<div class="header">
    <div class="header-left">
        <strong>358 Brandon Street Motherwell<br>North Lanarkshire ML1 1XA</strong><br>
        <strong>T:</strong> 01698 701199<br>
        <strong>E:</strong> info@ztl.care <strong>W:</strong> www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif
    </div>
</div>

<h2>Overall Assessment Process – Summary & Scoring</h2>

<table>
    <tr class="section-header">
        <th style="width:25%;">Area</th>
        <th style="width:75%;">Feedback/Comments</th>
    </tr>
    <tr>
        <td>Interview score</td>
        <td style="min-height:30px;">{{ $interview->total_score ?? '' }}</td>
    </tr>
</table>

<table>
    <tr><td class="section-header" colspan="2">Details of Offer of Engagement – To be completed after all interviews are completed. (In the case of rejection, leave section blank)</td></tr>
    <tr>
        <td style="width:25%;">Position:</td>
        <td>{{ $interview->position_offered }}</td>
    </tr>
</table>

<table>
    <tr><td class="section-header" colspan="4">Recruitment Authorization:</td></tr>
    <tr>
        <td style="width:25%;">Name of Interviewer</td>
        <td style="width:25%;"></td>
        <td style="width:25%;">Signed</td>
        <td style="width:25%;">Date:</td>
    </tr>
    <tr>
        <td>{{ $interview->recruiter_name }}</td>
        <td></td>
        <td>{{ $interview->interviewer_signature_name }}</td>
        <td>{{ $formatDate($interview->interviewer_signed_at) }}</td>
    </tr>
</table>

</body>
</html>
