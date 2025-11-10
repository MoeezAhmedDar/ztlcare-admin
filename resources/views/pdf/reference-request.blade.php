<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { 
            margin: 28px 38px 45px 38px; 
            size: A4; 
        }
        body { 
            font-family:"Calibri",Arial,sans-serif; 
            font-size:10.4pt; 
            line-height:1.22; 
            color:#000; 
            position: relative;
            min-height: 100vh;
        }
        .header { 
            position: relative; 
            height: 50px; 
            margin-bottom: 15px; 
        }
        .footer { 
            position: fixed; 
            bottom: 26px; 
            left: 0; 
            right: 0; 
            text-align: center; 
            font-size: 8.7pt; 
        }
        .blue { 
            background:#d9edf7; 
            font-weight:bold; 
            padding:6px; 
        }
        table { 
            width:100%; 
            border-collapse:collapse; 
            margin-bottom:12px; 
        }
        td { 
            border:1px solid #000; 
            padding:6px; 
            vertical-align:top; 
        }
        .blank { 
            height:45px; 
        }
        .large-blank { 
            height:70px; 
        }
        .checkbox { 
            width:18px; 
            height:18px; 
            border:1px solid #000; 
            display:inline-block; 
            text-align:center; 
            line-height:18px; 
            font-size:9pt; 
        }
        .page-break { 
            page-break-before: always; 
        }
        .no-border { 
            border:none; 
        }
        .content { 
            padding-bottom: 60px; /* Prevents overlap with footer */
        }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <div style="position: absolute; left: 0; top: 0; font-size: 8.8pt; line-height: 1.1;">
        358 Brandon Street Motherwell<br>
        North Lanarkshire ML1 1XA<br>
        T: 01698 701199<br>
        E: info@ztl.care W: www.ztl.care
    </div>
    <div style="position: absolute; right: 0; top: 0; text-align: right;">
        @if($logoBase64)
            <img src="{{ $logoBase64 }}" style="height: 40px; display: block;" alt="ZTL CARE">
        @endif
       
    </div>
</div>

<!-- TITLE -->
<div style="text-align:center; font-weight:bold; font-size:12pt; margin:18px 0 8px;">
    ZAN Traders Ltd - Company Registration Number: SC675141
</div>
<div style="text-align:center; font-weight:bold; font-size:14pt; margin-bottom:18px;">
    Reference Request Form
</div>
<div style="text-align:center; font-weight:bold; margin-bottom:20px;">
    ZAN Traders Ltd.
</div>

<!-- PAGE 1 CONTENT (UP TO RE-EMPLOY) -->
<div class="content">

    <!-- APPLICANT -->
    <table>
        <tr><td class="blue" colspan="2">DETAILS OF APPLICANT:</td></tr>
        <tr><td style="width:20%;">Surname:</td><td>{{ $surname ?? '' }}</td></tr>
        <tr><td>Forename:</td><td>{{ $forename ?? '' }}</td></tr>
        <tr><td>Position:</td><td>{{ $position ?? '' }}</td></tr>
        <tr><td>Home Address:</td><td style="height:65px;">{{ $home_address ?? '' }}</td></tr>
    </table>

    <!-- EMPLOYMENT HISTORY -->
    <table>
        <tr><td class="blue" colspan="2">EMPLOYMENT HISTORY:</td></tr>
        <tr>
            <td style="width:50%;">Start Date:<br>{{ $start_date ?? '' }}</td>
            <td>Leaving Date:<br>{{ $leaving_date ?? '' }}</td>
        </tr>
        <tr>
            <td>Job Title:<br>{{ $job_title ?? '' }}</td>
            <td>In what capacity do you know the applicant?<br>{{ $capacity ?? '' }}</td>
        </tr>
        <tr>
            <td>Reason for leaving:<br>{{ $reason_leaving ?? '' }}</td>
            <td>Gross annual salary on leaving:<br>{{ $gross_salary ?? '' }}</td>
        </tr>
        <tr><td colspan="2">Brief description of duties:<br><div class="large-blank">{{ $duties ?? '' }}</div></td></tr>
    </table>

    <!-- SKILLS -->
    <table>
        <tr><td colspan="2">Referring to the job description, please describe the applicant’s ability to undertake their role:<br><div class="large-blank">{{ $ability_role ?? '' }}</div></td></tr>
        <tr><td colspan="2">Describe applicant’s time management skills:<br><div class="large-blank">{{ $time_management ?? '' }}</div></td></tr>
        <tr><td colspan="2">Describe the applicant’s reliability:<br><div class="large-blank">{{ $reliability ?? '' }}</div></td></tr>
        <tr><td colspan="2">Please inform us of any disciplinary actions that might have been taken against the applicant:<br><div class="large-blank">{{ $disciplinary ?? '' }}</div></td></tr>
    </table>

    <!-- RE-EMPLOY — LAST ON PAGE 1 -->
    <table style="margin-bottom: 20px;">
        <tr>
            <td colspan="2" style="height:70px;">
                <strong>Would you re-employ the applicant? YES/NO</strong><br>
                If NO, please indicate why:<br>
                <div class="large-blank">{{ $reemploy ?? '' }}</div>
            </td>
        </tr>
    </table>

