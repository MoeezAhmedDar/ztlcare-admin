{{-- resources/views/pdf/reference-request.blade.php --}}
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
            font-size: {{ $ref->font_size ?? 10.00 }}pt;
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
            padding-bottom: 80px; /* Prevents footer overlap */
        }

        .page-break {
            page-break-before: always;
        }

        /* Updated to match the light teal from ZTL CARE logo heart */
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

        /* Prevent rating table from splitting across pages */
        .rating-table {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

    @if($wavesBase64)
        <img src="{{ $wavesBase64 }}" class="waves" style="object-fit: cover;">
    @endif

    <!-- PAGE 1 ONLY HEADER -->
    <div class="content">

        <div style="position:relative; height:50px; margin-bottom:8px;">
            <div style="position:absolute; left:0; top:0; font-size:10.0pt; line-height:1.1;">
                358 Brandon Street Motherwell North<br>
                Lanarkshire ML1 1XA<br>
                T: 01698 701199<br>
                E: info@ztl.care  W: www.ztl.care
            </div>
            <div style="position:absolute; right:0; top:0; text-align:right;">
                @if($logoBase64)
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

        <!-- APPLICANT -->
        <table>
            <tr><td class="blue" colspan="2">DETAILS OF APPLICANT:</td></tr>
            <tr><td style="width:20%;">Surname:</td><td>{{ $ref->surname ?? '' }}</td></tr>
            <tr><td>Forename:</td><td>{{ $ref->forename ?? '' }}</td></tr>
            <tr><td>Position:</td><td>{{ $ref->position ?? '' }}</td></tr>
            <tr><td>Home Address:</td><td style="height:65px;">{{ nl2br(e($ref->home_address ?? '')) }}</td></tr>
        </table>

        <!-- EMPLOYMENT HISTORY -->
        <table>
            <tr><td class="blue" colspan="2">EMPLOYMENT HISTORY:</td></tr>
            <tr>
                <td style="width:50%;">Start Date:<br>{{ $ref->start_date ?? '' }}</td>
                <td>Leaving Date:<br>{{ $ref->leaving_date ?? '' }}</td>
            </tr>
            <tr>
                <td style="vertical-align:top;">
                    Job Title:<br>
                    <div style="min-height:40px; margin-top:6px;">{{ $ref->job_title ?? '' }}</div>
                </td>
                <td style="vertical-align:top;">
                    In what capacity do you know the applicant?<br>
                    <div class="large-blank">{{ nl2br(e($ref->capacity ?? '')) }}</div>
                </td>
            </tr>
            <tr>
                <td>Reason for leaving:<br>{{ $ref->reason_leaving ?? '' }}</td>
                <td>Gross annual salary on leaving:<br>{{ $ref->gross_salary ?? '' }}</td>
            </tr>
            <tr><td colspan="2">Brief description of duties:<br><div class="large-blank">{{ nl2br(e($ref->duties ?? '')) }}</div></td></tr>
        </table>

        <!-- SKILLS -->
        <table>
            <tr><td colspan="2">Referring to the job description, please describe the applicant’s ability to undertake their role:<br><div class="large-blank">{{ nl2br(e($ref->ability_role ?? '')) }}</div></td></tr>
            <tr><td colspan="2">Describe applicant’s time management skills:<br><div class="large-blank">{{ nl2br(e($ref->time_management ?? '')) }}</div></td></tr>
            <tr><td colspan="2">Describe the applicant’s reliability:<br><div class="large-blank">{{ nl2br(e($ref->reliability ?? '')) }}</div></td></tr>
            <tr><td colspan="2">Please inform us of any disciplinary actions that might have been taken against the applicant:<br><div class="large-blank">{{ nl2br(e($ref->disciplinary ?? '')) }}</div></td></tr>
        </table>

        <!-- RE-EMPLOY -->
        <table style="margin-bottom:20px;">
            <tr>
                <td colspan="2" style="height:70px;">
                    <strong>Would you re-employ the applicant? YES/NO</strong><br>
                    If NO, please indicate why:<br>
                    <div class="large-blank">{{ nl2br(e($ref->reemploy ?? '')) }}</div>
                </td>
            </tr>
        </table>

        <!-- CRIMINAL & OTHER INFO -->
        <table>
            <tr><td colspan="2">To your knowledge, has the applicant ever been convicted of a criminal offence (subject to Rehabilitation of Offenders Act 1974 Provisions)? If yes please give details:<br><div class="large-blank">{{ nl2br(e($ref->criminal ?? '')) }}</div></td></tr>
            <tr><td colspan="2">Do you have any other information regarding this application, which you believe, should be known to us as prospective employers?<br><div class="large-blank">{{ nl2br(e($ref->other_info ?? '')) }}</div></td></tr>
        </table>

        <!-- RATING TABLE - WILL NOT SPLIT -->
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

    <!-- PAGE 2 - NO HEADER -->
    <div class="content">

        <table>
            <tr><td class="blue" colspan="2">DETAILS OF REFEREE:</td></tr>
            <tr><td style="width:50%;">Position:</td><td>{{ $ref->ref_position ?? '' }}</td></tr>
            <tr><td>Date:</td><td>{{ $ref->ref_date ?? '' }}</td></tr>
            <tr><td>Signed:</td><td>{{ $ref->ref_signed ?? '' }}</td></tr>
            <tr><td>Printed Name:</td><td>{{ $ref->ref_name ?? '' }}</td></tr>
            <tr><td colspan="2">Company details including email address and phone number:<br><div class="blank">{{ nl2br(e($ref->ref_company ?? '')) }}</div></td></tr>
            <tr><td colspan="2">Company Stamp:<br><div style="height:100px; border:1px solid #000;">&nbsp;</div></td></tr>
        </table>

        <table>
            <tr><td class="blue">FOR OFFICE USE ONLY</td></tr>
            <tr><td>Reference checked and verified by:<br>{{ $ref->office_verified ?? '' }}</td></tr>
            <tr><td>Signed:<br>{{ $ref->office_signed ?? '' }}</td></tr>
            <tr><td>Printed name:<br>{{ $ref->office_name ?? '' }}</td></tr>
            <tr><td>Position:<br>{{ $ref->office_position ?? '' }}</td></tr>
            <tr><td>Date:<br>{{ $ref->office_date ?? '' }}</td></tr>
            <tr><td>Comments:<br><div class="large-blank">{{ nl2br(e($ref->office_comments ?? '')) }}</div></td></tr>
        </table>

    </div>

</body>
</html>