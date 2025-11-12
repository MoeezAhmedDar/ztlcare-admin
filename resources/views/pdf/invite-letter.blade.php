<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 28px 38px 35px 38px; size: A4; }
        body { font-family:"DejaVu Sans",Arial,sans-serif; font-size:10.4pt; line-height:1.22; color:#000; }
        .c     { text-align:center; }
        .b     { font-weight:bold; }
        .up    { text-transform:uppercase; }
        .addr  { line-height:1.05; margin:6px 0 4px; }
        .phone { font-size:11.8pt; margin:4px 0 6px; }
        .line  { border-bottom:1px solid #000; width:208px; display:inline-block; }
        .s     { width:105px; }
        .letter { text-align:justify; margin:8px 0; }
        .letter p { margin:0 0 4px; }
        ul { margin:2px 0 2px 19px; padding:0; line-height:1.22; }
        .closing { margin-top:14px; }
        .footer { 
            position:fixed; bottom:26px; left:0; right:0; 
            text-align:center; font-size:8.7pt; 
        }
        /* NEW: Text box around registration number */
        .reg-box {
            display: inline-block;
            border: 1px solid #000;
            padding: 4px 12px;
            background: #fff; /* Optional: white fill */
        }
        .reg-bold { font-weight: bold; }
    </style>
</head>
<body>

<div style="position: relative; height: 50px; margin-bottom: 8px;">
    <!-- LEFT TEXT -->
    <div style="
        position: absolute;
        left: 0;
        top: 0;
        font-size: 8.8pt;
        line-height: 1.1;
    ">
        358 Brandon Street Motherwell North<br>
        Lanarkshire ML1 1XA<br>
        T: 01698 701199<br>
        E: info@ztl.care  W:
    </div>

    <!-- RIGHT LOGO + TEXT -->
    <div style="
        position: absolute;
        right: 0;
        top: 0;
        text-align: right;
    ">

            <img src="{{ $logoBase64 }}" 
                 style="height: 40px; width: auto; display: block; margin: 0; padding: 0; vertical-align: top;" 
                 alt="ZTL CARE">
       
    </div>
</div>

<div style="
    text-align: center;
    font-weight: bold;
    font-size: 11pt;
    margin-top: 25px;
    margin-bottom: 8px;
">
    Interview Invite Letter Template - SPR26
</div>
<div class="c b up" style="font-size:12.8pt;margin:5px 0 7px;">INTERVIEW INVITATION</div>

<!-- LEFT-ALIGNED BLOCK -->
<div class="addr" style="text-align:left;">
    358 Brandon<br>Street<br>Motherwell<br>ML1 1XA
</div>
<div class="phone" style="text-align:left; margin-top:3px;">01698701199</div>

<p>Date: {{ $date ?? '_____________________' }}</p>
<p>To: {{ $to_name ?? '_____________________' }}</p>
<p>Dear {{ $dear ?? '___________________' }},</p>

<div class="letter">
    <p>Thank you for applying for the post of <span class="s">{{ $position ?? '_________' }}</span> at ZTL CARE.</p>
    <p>We would like to invite you for an interview at the above address at <span class="s">{{ $time ?? '_______' }}</span> on <span class="s">{{ $interview_date ?? '___________' }}</span>.</p>
    <p>If you are unable to attend, please telephone us on the number provided above.</p>
    <p>You should bring the following items with you when you attend, or we will not be able to progress your application:</p>
    <ul>
        <li>Evidence of your National Insurance Number</li>
        <li>Right to work documentation</li>
        <li>Either a passport, driving licence or other form of photographic identification</li>
    </ul>
    <p class="b" style="margin:5px 0 1px;">In addition to the above:</p>
    <ul>
        <li>Proof of address, such as an original recent utility bill, a credit card bill, bank statement, or council tax bill. This must include your name and be no older than 3 months</li>
        <li>Two recent ‘head and shoulders’ photographs of yourself</li>
        <li>Originals of any training or education certificates which are relevant to your application</li>
        <li>Any relevant certificates or registration evidence that support your application for this role such as SSSC etc</li>
    </ul>
    <p>If you are unable to provide any of the above required documents, please contact the office for advice.</p>
    <p>We look forward to meeting you soon.</p>
</div>

<div class="closing">
    <p>Yours sincerely,</p>
    <p style="margin-top:9px;">For and on behalf of ZTL Care</p>
</div>

<!-- UPDATED FOOTER: Text box + bold number -->
<div class="footer">
    <div>
        ZTL CARE - Company Registration Number: <strong>SC675141</strong>
    </div>
</div>

</body>
</html>