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
            font-size: 13px; 
            color: #000; 
            line-height: 1.3; 
        }
        .header { 
            display: table; 
            width: 100%; 
            margin-bottom: 8px; 
        }
        .header-left { 
            display: table-cell; 
            vertical-align: top; 
            width: 55%; 
            font-size: 12px; 
            line-height: 1.35; 
            font-weight: normal; 
        }
        .header-right { 
            display: table-cell; 
            text-align: right; 
            vertical-align: top; 
        }
        .header-right img { 
            width: 200px; 
        }
        h1 { 
            text-align: center; 
            font-size: 18px; 
            margin: 20px 0 20px 0; 
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
            padding: 6px 8px; 
            vertical-align: top; 
            font-size: 13px; 
        }
        .section-header { 
            background: #62c2dd; 
            color: #fff; 
            font-weight: normal; 
            padding: 6px 8px; 
            font-size: 13px; 
        }
        .field-label,
        .section-header { 
            background: #62c2dd; 
            color: #fff; 
            font-weight: normal; 
            padding: 8px 10px; 
            font-size: 13.5px; 
        }
        .label-col { 
            background: #fff; 
            width: 35%; 
        }
        .key-col {
            width: 24%;
            background: #fff;
            padding-right: 6px;
            font-size: 10px;
        }
        .key-title {
            font-size: 12px;
            margin-bottom: 4px;
        }
        .question-col {
            width: 28%;
        }
        .answer-col {
            width: 40%;
        }
        .score-col {
            width: 8%;
            text-align: center;
            background: #f9f9f9;
        }
        .answer-box {
            min-height: 38px;
            border-top: 1px solid #b7d4e5;
            margin-top: 4px;
            padding-top: 4px;
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
            font-size: 11px; 
        }
        .bullet-list li { 
            margin-bottom: 1px; 
        }
        .criteria-table th {
            background: #62c2dd;
            color: #fff;
            font-weight: normal;
            padding: 8px 10px;
            font-size: 12.5px;
        }
        .criteria-table td {
            font-size: 12px;
            padding: 5px 7px;
        }
        .details-table {
            margin-top: 12px;
        }
        .score-label {
            font-size: 13px;
            font-weight: bold;
        }
        .intro-section {
            font-size: 12px;
            margin-bottom: 6px;
        }
        .intro-section li {
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
        358 Brandon Street Motherwell<br>
        North Lanarkshire ML1 1XA<br>
        T: 01698 701199<br>
        E: info@ztl.care &nbsp;&nbsp; W: www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif
    </div>
</div>

<h1>Interview Questionnaire – Carer Support Worker</h1>

<table class="details-table">
    <tr>
        <td class="field-label" style="width:24%;">Recruiters Name:</td>
        <td style="width:30%;">{{ $interview->recruiter_name }}</td>
        <td class="field-label" style="width:20%;">Date of Interview:</td>
        <td colspan="2" style="width:26%;">{{ $formatDate($interview->interview_date) }}</td>
    </tr>
    <tr>
        <td class="field-label">Candidates Name:</td>
        <td colspan="4">{{ $interview->candidate_name }}</td>
    </tr>
    <tr>
        <td class="field-label">Location/Branch:</td>
        <td>{{ $interview->location }}</td>
        <td class="field-label" style="width:20%;">Outcome:<br>(Please Circle)</td>
        <td style="width:13%; text-align:center;">Offer</td>
        <td style="width:13%; text-align:center;">Reject</td>
    </tr>
</table>

<h2>Notes to interviewer</h2>
<p style="font-size:11px; margin-bottom:8px;">The following guidance should be used to ensure consistency and equal opportunities for all candidates. There are model answers provided in the left-hand column. The following criteria should be used as a scoring guide with a maximum award of 3 points per question.</p>

<table class="criteria-table">
    <tr class="section-header">
        <th style="width:10%;">Score</th>
        <th>Criteria for determining score</th>
    </tr>
    <tr>
        <td style="text-align:center; font-weight:bold;">0</td>
        <td><span class="score-label">Poor</span> - Failed to answer the question/ failed to demonstrate any knowledge in area/failed to provide or identify any of the sample answers</td>
    </tr>
    <tr>
        <td style="text-align:center; font-weight:bold;">1</td>
        <td><span class="score-label">Average</span> - Demonstrated limited knowledge in area/answer was brief with little detail/1-2 sample answers given</td>
    </tr>
    <tr>
        <td style="text-align:center; font-weight:bold;">2</td>
        <td><span class="score-label">Good</span> - Demonstrated sound knowledge in area/answer was detailed and included sound explanation/ 2-4 sample answers given</td>
    </tr>
    <tr>
        <td style="text-align:center; font-weight:bold;">3</td>
        <td><span class="score-label">Excellent</span> - Demonstrated extensive knowledge in area/answer was in depth with rationale and relevant example(s)/ 4+ sample answers provided</td>
    </tr>
</table>

<div class="page-break"></div>

{{-- PAGE 2: INTRODUCTIONS & OPENING QUESTIONS --}}
<div class="header">
    <div class="header-left">
        358 Brandon Street Motherwell<br>
        North Lanarkshire ML1 1XA<br>
        T: 01698 701199<br>
        E: info@ztl.care &nbsp;&nbsp; W: www.ztl.care
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
        358 Brandon Street Motherwell<br>
        North Lanarkshire ML1 1XA<br>
        T: 01698 701199<br>
        E: info@ztl.care &nbsp;&nbsp; W: www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif
    </div>
</div>

<table>
    <tr>
        <td class="section-header" colspan="4">B. Role based competency questions (Please complete below section with both comment and scores)</td>
    </tr>
    <tr class="section-header">
        <th style="width:24%;">Key skill area being assessed</th>
        <th style="width:22%;">Question</th>
        <th style="width:46%;">Answer</th>
        <th style="width:8%;">Score</th>
    </tr>
    <tr>
        <td class="key-col" rowspan="2">
            <strong>Role skills / suitability</strong><br>
            Good listener<br>
            Communication<br>
            Patience<br>
            Motivated<br>
            Flexible<br>
            Friendly<br>
            Committed<br>
            Empathy<br>
            Caring<br>
            Punctual<br>
        </td>
        <td class="question-col">1. What qualities or skills do you think make a good care worker?</td>
        <td class="answer-col"><div class="answer-box"></div></td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="question-col">2. What are your strengths and weaknesses?</td>
        <td class="answer-col"><div class="answer-box"></div></td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="key-col" rowspan="2">
            <strong>Teamwork</strong><br>
            Use all communication channels<br>
            Be supportive and open<br>
            Respect others' views<br>
            Encourage and motivate<br>
            Be flexible<br>
            Friendly<br>
            Sharing<br>
        </td>
        <td class="question-col">3. What do you think makes a good team player?</td>
        <td class="answer-col"><div class="answer-box"></div></td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="question-col">4. Give an example of where you supported your team.</td>
        <td class="answer-col"><div class="answer-box"></div></td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="key-col">
            <strong>Problem solving / initiative</strong><br>
            Think on your feet<br>
            Offer creative ideas<br>
            Be resilient<br>
            Identify solutions<br>
            Good decision making<br>
            Assess the problem
            
        </td>
        <td class="question-col">5. Tell us about a situation where you were required to use your initiative.</td>
        <td class="answer-col"><div class="answer-box"></div></td>
        <td class="score-col"></td>
    </tr>
</table>

<div class="page-break"></div>

{{-- PAGE 4: COMPETENCY QUESTIONS (6-10) --}}
<div class="header">
    <div class="header-left">
        358 Brandon Street Motherwell<br>
        North Lanarkshire ML1 1XA<br>
        T: 01698 701199<br>
        E: info@ztl.care &nbsp;&nbsp; W: www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif
    </div>
</div>

<table>
    <tr class="section-header">
        <th style="width:24%;">Key skill area being assessed</th>
        <th style="width:22%;">Question</th>
        <th style="width:46%;">Answer</th>
        <th style="width:8%;">Score</th>
    </tr>
    <tr>
        <td class="key-col">
            <strong>Emergency response</strong><br>
            Call the office<br>
            Seek medical help
        </td>
        <td class="question-col">6. You enter a service user's room and find them unconscious or unresponsive. What is the first action you take?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:42px;"></div></td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="key-col" rowspan="2">
            <strong>De-escalation</strong><br>
            Stay calm and give space<br>
            Listen with empathy<br>
            Understand the situation<br>
            Divert to positive activity<br>
            Remove from risk if required
        </td>
        <td class="question-col">7. If you cannot gain access to an allocated service, what would you do?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:42px;"></div></td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="question-col">8. How would you deal with a service user who was aggressive?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:42px;"></div></td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="key-col" rowspan="2">
            <strong>Communication</strong><br>
            Listening and talking<br>
            Makaton or signing<br>
            Touch and eye contact<br>
            Visual tools and technology<br>
            Body language techniques<br>
            Team communication and notes<br>
            Involve external support
        </td>
        <td class="question-col">9. How would you support individuals with limited communication skills?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:50px;"></div></td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="question-col">10. How would you inform the team of any issues, problems or concerns about the service user?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:42px;"></div></td>
        <td class="score-col"></td>
    </tr>
</table>

<div class="page-break"></div>

{{-- PAGE 5: COMPETENCY QUESTIONS (11-13) --}}
<div class="header">
    <div class="header-left">
        358 Brandon Street Motherwell<br>
        North Lanarkshire ML1 1XA<br>
        T: 01698 701199<br>
        E: info@ztl.care &nbsp;&nbsp; W: www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif
    </div>
</div>

<table>
    <tr class="section-header">
        <th style="width:24%;">Key skill area being assessed</th>
        <th style="width:22%;">Question</th>
        <th style="width:46%;">Answer</th>
        <th style="width:8%;">Score</th>
    </tr>
    <tr>
        <td class="key-col">
            <strong>Prompting independence</strong><br>
            Balance choice with duty of care<br>
            Encourage informed choices<br>
            Show respect to individuals supported<br>
            Support activities with individuals<br>
            Engage relevant professionals or family<br>
            Provide mental and practical support
        </td>
        <td class="question-col">11. How would you promote the independence of a service user?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:48px;"></div></td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="key-col">
            <strong>Assessing risk</strong><br>
            Report concerns to the office<br>
            Evaluate immediate danger<br>
            Contact maintenance support<br>
            Inform the service manager
        </td>
        <td class="question-col">12. What would you do if you found faulty equipment in an allocated service?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:48px;"></div></td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="key-col">
            <strong>Hygiene and diet</strong><br>
            Hand hygiene and protective wear<br>
            Appropriate uniforms<br>
            Nutrition and hydration<br>
            Promoting balanced diets
        </td>
        <td class="question-col">13. What is your understanding of dietitians and supplements? How would you support a service user at high risk of malnutrition?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:48px;"></div></td>
        <td class="score-col"></td>
    </tr>
</table>

<div class="page-break"></div>

{{-- PAGE 6: COMPETENCY QUESTIONS (14-16) --}}
<div class="header">
    <div class="header-left">
        358 Brandon Street Motherwell<br>
        North Lanarkshire ML1 1XA<br>
        T: 01698 701199<br>
        E: info@ztl.care &nbsp;&nbsp; W: www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif
    </div>
</div>

<table>
    <tr class="section-header">
        <th style="width:24%;">Key skill area being assessed</th>
        <th style="width:22%;">Question</th>
        <th style="width:46%;">Answer</th>
        <th style="width:8%;">Score</th>
    </tr>
    <tr>
        <td class="key-col">
            <strong>Abuse awareness</strong><br>
            Human and civil rights<br>
            Single or repeated acts<br>
            Physical, sexual, verbal, psychological<br>
            Emotional, financial, neglect
        </td>
        <td class="question-col">14. Can you give three types of abuse?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:48px;"></div></td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="key-col">
            <strong>Reporting concerns</strong><br>
            Act immediately<br>
            Report to line manager<br>
            Follow whistleblowing policy
        </td>
        <td class="question-col">15. What should you do if you suspect a service user is being abused?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:48px;"></div></td>
        <td class="score-col"></td>
    </tr>
    <tr>
        <td class="key-col">
            <strong>Mental health</strong><br>
            Dementia and depression<br>
            Anger and substance use<br>
            Eating disorders<br>
            Panic attacks
        </td>
        <td class="question-col">16. You identify a resident with advanced dementia and challenging behaviour in a communal area being aggressive near others. How would you manage this situation?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:52px;"></div></td>
        <td class="score-col"></td>
    </tr>
</table>

<div class="page-break"></div>

{{-- PAGE 7: MANDATORY QUESTIONS --}}
<div class="header">
    <div class="header-left">
        358 Brandon Street Motherwell<br>
        North Lanarkshire ML1 1XA<br>
        T: 01698 701199<br>
        E: info@ztl.care &nbsp;&nbsp; W: www.ztl.care
    </div>
    <div class="header-right">
        @if($logoExists)<img src="{{ $logoPath }}" alt="ZTL Care Logo">@endif
    </div>
</div>

<table>
    <tr class="section-header">
        <th style="width:6%;">No.</th>
        <th style="width:40%;">Mandatory questions</th>
        <th style="width:54%;">Answers</th>
    </tr>
    <tr>
        <td>1.</td>
        <td class="question-col">Are you prepared to travel within this role?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:26px;"></div></td>
    </tr>
    <tr>
        <td>2.</td>
        <td class="question-col">Are you prepared to support individuals in all needs required?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:26px;"></div></td>
    </tr>
    <tr>
        <td>3.</td>
        <td>Does the candidate have any holidays or annual leave planned for the next 12 months?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:26px;"></div></td>
    </tr>
    <tr>
        <td>4.</td>
        <td>Advise candidate of hourly rate and any enhancements.</td>
        <td class="answer-col"><div class="answer-box" style="min-height:26px;"></div></td>
    </tr>
    <tr>
        <td>5.</td>
        <td>Discuss any cautions, convictions or reprimands declared on application and any details that would appear on Disclosure Scotland.</td>
        <td class="answer-col"><div class="answer-box" style="min-height:26px;"></div></td>
    </tr>
    <tr>
        <td>6.</td>
        <td>Have you explained the 0-hr contract?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:26px;"></div></td>
    </tr>
    <tr>
        <td>7.</td>
        <td>What is your notice period to your current job?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:26px;"></div></td>
    </tr>
    <tr>
        <td>8.</td>
        <td>Do you have any questions that you may want to ask?</td>
        <td class="answer-col"><div class="answer-box" style="min-height:26px;"></div></td>
    </tr>
    <tr>
        <td>9.</td>
        <td>Uniform Size</td>
        <td class="answer-col"><div class="answer-box" style="min-height:26px;"></div></td>
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
