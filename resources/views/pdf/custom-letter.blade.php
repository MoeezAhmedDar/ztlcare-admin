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

        /* ✅ Greeting styles */
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

    @if($wavesBase64)
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
                <img src="{{ $logoBase64 }}" style="height:40px; max-width:150px;" alt="ZTL CARE">
            </div>
        </div>

        <br><br><br>

        <!-- DATE -->
        @if($letter->show_date)
            <p style="margin:20px 0 12px 0;">
                <strong>Date:</strong> {{ $letter->date->format('d-m-Y') }}
            </p>
        @endif

        <!-- ✅ GREETING -->
        @if($letter->greeting_type === 'dear')
            <p class="greeting-dear">
                Dear <strong>{{ $letter->dear_name }}</strong>,
            </p>
        @else
        <br>
        <br>
            <p class="greeting-to-whom">
                To whom it may concern,
            </p>
        @endif

        <!-- BODY -->
        <div style="text-align: justify; line-height:1.22; margin-bottom:30px;">
            {!! $letter->body_content !!}
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
