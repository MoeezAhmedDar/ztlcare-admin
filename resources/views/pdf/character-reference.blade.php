{{-- resources/views/pdf/character-reference.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 28px 38px 35px 38px; size: A4; }
        body { font-family:"Calibri",Arial,sans-serif; font-size:10.4pt; line-height:1.22; color:#000; }
        .b { font-weight:bold; }
        .u { text-decoration:underline; }
        .footer { position:fixed; bottom:26px; left:0; right:0; text-align:center; font-size:8.7pt; }
        .page-break { page-break-before: always; }
        table { width:100%; border-collapse:collapse; }
        td { border:1px solid #000; padding:6px; vertical-align:top; }
        .empty { height:60px; }
    </style>
</head>
<body>

<!-- HEADER -->
<div style="position: relative; height: 50px; margin-bottom: 15px;">
    <div style="position: absolute; left: 0; top: 0; font-size: 8.8pt; line-height: 1.1;">
        358 Brandon Street Motherwell North<br>
        Lanarkshire ML1 1XA<br>
        T: 01698 701199<br>
        E: info@ztl.care  W:
    </div>
    <div style="position: absolute; right: 0; top: 0; text-align: right;">
        @if($logoBase64)
            <img src="{{ $logoBase64 }}" style="height: 40px; width: auto; display: block; margin: 0; padding: 0; vertical-align: top;" alt="ZTL CARE">
        @endif
        <div style="font-size: 15.5pt; font-weight: bold; margin-top: -3px; line-height: 1;">ZTL CARE</div>
    </div>
</div>

<!-- TITLE -->
<div style="text-align: center; font-weight: bold; font-size: 11pt; margin-top: 18px; margin-bottom: 8px;">
    Character Reference - SPR26
</div>

<!-- COMPANY -->
<div style="font-weight: bold; text-align: left; line-height: 1.05; margin-bottom: 8px;">
    ZAN TRADERS LTD<br>358 Brandon<br>Street<br>Motherwell<br>ML1 1XA
</div>
<div style="font-weight: bold; text-align: left; margin-bottom: 12px;">Tel: 01698 701199</div>

<!-- CANDIDATE - PERSONAL TABLE (3 ROWS) -->
<table>
    <tr>
        <td class="b" style="height:30px;">Candidate - Personal</td>
    </tr>
    <tr>
        <td class="empty">&nbsp;</td>
    </tr>
    <tr>
        <td class="empty">&nbsp;</td>
    </tr>
</table>

<!-- LETTER CONTENT -->
<div style="margin-top:12px; text-align:justify;">
    <p>Date: <span style="border-bottom:1px solid #000; width:300px; display:inline-block;">{{ $date }}</span></p>
    <p>Dear <span style="border-bottom:1px solid #000; width:300px; display:inline-block;">{{ $dear }}</span>,</p>
    <p>Re: Reference Request for <span style="border-bottom:1px solid #000; width:300px; display:inline-block;">{{ $candidate_name }}</span></p>
    <p>The above has applied for the post of <span style="border-bottom:1px solid #000; width:300px; display:inline-block;">{{ $position }}</span> at ZTL Care and has named you as a character referee.</p>
    <p>I should be grateful if you would express your opinion of the suitability of the candidate for the specified post, in addition to the following specific enquiries.</p>
    <p>We would appreciate it if you did not discuss the health of the person.</p>
    <p>Please find enclosed a copy of the Job Description and Person Specification to guide your consideration for the suitability of the candidate.</p>
    <p>Your reply will be kept fully confidential.</p>
    <p>Please could you return the completed reference to me by one of the following secure routes:</p>
    <ul style="margin:4px 0 4px 20px; padding:0;">
        <li>Within the stamped, addressed envelope</li>
        <li>Or, you can also return the form by email to <u>recruitment@ztl.care</u></li>
    </ul>
</div>

<div style="margin-top:16px;">
    <p>Yours sincerely,</p>
    <p style="margin-top:9px;">For and on behalf of ZTL Care</p>
</div>

<!-- PAGE BREAK -->
<div class="page-break"></div>

<!-- PAGE 2: QUESTIONS -->
<div style="margin-top: 20px;">

    <!-- QUESTION 1 -->
    <table>
        <tr>
            <td class="b" style="height:30px;">How long have you known the candidate and in what capacity?</td>
        </tr>
        <tr>
            <td style="height:80px;">&nbsp;</td>
        </tr>
    </table>

    <!-- QUESTION 2 -->
    <table style="margin-top:16px;">
        <tr>
            <td class="b" style="height:40px;">
                Please state here your views on the person’s ability to work in this role and detail why. We have attached a Job Description and Person Specification to support you with the requirements of the role.
            </td>
        </tr>
        <tr>
            <td style="height:140px;">&nbsp;</td>
        </tr>
    </table>

    <!-- QUESTION 3 -->
    <table style="margin-top:16px;">
        <tr>
            <td class="b" style="height:30px;">I confirm that the information provided is accurate and a true reflection of the candidate.</td>
        </tr>
        <tr>
            <td>
                <table style="width:100%; border:none;">
                    <tr>
                        <td style="border:1px solid #000; height:60px; width:48%;">&nbsp;</td>
                        <td style="width:4%;"></td>
                        <td style="border:1px solid #000; height:60px; width:48%;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center; font-size:9pt; border:none;">Signature</td>
                        <td></td>
                        <td style="text-align:center; font-size:9pt; border:none;">Date</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</div>

<!-- BOXED FOOTER -->
<div class="footer">
    <div style="display:inline-block; border:1.2px solid #000; padding:7px 20px; background:#fff; font-size:8.7pt;">
        ZTL CARE - Company Registration Number: <strong>SC675141</strong>
    </div>
</div>

</body>
</html>