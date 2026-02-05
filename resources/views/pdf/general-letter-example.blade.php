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
        }

        .greeting-dear {
            margin: 0 0 16px 0;
            text-align: left;
            font-weight: normal;
        }

        .greeting-to-whom {
            margin: 0 0 16px 0;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

    @if($wavesBase64 ?? false)
        <img src="{{ $wavesBase64 }}" class="waves" style="object-fit:cover;">
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

        <br><br><br>

        <!-- DATE – always shown in preview for realism -->
        <p style="margin:20px 0 12px 0;">
            <strong>Date:</strong> {{ now()->format('d-m-Y') }}
        </p>

        <!-- GREETING – using "Dear" variant as most common -->
        <p class="greeting-dear">
            Dear <strong>Mr Example Recipient</strong>,
        </p>

        <!-- BODY – example content that looks like a real letter -->
        <div style="text-align: justify; line-height:1.22; margin-bottom:30px;">
            <p>I am writing to confirm the details of our recent discussion regarding the provision of care services.</p>

            <p>We are pleased to confirm that ZTL Care will provide support to your family member as agreed. The care package includes daily visits from 08:00 to 20:00, personal care, medication management, and companionship. Our team will commence services on <strong>10-02-2026</strong>.</p>

            <p>All staff assigned to this case hold current PVG membership, relevant qualifications, and have completed mandatory training in safeguarding, moving & handling, and medication administration.</p>

            <p>Please do not hesitate to contact the office should you have any questions or require adjustments to the care plan. We look forward to supporting you and your family.</p>

            <p>Thank you for choosing ZTL Care.</p>
        </div>

        <!-- SIGN OFF -->
        <div style="margin-top:50px;">
            <p style="margin:0;">Yours sincerely,</p>
            <br><br>
            <p style="margin:9px 0 0 0;">Director ZTL Care</p>
        </div>

    </div>
</body>
</html>