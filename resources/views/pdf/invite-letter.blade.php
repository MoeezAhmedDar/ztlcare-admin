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
            font-size: {{ $letter->font_size ?? 10.00 }}pt;
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
        }
        .b { font-weight: bold; }
        .up { text-transform: uppercase; }
        .phone { font-size: 11.8pt; margin: 4px 0 6px; }
        
        /* New style for Date + Reference line */
        .date-reference {
            position: relative;
            margin: 8px 0;
        }
        .date-reference .ref {
            position: absolute;
            right: 0;
            top: 0;
        }
    </style>
</head>
<body>
    <!-- WAVES – IDENTICAL TO REJECTION LETTER -->
    @if($wavesBase64)
        <img src="{{ $wavesBase64 }}" class="waves" style="object-fit: cover;">
    @endif
    <!-- MAIN CONTENT -->
    <div class="content">
        <div style="position:relative; font-size:10.0pt; height:50px; margin-bottom:8px;">
            <div style="position:absolute; left:0; top:0; line-height:1.1;">
                358 Brandon Street Motherwell North<br>
                Lanarkshire ML1 1XA<br>
                T: 01698 701199<br>
                E: info@ztl.care W:
            </div>
            <div style="position:absolute; right:0; top:0; text-align:right;">
                <img src="{{ $logoBase64 }}" style="height:40px; max-width:150px;" alt="ZTL CARE">
            </div>
        </div>
        <br><br><br><br>
        <div style="text-align:center; font-weight:bold; text-transform:uppercase; font-size:12.8pt; margin:5px 0 7px;">
            INTERVIEW INVITATION
        </div>

        <!-- Updated Date + Reference line -->
        <div class="date-reference">
            <p>Date: <strong>
                {{ $letter->date 
                    ? \Carbon\Carbon::parse($letter->date)->translatedFormat('d-m-Y') 
                    : '_____________________' 
                }}
            </strong></p>
            <div class="ref">
                <strong>Reference: ZTL-II-00{{ $letter->id ?? '____' }}</strong>
            </div>
        </div>

        <!-- <p>To: <strong>{{ $letter->to_name ?? '_____________________' }}</strong></p> -->
        <p>Dear <strong>{{ $letter->applicant->full_name ?? 'Applicant' }}</strong>,</p>
        <div style="text-align:justify; margin:5px 0 10px;">
            <p>Thank you for applying for the post of <strong>{{ $letter->position ?? '_________' }}</strong> at ZTL CARE.</p>
            <p>We would like to invite you for an interview at the above address at <strong>{{ $letter->time ?? '_______' }}</strong> on <strong>{{ $letter->interview_date ?? '___________' }}</strong>.</p>
            <p>If you are unable to attend, please telephone us on the number provided above.</p>
            <p>You should bring the following items with you when you attend, or we will not be able to progress your application:</p>
            <ul style="margin:2px 0 2px 19px; padding:0;">
                @php
                $default_docs = [
                    "Evidence of your National Insurance Number",
                    "Right to work documentation",
                    "Either a passport, driving licence or other form of photographic identification"
                ];
                $docs = !empty(trim($letter->custom_documents ?? ''))
                    ? array_filter(array_map('trim', explode("\n", $letter->custom_documents)))
                    : $default_docs;
                @endphp
                @foreach($docs as $doc)
                    <li>{{ $doc }}</li>
                @endforeach
            </ul>
            <p style="font-weight:bold; margin:5px 0 1px;">In addition to the above:</p>
            <ul style="margin:2px 0 2px 19px; padding:0;">
                <li>Proof of address (utility bill, bank statement, etc – not older than 3 months)</li>
                <li>Two recent ‘head and shoulders’ photographs</li>
                <li>Original certificates relevant to the role</li>
                <li>SSSC or other registration evidence if applicable</li>
            </ul>
            <p>If you are unable to provide any of the above required documents, please contact the office for advice.</p>
            <p>We look forward to meeting you soon.</p>
        </div>
        <div>
            <p>Yours sincerely,</p>
            <br>
            <br>
            <p style="margin-top:9px;">Director ZTL Care.</p>
        </div>
    </div>
</body>
</html>