<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 10px 20px 35px 20px; }
        body {
            margin: 0;
            padding: 0;
            font-family: "Arial";
            font-size: {{ $font_size ?? 10.00 }}pt;
            line-height: 1.22;
            color: #000;
        }

        .waves {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 210mm;
            height: 300px;
            z-index: 1;
            pointer-events: none;
        }

        .footer {
            position: fixed;
            bottom: 38px;
            width: 100%;
            text-align: center;
            font-size: 8.7pt;
            color: #000;
            z-index: 999;
        }

        .content {
            position: relative;
            z-index: 10;
            margin: 0 20px;
            padding-top: 10px;
            padding-bottom: 80px;
        }

        .page-break {
            page-break-before: always;
        }

        .blue { 
            background: #B0E0EF; 
            font-weight: bold; 
            padding: 6px; 
        }

        table { width:100%; border-collapse:collapse; margin-bottom:12px; }
        td { border:1px solid #000; padding:6px; vertical-align:top; }
        .blank { height:45px; }
        .large-blank {
            min-height: 70px;
            margin-top: 6px;
            padding: 4px;
            border: 1px solid transparent;
        }
        .checkbox {
            width:16px;
            height:16px;
            border:1.2px solid #000;
            display:inline-block;
            margin:0 auto;
        }
        .no-border td { border:none; }

        .rating-table {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

    @if($wavesBase64 ?? false)
        <img src="{{ $wavesBase64 }}" class="waves" style="object-fit: cover;">
    @endif

    <!-- PAGE 1 -->
    <div class="content">

        <div style="position:relative; height:50px; margin-bottom:8px;">
            <div style="position:absolute; left:0; top:0; font-size:10.0pt; line-height:1.1;">
                358 Brandon Street Motherwell North<br>
                Lanarkshire ML1 1XA<br>
                T: 01698 701199<br>
                E: info@ztl.care  W: www.ztl.care
            </div>
            <div style="position:absolute; right:0; top:0; text-align:right;">
                @if($logoBase64 ?? false)
                    <img src="{{ $logoBase64 }}" style="height:40px; max-width:150px;" alt="ZTL CARE">
                @endif
            </div>
        </div>

        <br><br><br><br>

        <div style="text-align:center; font-weight:bold; text-transform:uppercase; font-size:12.8pt; margin:5px 0 7px;">
            Reference Request Form
        </div>

        <div style="text-align:center; font-weight:bold; margin-bottom:20px;">
            ZAN Traders Ltd.
        </div>

        <!-- APPLICANT - EXAMPLE VALUES -->
        <table>
            <tr><td class="blue" colspan="2">DETAILS OF APPLICANT:</td></tr>
            <tr><td style="width:20%;">Surname:</td><td>Smith</td></tr>
            <tr><td>Forename:</td><td>John</td></tr>
            <tr><td>Position:</td><td>Care Support Worker</td></tr>
            <tr><td>Home Address:</td><td style="height:65px;">123 Example Street<br>Example Town<br>EX1 2AB</td></tr>
        </table>

        <!-- EMPLOYMENT HISTORY -->
        <table>
            <tr><td class="blue" colspan="2">EMPLOYMENT HISTORY:</td></tr>
            <tr>
                <td style="width:50%;">Start Date:<br>15-06-2022</td>
                <td>Leaving Date:<br>28-02-2025</td>
            </tr>
            <tr>
                <td style="vertical-align:top;">
                    Job Title:<br>
                    <div style="min-height:40px; margin-top:6px;">Support Worker</div>
                </td>
                <td style="vertical-align:top;">
                    In what capacity do you know the applicant?<br>
                    <div class="large-blank">Line Manager / Supervisor</div>
                </td>
            </tr>
            <tr>
                <td>Reason for leaving:<br>Seeking new opportunities</td>
                <td>Gross annual salary on leaving:<br>£24,960</td>
            </tr>
            <tr><td colspan="2">Brief description of duties:<br><div class="large-blank">Personal care, medication administration, supporting daily living activities, record keeping, shift handovers</div></td></tr>
        </table>

        <!-- SKILLS - LEFT BLANK FOR EXAMPLE -->
        <table>
            <tr><td colspan="2">Referring to the job description, please describe the applicant’s ability to undertake their role:<br><div class="large-blank">&nbsp;</div></td></tr>
            <tr><td colspan="2">Describe applicant’s time management skills:<br><div class="large-blank">&nbsp;</div></td></tr>
            <tr><td colspan="2">Describe the applicant’s reliability:<br><div class="large-blank">&nbsp;</div></td></tr>
            <tr><td colspan="2">Please inform us of any disciplinary actions that might have been taken against the applicant:<br><div class="large-blank">&nbsp;</div></td></tr>
        </table>

        <!-- RE-EMPLOY -->
        <table style="margin-bottom:20px;">
            <tr>
                <td colspan="2" style="height:70px;">
                    <strong>Would you re-employ the applicant? YES/NO</strong><br>
                    If NO, please indicate why:<br>
                    <div class="large-blank">&nbsp;</div>
                </td>
            </tr>
        </table>

        <!-- CRIMINAL & OTHER INFO -->
        <table>
            <tr><td colspan="2">To your knowledge, has the applicant ever been convicted of a criminal offence (subject to Rehabilitation of Offenders Act 1974 Provisions)? If yes please give details:<br><div class="large-blank">&nbsp;</div></td></tr>
            <tr><td colspan="2">Do you have any other information regarding this application, which you believe, should be known to us as prospective employers?<br><div class="large-blank">&nbsp;</div></td></tr>
        </table>

        <!-- RATING TABLE -->
        <table class="rating-table">
            <tr><td class="blue" colspan="5">How does the applicant rate in the following areas?</td></tr>
            <tr>
                <td class="no-border" style="width:35%;"></td>
                <td class="blue" style="text-align:center;">Poor</td>
                <td class="blue" style="text-align:center;">Average</td>
                <td class="blue" style="text-align:center;">Good</td>
                <td class="blue" style="text-align:center;">Excellent</td>
            </tr>
            @foreach(['Ability', 'Character', 'Attendance', 'Punctuality', 'Honesty'] as $cat)
            <tr>
                <td style="padding:8px 6px;">{{ $cat }}</td>
                <td style="text-align:center;"><div class="checkbox"></div></td>
                <td style="text-align:center;"><div class="checkbox"></div></td>
                <td style="text-align:center;"><div class="checkbox"></div></td>
                <td style="text-align:center;"><div class="checkbox"></div></td>
            </tr>
            @endforeach
        </table>

    </div>

    <!-- PAGE BREAK -->
    <div class="page-break"></div>

    <!-- PAGE 2 -->
    <div class="content">

        <table>
            <tr><td class="blue" colspan="2">DETAILS OF REFEREE:</td></tr>
            <tr><td style="width:50%;">Position:</td><td>&nbsp;</td></tr>
            <tr><td>Date:</td><td>&nbsp;</td></tr>
            <tr><td>Signed:</td><td>&nbsp;</td></tr>
            <tr><td>Printed Name:</td><td>&nbsp;</td></tr>
            <tr><td colspan="2">Company details including email address and phone number:<br><div class="blank">&nbsp;</div></td></tr>
            <tr><td colspan="2">Company Stamp:<br><div style="height:100px; border:1px solid #000;">&nbsp;</div></td></tr>
        </table>

        <table>
            <tr><td class="blue">FOR OFFICE USE ONLY</td></tr>
            <tr><td>Reference checked and verified by:<br>&nbsp;</td></tr>
            <tr><td>Signed:<br>&nbsp;</td></tr>
            <tr><td>Printed name:<br>&nbsp;</td></tr>
            <tr><td>Position:<br>&nbsp;</td></tr>
            <tr><td>Date:<br>&nbsp;</td></tr>
            <tr><td>Comments:<br><div class="large-blank">&nbsp;</div></td></tr>
        </table>

    </div>

</body>
</html>