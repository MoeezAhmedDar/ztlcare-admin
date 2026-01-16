<div class="progress-container">
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: {{ ($currentStep / 6) * 100 }}%" aria-valuenow="{{ $currentStep }}" aria-valuemin="0" aria-valuemax="6"></div>
    </div>
    <div class="step-indicator">
        @foreach($steps as $stepNum => $stepName)
            <div class="step-item {{ $stepNum == $currentStep ? 'active' : '' }} {{ $stepNum < $currentStep ? 'completed' : '' }}">
                @if($stepNum < $currentStep)
                    <i class="fas fa-check-circle"></i>
                @elseif($stepNum == $currentStep)
                    <i class="fas fa-circle"></i>
                @else
                    <i class="far fa-circle"></i>
                @endif
                <div class="mt-1">{{ $stepNum }}. {{ $stepName }}</div>
            </div>
        @endforeach
    </div>
    
</div>
