{{-- resources/views/pdf/offer-letter.blade.php --}}
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

        .date-reference {
            position: relative;
            margin: 8px 0;
            line-height: 1.4;
        }
        .date-reference .ref {
            position: absolute;
            right: 0;
            top: 0;
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

        <div style="text-align:center; font-weight:bold; text-transform:uppercase; font-size:12.8pt; margin:5px 0 7px;">
            Offer Letter
        </div>

        <div class="date-reference">
            <p>Date: <strong>
                {{ $date 
                    ? \Carbon\Carbon::parse($date)->translatedFormat('d-m-Y') 
                    : '_____________________' 
                }}
            </strong></p>
            <div class="ref">
                <strong>Reference: ZTL-OF-00{{ $letter->id ?? '____' }}</strong>
            </div>
        </div>

        <!-- Fetch full name directly from the user table -->
        <p>Dear <strong>{{ $letter->applicant->full_name ?? '___________________' }}</strong>,</p>

        <div style="text-align:justify; margin:5px 0 10px;">
            <p>I am very pleased to inform you that you were successful in your interview. We would like to provisionally offer you:</p>
            
            <p>
                The post of <strong>{{ $position ?? '_________________' }}</strong>. 
                At the rate of £<strong>{{ $rate_per_hour ?? '_____' }}</strong> per hour.
            </p>

            @if(!empty(trim($custom_offer_details ?? '')))
                {!! nl2br(e($custom_offer_details)) !!}
            @else
                <p>Annual holidays will be accrued each year as part of your working time 1st April to 31st March each year.</p>
                
                <p>This offer is conditional on the receipt of satisfactory references, including from your last/present employer as well as a satisfactory response from the PVG Check register, and where it applies, satisfactory checks of active professional registration.</p>
                
                <p>Please find enclosed an equal opportunities and health Questionnaire that we would appreciate you completing and returning in the sealed brown envelope. Please be assured this information will be held confidentially and only reviewed by the Registered Manager.</p>
                
                <p>Finally, we ask you please contact us to indicate whether you would like to accept our offer and we can agree a potential start date.</p>
            @endif
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