<!-- </div> -->

<!-- PAGE BREAK -->
<!-- <div class="page-break"></div> -->

<!-- PAGE 2 -->
<!-- <div class="header"></div>
<div class="content"> -->

    <table>
        <tr><td colspan="2">To your knowledge, has the applicant ever been convicted of a criminal offence (subject to Rehabilitation of Offenders Act 1974 Provisions)? If yes please give details:<br><div class="large-blank">{{ $criminal ?? '' }}</div></td></tr>
        <tr><td colspan="2">Do you have any other information regarding this application, which you believe, should be known to us as prospective employers?<br><div class="large-blank">{{ $other_info ?? '' }}</div></td></tr>
    </table>

    <table>
        <tr><td class="blue" colspan="5">How does the applicant rate in the following areas?</td></tr>
        <tr>
            <td class="no-border"></td>
            <td class="blue">Poor</td>
            <td class="blue">Average</td>
            <td class="blue">Good</td>
            <td class="blue">Excellent</td>
        </tr>
        <tr><td>Ability</td><td class="checkbox"></td><td class="checkbox"></td><td class="checkbox"></td><td class="checkbox"></td></tr>
        <tr><td>Character</td><td class="checkbox"></td><td class="checkbox"></td><td class="checkbox"></td><td class="checkbox"></td></tr>
        <tr><td>Attendance</td><td class="checkbox"></td><td class="checkbox"></td><td class="checkbox"></td><td class="checkbox"></td></tr>
        <tr><td>Punctuality</td><td class="checkbox"></td><td class="checkbox"></td><td class="checkbox"></td><td class="checkbox"></td></tr>
        <tr><td>Honesty</td><td class="checkbox"></td><td class="checkbox"></td><td class="checkbox"></td><td class="checkbox"></td></tr>
    </table>

</div>

<!-- PAGE BREAK -->
<div class="page-break"></div>

<!-- PAGE 3 -->
<div class="header"></div>
<div class="content">

    <table>
        <tr><td class="blue" colspan="2">DETAILS OF REFEREE:</td></tr>
        <tr><td style="width:50%;">Position:</td><td>{{ $ref_position ?? '' }}</td></tr>
        <tr><td>Date:</td><td>{{ $ref_date ?? '' }}</td></tr>
        <tr><td>Signed:</td><td>{{ $ref_signed ?? '' }}</td></tr>
        <tr><td>Printed Name:</td><td>{{ $ref_name ?? '' }}</td></tr>
        <tr><td colspan="2">Company details including email address and phone number:<br><div class="blank">{{ $ref_company ?? '' }}</div></td></tr>
        <tr><td colspan="2">Company Stamp:<br><div style="height:100px; border:1px solid #000;">&nbsp;</div></td></tr>
    </table>

    <table>
        <tr><td class="blue">FOR OFFICE USE ONLY</td></tr>
        <tr><td>Reference checked and verified by:<br>{{ $office_verified ?? '' }}</td></tr>
        <tr><td>Signed:<br>{{ $office_signed ?? '' }}</td></tr>
        <tr><td>Printed name:<br>{{ $office_name ?? '' }}</td></tr>
        <tr><td>Position:<br>{{ $office_position ?? '' }}</td></tr>
        <tr><td>Date:<br>{{ $office_date ?? '' }}</td></tr>
        <tr><td>Comments:<br><div class="large-blank">{{ $office_comments ?? '' }}</div></td></tr>
    </table>

</div>

<!-- BOXED FOOTER (ALL PAGES) -->
<div class="footer">
    <div style="display:inline-block; border:1.2px solid #000; padding:7px 20px; background:#fff; font-size:8.7pt;">
        ZAN Traders Ltd - Company Registration Number: <strong>SC675141</strong>
    </div>
</div>

</body>
</html>