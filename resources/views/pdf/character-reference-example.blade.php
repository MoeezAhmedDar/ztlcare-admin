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

        .content {
            position: relative;
            z-index: 10;
            margin: 0 20px;
            padding-top: 10px;
        }

        .page-break { page-break-before: always; }

        table { width:100%; border-collapse:collapse; margin-bottom: 16px; }
        td { border:1px solid #000; padding:6px; vertical-align:top; }
        .no-border td { border:none; }
        .signature-box { height:60px; }

        .date-reference-line {
            position: relative;
            margin: 20px 0 12px 0;
            line-height: 1.4;
            font-size: 10.4pt;
        }
        .date-reference-line::after {
            content: "";
            display: table;
            clear: both;
        }
        .date-part {
            float: left;
        }
        .reference-part {
            float: right;
        }

        .letter-body p:first-child {
            margin-top: 0;
        }
    </style>
</head>
<body>

    @if($wavesBase64 ?? false)
        <img src="{{ $wavesBase64 }}" class="waves" style="object-fit: cover;">
    @endif

    <div class="content">

        <!-- HEADER -->
        <div style="position:relative; height:50px; margin-bottom:8px;">
            <div style="position:absolute; left:0; top:0; font-size:10.0pt; line-height:1.1;">
                358 Brandon Street Motherwell North<br>
                Lanarkshire ML1 1XA<br>
                T: 01698 701199<br>
                E: info@ztl.care  W:
            </div>
            <div style="position:absolute; right:0; top:0; text-align:right;">
                @if($logoBase64 ?? false)
                    <img src="{{ $logoBase64 }}" style="height:40px; max-width:150px;" alt="ZTL CARE">
                @endif
            </div>
        </div>

        <br><br><br><br>

        <!-- TITLE -->
        <div style="text-align:center; font-weight:bold; text-transform:uppercase; font-size:12.8pt; margin:5px 0 7px;">
            Character Reference
        </div>

        <!-- DATE AND REFERENCE -->
        <div class="date-reference-line">
            <div class="date-part">
                Date: <strong>{{ now()->format('d-m-Y') }}</strong>
            </div>
            <div class="reference-part">
                <strong>Reference: ZTL-CC-PREVIEW</strong>
            </div>
        </div>

        <!-- MAIN LETTER CONTENT -->
        <div class="letter-body" style="text-align:justify;">
            <p>Dear Sir / Madam,</p>
            
            <p>Re: Reference Request for <strong>Example Applicant Name</strong></p>
            <p>The above has applied for the post of <strong>Care Support Worker</strong> at ZTL Care and has named you as a character referee.</p>
            
            <div style="text-align:justify; margin-top:20px;">
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
        </div>

        <div style="margin-top:16px;">
            <p>Yours sincerely,</p>
            <br>
            <br>
            <p style="margin-top:9px;">Director ZTL Care.</p>
        </div>

        <!-- PAGE BREAK -->
        <div class="page-break"></div>

        <!-- PAGE 2: QUESTIONS + PRIVACY -->
        <div style="margin-top:20px;">

            <!-- QUESTION 1 -->
            <table>
                <tr>
                    <td style="font-weight:bold; height:30px;">How long have you known the candidate and in what capacity?</td>
                </tr>
                <tr>
                    <td style="height:80px;">&nbsp;</td>
                </tr>
            </table>

            <!-- QUESTION 2 -->
            <table>
                <tr>
                    <td style="font-weight:bold; height:40px;">
                        Please state here your views on the person’s ability to work in this role and detail why. We have attached a Job Description and Person Specification to support you with the requirements of the role.
                    </td>
                </tr>
                <tr>
                    <td style="height:140px;">&nbsp;</td>
                </tr>
            </table>

            <!-- QUESTION 3 + SIGNATURE -->
            <table>
                <tr>
                    <td style="font-weight:bold; height:30px;">I confirm that the information provided is accurate and a true reflection of the candidate.</td>
                </tr>
                <tr>
                    <td>
                        <table class="no-border" style="width:100%;">
                            <tr>
                                <td style="border:1px solid #000; height:60px; width:48%;">&nbsp;</td>
                                <td style="width:4%;"></td>
                                <td style="border:1px solid #000; height:60px; width:48%;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:center; font-size:9pt;">Signature</td>
                                <td></td>
                                <td style="text-align:center; font-size:9pt;">Date</td>
                            </tr>
                        </table>

                        <p style="margin-top:12px; font-weight:bold;">Name:</p>
                        <p style="border-bottom:1px solid #000; width:60%; display:inline-block;">&nbsp;</p>
                    </td>
                </tr>
            </table>

            <!-- PRIVACY NOTICE -->
            <div style="margin-top:20px; font-size:10.4pt; text-align:justify;">
                <p style="font-weight:bold;">Privacy</p>
                <p>ZTL Care will only collect data for specified explicit and legitimate use in relation to the recruitment process. By signing this document, you consent to ZTL Care holding the information contained.</p>
                <p>We are required to keep this information within the candidate's personnel file. We cannot estimate the exact time period it will be held for. When that period is over, we will delete your data.</p>
                <p>We have privacy policies that you can request for further information. Please be assured your data will be securely stored by ZTL Care and only used for the purposes of successful recruitment of the candidate.</p>
                <p>You have a right for your data to be forgotten, to rectify or access data, to restrict processing, to withdraw consent and to be kept informed about the processing of your data. If you would like to discuss this further or withdraw your consent at any time, please contact the office on the above number to discuss.</p>
            </div>

        </div>

    </div>

</body>
</html>