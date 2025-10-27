<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Interview - {{ $interview->candidate_name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        .header h1 {
            color: #667eea;
            margin: 0 0 5px 0;
            font-size: 20px;
        }
        .header p {
            margin: 0;
            color: #666;
            font-size: 10px;
        }
        .section {
            margin-bottom: 15px;
        }
        .section-title {
            background: #f8f9fc;
            padding: 8px 10px;
            font-weight: bold;
            color: #667eea;
            border-left: 4px solid #667eea;
            margin-bottom: 10px;
            font-size: 13px;
        }
        .info-row {
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            width: 30%;
            display: inline-block;
        }
        .info-value {
            width: 68%;
            display: inline-block;
        }
        .question {
            margin-bottom: 12px;
            padding: 8px;
            border: 1px solid #e3e6f0;
            border-radius: 4px;
        }
        .question-text {
            font-weight: bold;
            margin-bottom: 4px;
            color: #555;
        }
        .answer {
            padding: 6px;
            background: #f8f9fc;
            border-left: 3px solid #667eea;
            margin-top: 4px;
        }
        .score-badge {
            background: #1cc88a;
            color: white;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-badge {
            padding: 3px 10px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            display: inline-block;
        }
        .status-draft { background: #f6c23e; color: white; }
        .status-in-review { background: #36b9cc; color: white; }
        .status-completed { background: #1cc88a; color: white; }
        .outcome-pending { background: #858796; color: white; }
        .outcome-offer { background: #1cc88a; color: white; }
        .outcome-reject { background: #e74a3b; color: white; }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 9px;
            color: #999;
            padding: 10px 0;
            border-top: 1px solid #e3e6f0;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Interview Questionnaire - Care Assistant</h1>
        <p>ZTL Care - ZAN Traders Ltd</p>
    </div>

    <div class="section">
        <div class="section-title">Interview Details</div>
        <div class="info-row">
            <span class="info-label">Candidate Name:</span>
            <span class="info-value">{{ $interview->candidate_name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Recruiter:</span>
            <span class="info-value">{{ $interview->recruiter_name ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Interview Date:</span>
            <span class="info-value">{{ optional($interview->interview_date)->format('d M Y') ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Location:</span>
            <span class="info-value">{{ $interview->location ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status:</span>
            <span class="info-value">
                <span class="status-badge status-{{ str_replace('_', '-', $interview->status) }}">{{ strtoupper(str_replace('_', ' ', $interview->status)) }}</span>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Outcome:</span>
            <span class="info-value">
                <span class="status-badge outcome-{{ $interview->outcome }}">{{ strtoupper($interview->outcome) }}</span>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Score:</span>
            <span class="info-value"><strong>{{ $interview->total_score ?? 0 }}</strong></span>
        </div>
    </div>

    @foreach($sections as $section)
        <div class="section">
            <div class="section-title">{{ $section->name }}</div>
            
            @foreach($section->questions as $question)
                @php
                    $response = $responses->get($question->id);
                @endphp
                
                <div class="question">
                    <div class="question-text">
                        {{ $question->prompt }}
                        @if($question->has_score)
                            <span class="score-badge">Score: {{ $response?->score ?? 0 }}/3</span>
                        @endif
                    </div>
                    
                    @if($question->help_text)
                        <div style="font-size: 9px; color: #666; margin-bottom: 4px;">{{ $question->help_text }}</div>
                    @endif
                    
                    @if($response && $response->answer)
                        <div class="answer">{{ $response->answer }}</div>
                    @else
                        <div class="answer" style="color: #999; font-style: italic;">No answer provided</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach

    @if($interview->overall_feedback)
        <div class="section">
            <div class="section-title">Overall Feedback</div>
            <div class="answer">{{ $interview->overall_feedback }}</div>
        </div>
    @endif

    @if($interview->position_offered)
        <div class="section">
            <div class="section-title">Position Offered</div>
            <div class="info-row">
                <span class="info-label">Position:</span>
                <span class="info-value">{{ $interview->position_offered }}</span>
            </div>
            @if($interview->recruitment_authorization)
                <div class="info-row">
                    <span class="info-label">Authorization:</span>
                    <span class="info-value">{{ $interview->recruitment_authorization }}</span>
                </div>
            @endif
            @if($interview->interviewer_signature_name)
                <div class="info-row">
                    <span class="info-label">Interviewer:</span>
                    <span class="info-value">{{ $interview->interviewer_signature_name }}</span>
                </div>
            @endif
            @if($interview->interviewer_signed_at)
                <div class="info-row">
                    <span class="info-label">Signed At:</span>
                    <span class="info-value">{{ $interview->interviewer_signed_at->format('d M Y H:i') }}</span>
                </div>
            @endif
        </div>
    @endif

    @if($interview->notes)
        <div class="section">
            <div class="section-title">Notes</div>
            <div class="answer">{{ $interview->notes }}</div>
        </div>
    @endif

    <div class="footer">
        Generated on {{ now()->format('d M Y H:i') }} | ZTL Care - Interview ID: {{ $interview->id }}
    </div>
</body>
</html>
