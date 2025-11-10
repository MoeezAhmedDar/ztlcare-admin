<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 28px 38px 35px 38px; size: A4; }
        body { font-family:"Calibri",Arial,sans-serif; font-size:10.4pt; line-height:1.22; color:#000; }
        .line  { border-bottom:1px solid #000; width:208px; display:inline-block; }
        .s     { width:105px; }
        .letter { text-align:justify; margin:8px 0; }
        .letter p { margin:0 0 4px; }
        .closing { margin-top:16px; }
        .footer { position:fixed; bottom:26px; left:0; right:0; text-align:center; font-size:8.7pt; }
    </style>
</head>
<body>

<!-- PERFECTLY ALIGNED HEADER (PDF-SAFE) -->
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

<!-- TITLE WITH TOP MARGIN -->
<div style="text-align: center; font-weight: bold; font-size: 11pt; margin-top: 18px; margin-bottom: 8px;">
    Template Rejection Letters - SPR26
</div>

<div style="text-align: center; font-weight: bold; font-size: 12.8pt; margin: 6px 0 10px;">
    Rejection Letter
</div>

<!-- ADDRESS BLOCK -->
<div style="font-weight: bold; text-align: left; line-height: 1.05; margin-bottom: 8px;">
    358 Brandon<br>Street<br>Motherwell<br>ML1 1XA
</div>

<p>Date: <span class="line">{{ $date }}</span></p>
<p>Dear <span class="line">{{ $dear }},</p>

<div class="letter">
    <p>Thank you for your application for the post of <span class="s">{{ $position }}</span>.</p>
    <p>I’m sorry to inform you that, unfortunately, you were not successful on this occasion. Thank you for your interest and I wish you good luck for your future.</p>
</div>

<div class="closing">
    <p>Yours sincerely,</p>
    <p style="margin-top:9px;">For and behalf of ZTL Care</p>
</div>

<!-- BOXED FOOTER -->
<div class="footer">
    <div style="display:inline-block; border:1.2px solid #000; padding:7px 20px; background:#fff; font-size:8.7pt;">
        ZTL CARE - Company Registration Number: <strong>SC675141</strong>
    </div>
</div>

</body>
</html>