<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Questionnaire - {{ $interview->candidate_name }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 0;
        }
        .interview-container {
            max-width: 900px;
            margin: 0 auto;
        }
        .interview-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .interview-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .interview-header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .interview-body {
            padding: 40px;
        }
        .candidate-info {
            background: #f8f9fc;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        .section-header {
            background: #f8f9fc;
            border-left: 4px solid #764ba2;
            padding: 15px 20px;
            margin: 30px 0 20px 0;
            font-weight: 600;
            font-size: 18px;
            color: #333;
        }
        .question-block {
            margin-bottom: 25px;
            padding: 20px;
            border: 1px solid #e3e6f0;
            border-radius: 8px;
            background: #fafbfc;
        }
        .question-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            display: block;
        }
        .help-text {
            color: #6c757d;
            font-size: 14px;
            margin-top: 5px;
            font-style: italic;
        }
        .score-input {
            width: 80px;
            text-align: center;
        }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 15px 50px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 50px;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="interview-container">
        <div class="interview-card">
            <div class="interview-header">
                <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                <h1>Care Assistant Interview Questionnaire</h1>
                <p class="mb-0">ZTL Care - ZAN Traders Ltd</p>
            </div>

            <div class="interview-body">
                <div class="candidate-info">
                    <h2 class="h5 mb-3"><i class="fas fa-user-circle mr-2"></i> Interview Information</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Candidate:</strong> {{ $interview->candidate_name }}</p>
                            <p class="mb-2"><strong>Interviewer:</strong> {{ $interview->recruiter_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Date:</strong> {{ optional($interview->interview_date)->format('d M Y') ?? 'N/A' }}</p>
                            <p class="mb-2"><strong>Location:</strong> {{ $interview->location ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i> Please answer all questions honestly and thoroughly. Your responses will help us understand your suitability for the role.
                </div>

                <form action="{{ route('interview.public.submit', $interview->public_token) }}" method="POST">
                    @csrf

                    @foreach($sections as $section)
                        <div class="section-header">
                            <i class="fas fa-folder-open mr-2"></i> {{ $section->name }}
                        </div>

                        @foreach($section->questions as $question)
                            <div class="question-block">
                                <label class="question-label">
                                    {{ $question->prompt }}
                                </label>

                                @if($question->help_text)
                                    <div class="help-text">
                                        <i class="fas fa-lightbulb"></i> {{ $question->help_text }}
                                    </div>
                                @endif

                                <div class="mt-3">
                                    @if($question->input_type === 'text')
                                        <input type="text" name="answers[{{ $question->id }}]" class="form-control" value="{{ $responses->get($question->id)?->answer ?? old('answers.'.$question->id) }}">
                                    
                                    @elseif($question->input_type === 'textarea')
                                        <textarea name="answers[{{ $question->id }}]" class="form-control" rows="4">{{ $responses->get($question->id)?->answer ?? old('answers.'.$question->id) }}</textarea>
                                    
                                    @elseif($question->input_type === 'select')
                                        <select name="answers[{{ $question->id }}]" class="form-control">
                                            <option value="">Select an option...</option>
                                            @foreach($question->options ?? [] as $option)
                                                <option value="{{ $option }}" {{ ($responses->get($question->id)?->answer ?? old('answers.'.$question->id)) === $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                    
                                    @elseif($question->input_type === 'radio')
                                        @foreach($question->options ?? [] as $option)
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="q{{ $question->id }}_{{ $loop->index }}" name="answers[{{ $question->id }}]" class="custom-control-input" value="{{ $option }}" {{ ($responses->get($question->id)?->answer ?? old('answers.'.$question->id)) === $option ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="q{{ $question->id }}_{{ $loop->index }}">
                                                    {{ $option }}
                                                </label>
                                            </div>
                                        @endforeach
                                    
                                    @elseif($question->input_type === 'checkbox')
                                        @php
                                            $selectedValues = is_string($responses->get($question->id)?->answer) 
                                                ? explode(',', $responses->get($question->id)?->answer) 
                                                : (old('answers.'.$question->id) ?? []);
                                        @endphp
                                        @foreach($question->options ?? [] as $option)
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" id="q{{ $question->id }}_{{ $loop->index }}" name="answers[{{ $question->id }}][]" class="custom-control-input" value="{{ $option }}" {{ in_array($option, $selectedValues) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="q{{ $question->id }}_{{ $loop->index }}">
                                                    {{ $option }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endforeach

                    <div class="text-center mt-5 pt-4 border-top">
                        <button type="submit" class="btn btn-primary btn-submit">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Questionnaire
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center mt-4">
            <p class="text-white small">
                <i class="fas fa-lock mr-1"></i> Your responses are secure and confidential
            </p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>