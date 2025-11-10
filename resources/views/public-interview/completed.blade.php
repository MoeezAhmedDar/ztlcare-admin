<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionnaire Submitted</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .completion-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 600px;
            width: 100%;
            text-align: center;
            padding: 50px 40px;
        }
        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: scaleIn 0.5s ease;
        }
        @keyframes scaleIn {
            from { transform: scale(0); }
            to { transform: scale(1); }
        }
        .success-icon i {
            color: white;
            font-size: 50px;
        }
        h1 {
            color: #333;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .subtitle {
            color: #6c757d;
            font-size: 18px;
            margin-bottom: 30px;
        }
        .info-box {
            background: #f8f9fc;
            border-radius: 10px;
            padding: 25px;
            margin: 30px 0;
            text-align: left;
        }
        .info-box p {
            margin-bottom: 10px;
        }
        .contact-info {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #e3e6f0;
        }
    </style>
</head>
<body>
    <div class="completion-card">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>

        <h1>Questionnaire Submitted!</h1>
        <p class="subtitle">Thank you for completing the interview questionnaire</p>

        <div class="info-box">
            <h3 class="h5 mb-3"><i class="fas fa-user-circle text-primary mr-2"></i> Submission Details</h3>
            <p class="mb-2"><strong>Candidate:</strong> {{ $interview->candidate_name }}</p>
            <p class="mb-2"><strong>Submitted At:</strong> {{ $interview->questionnaire_submitted_at ? $interview->questionnaire_submitted_at->format('d M Y, H:i') : 'Just now' }}</p>
            @if($interview->total_score)
                <p class="mb-0"><strong>Total Score:</strong> {{ $interview->total_score }}</p>
            @endif
        </div>

        <div class="alert alert-success">
            <i class="fas fa-info-circle mr-2"></i> Your responses have been securely saved and our team will review them shortly.
        </div>

        <div class="contact-info">
            <h4 class="h6 text-muted mb-3">Need to get in touch?</h4>
            <p class="small mb-1"><i class="fas fa-phone text-primary mr-2"></i> <strong>Phone:</strong> 01698 701199</p>
            <p class="small mb-1"><i class="fas fa-envelope text-primary mr-2"></i> <strong>Email:</strong> info@ztl.care</p>
            <p class="small mb-0"><i class="fas fa-globe text-primary mr-2"></i> <strong>Website:</strong> www.ztl.care</p>
        </div>

        <div class="mt-4">
            <p class="text-muted small mb-0">
                <i class="fas fa-shield-alt mr-1"></i> ZTL Care - ZAN Traders Ltd
            </p>
        </div>
    </div>
</body>
</html>