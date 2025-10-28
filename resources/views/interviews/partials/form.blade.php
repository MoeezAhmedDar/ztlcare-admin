<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="recruiter_name">Recruiter Name</label>
                <input type="text" name="recruiter_name" id="recruiter_name" class="form-control" value="{{ old('recruiter_name', $interview->recruiter_name) }}">
                @error('recruiter_name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label for="interview_date">Date of Interview</label>
                <input type="date" name="interview_date" id="interview_date" class="form-control" value="{{ old('interview_date', optional($interview->interview_date)->format('Y-m-d')) }}">
                @error('interview_date')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label for="location">Location/Branch</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $interview->location) }}">
                @error('location')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="candidate_name">Candidate Name</label>
                <input type="text" name="candidate_name" id="candidate_name" class="form-control" value="{{ old('candidate_name', $interview->candidate_name) }}" required>
                @error('candidate_name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" {{ old('status', $interview->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label for="outcome">Outcome</label>
                <select name="outcome" id="outcome" class="form-control" required>
                    @foreach($outcomeOptions as $value => $label)
                        <option value="{{ $value }}" {{ old('outcome', $interview->outcome) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('outcome')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="position_offered">Position</label>
                <input type="text" name="position_offered" id="position_offered" class="form-control" value="{{ old('position_offered', $interview->position_offered) }}">
                @error('position_offered')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="recruitment_authorization">Recruitment Authorization</label>
                <input type="text" name="recruitment_authorization" id="recruitment_authorization" class="form-control" value="{{ old('recruitment_authorization', $interview->recruitment_authorization) }}">
                @error('recruitment_authorization')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="interviewer_signature_name">Interviewer Name</label>
                <input type="text" name="interviewer_signature_name" id="interviewer_signature_name" class="form-control" value="{{ old('interviewer_signature_name', $interview->interviewer_signature_name) }}">
                @error('interviewer_signature_name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="interviewer_signed_at">Signed At</label>
                <input type="datetime-local" name="interviewer_signed_at" id="interviewer_signed_at" class="form-control" value="{{ old('interviewer_signed_at', optional($interview->interviewer_signed_at)->format('Y-m-d\TH:i')) }}">
                @error('interviewer_signed_at')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="notes">Notes to interviewer</label>
            <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $interview->notes) }}</textarea>
            @error('notes')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="overall_feedback">Overall Assessment / Feedback</label>
            <textarea name="overall_feedback" id="overall_feedback" class="form-control" rows="4">{{ old('overall_feedback', $interview->overall_feedback) }}</textarea>
            @error('overall_feedback')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

@if($interview->exists && $interview->is_questionnaire_complete)
    {{-- Only show questionnaire section for editing interviews where candidate has submitted --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0">Interview Questionnaire Responses</h2>
            <span class="text-muted small">Score the candidate's answers (0-3 for scored questions)</span>
        </div>
        <div class="card-body">
            @foreach($sections as $section)
                <div class="mb-4">
                    <h3 class="h6 text-primary border-bottom pb-2">{{ $section->name }}</h3>
                    @foreach($section->questions as $question)
                        @php
                            $scoreField = 'scores.' . $question->id;
                            $response = $responses->get($question->id);
                            $scoreValue = old('scores.' . $question->id, optional($response)->score);
                        @endphp
                        <div class="form-group border-left pl-3 mb-3">
                            <label class="font-weight-bold mb-2">{{ $question->prompt }}</label>
                            
                            {{-- Display candidate's answer (read-only) --}}
                            <div class="p-3 bg-light rounded mb-2">
                                <strong class="text-muted small d-block mb-1">Candidate's Answer:</strong>
                                <p class="mb-0">{{ $response->answer ?? '—' }}</p>
                            </div>

                            {{-- Interviewer scoring (only for scored questions) --}}
                            @if($question->has_score)
                                <div class="mt-2">
                                    <label class="mr-2 mb-0 font-weight-bold">Interviewer Score (0-3):</label>
                                    <select name="scores[{{ $question->id }}]" class="custom-select w-auto d-inline-block">
                                        <option value="">Not Scored</option>
                                        @for($i = 0; $i <= 3; $i++)
                                            <option value="{{ $i }}" {{ (string) $scoreValue === (string) $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    @error($scoreField)
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Total Score</label>
                    <input type="text" class="form-control" value="{{ $interview->total_score ?? old('total_score', '') }}" disabled>
                </div>
                <div class="form-group col-md-8">
                    <label for="status_comment">Status comment / history note</label>
                    <textarea name="status_comment" id="status_comment" class="form-control" rows="2">{{ old('status_comment') }}</textarea>
                </div>
            </div>
        </div>
    </div>
@elseif($interview->exists && !$interview->is_questionnaire_complete)
    {{-- For existing interviews where questionnaire is not yet completed --}}
    <div class="alert alert-info">
        <i class="fas fa-info-circle mr-2"></i> 
        <strong>Questionnaire Pending:</strong> The candidate has not yet completed the questionnaire. Share the public link with them to fill it out.
    </div>
@endif

<div class="d-flex justify-content-between align-items-center">
    <a href="{{ route('interviews.index') }}" class="btn btn-light">Cancel</a>
    <button type="submit" class="btn btn-primary">Save Interview</button>
</div>
