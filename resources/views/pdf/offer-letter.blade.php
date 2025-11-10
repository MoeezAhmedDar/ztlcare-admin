{{-- resources/views/pdf/offer-letter.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 28px 38px 35px 38px; size: A4; }
        body { font-family:"Calibri",Arial,sans-serif; font-size:10.4pt; line-height:1.22; color:#000; }
        .flex { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:5px; }
        .left  { font-size:8.8pt; line-height:1.1; }
        .right { text-align:right; }
        .logo  { height:40px; }
        .big   { font-size:15.5pt; font-weight:bold; margin-top:-3px; }
        .c     { text-align:center; }
        .b     { font-weight:bold; }
        .addr  { line-height:1.05; margin:6px 0 4px; }
        .line  { border-bottom:1px solid #000; width:208px; display:inline-block; }
        .s     { width:105px; }
        .letter { text-align:justify; margin:8px 0; }
        .letter p { margin:0 0 4px; }
        .closing { margin-top:16px; }
        .footer { position:fixed; bottom:26px; left:0; right:0; text-align:center; font-size:8.7pt; }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="flex">
    <div class="left">
        358 Brandon Street Motherwell North<br>
        Lanarkshire ML1 1XA<br>
        T: 01698 701199<br>
        E: info@ztl.care  W:
    </div>
    <div class="right">
        <img src="{{ $logoBase64 }}" style="height:40px; max-width:150px;" alt="ZTL CARE">    
    </div>
</div>
<div class="c b">Offer Letter - SPR26</div>

<div class="b addr" style="text-align:left; margin-left:0;">
    ZAN TRADERS LTD<br>358<br>Brandon<br>Street<br>Motherwell<br>ML1 1XA
</div>

<p>Date: <span>{{ $date }}</span></p>
<p>Dear <span>{{ $dear }},</p>

<div class="letter">
    <p>I am very pleased to inform you that you were successful in your interview. We would like to provisionally offer you:</p>
    <p>The post of <span class="s">{{ $position }}</span>. At the rate of £<span class="s">{{ $rate_per_hour }}</span> per hour.</p>
    <p>Annual holidays will be accrued each year as part of your working time 1st April to 31st March each year.</p>
    <p>This offer is conditional on the receipt of satisfactory references, including from your last/present employer as well as a satisfactory response from the PVG Check register, and where it applies, satisfactory checks of active professional registration.</p>
    <p>Please find enclosed an equal opportunities and health Questionnaire that we would appreciate you completing and returning in the sealed brown envelope. Please be assured this information will be held confidentially and only reviewed by the Registered Manager.</p>
    <p>Finally, we ask you please contact us to indicate whether you would like to accept our offer and we can agree a potential start date.</p>
</div>

<div class="closing">
    <p>Yours sincerely,</p>
    <p style="margin-top:9px;">For and behalf of ZTL Care.</p>
</div>

<!-- BOXED FOOTER -->
<div class="footer">
    <div>
        ZTL CARE - Company Registration Number: <strong>SC675141</strong>
    </div>
</div>

</body>
</html>