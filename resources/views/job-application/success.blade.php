@extends('layouts.public')

@section('title', 'Application Submitted Successfully')
<style>
    /* Job Application Form - Header Styling */
.form-header {
    position: relative;           /* Important: creates positioning context for absolute children */
    padding: 1.5rem 1rem 2rem;    /* Top/bottom padding – adjust as needed */
    margin-bottom: 1rem;          /* Space before progress bar */
}

.form-header .text-center {
    margin: 0;                    /* Reset any unwanted margins */
}

/* Logout button container */
.form-header .logout-wrapper {
    position: absolute;
    top: 1rem;                    /* Distance from top edge */
    right: 1rem;                  /* Distance from right edge */
    z-index: 10;                  /* Make sure it's above other elements if needed */
}

/* Green logout button styling */
.btn-logout-green {
    background-color: #28a745;    /* Bootstrap success green */
    border-color: #28a745;
    color: white;
    font-weight: 500;
    padding: 0.5rem 1rem;
    font-size: 0.95rem;
    border-radius: 0.375rem;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* subtle shadow for depth */
}

.btn-logout-green:hover,
.btn-logout-green:focus {
    background-color: #218838;
    border-color: #1e7e34;
    color: white;
    transform: translateY(-1px);  /* slight lift on hover */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.btn-logout-green:active {
    transform: translateY(0);
}

/* Responsive adjustments – smaller margin on mobile */
@media (max-width: 576px) {
    .form-header .logout-wrapper {
        top: 0.75rem;
        right: 0.75rem;
    }
    
    .btn-logout-green {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
    }
}
</style>
@section('content')
<div class="form-container">
    <div class="form-header" style="background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);">
        <!-- Centered title & subtitle -->
        <div class="text-center">
           <i class="fas fa-check-circle fa-3x mb-3"></i>
        <h1>Application Submitted Successfully!</h1>
        <p>Thank you for applying to ZTL Care</p>
        </div>

        <!-- Logout button – top right -->
        <div class="logout-wrapper">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout-green">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </button>
            </form>
        </div>

    </div>

    <div class="form-body text-center">
        <div class="mb-4">
            <i class="fas fa-envelope fa-4x text-primary mb-3"></i>
            <h2 class="h4 mb-3">What happens next?</h2>
            <p class="text-muted">Our recruitment team will review your application and contact you shortly.</p>
        </div>

        <div class="row mt-5">
            <div class="col-md-4">
                <div class="mb-4">
                    <i class="fas fa-clock fa-2x text-primary mb-2"></i>
                    <h3 class="h6">Review Process</h3>
                    <p class="small text-muted">We typically review applications within 2-3 business days</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <i class="fas fa-phone fa-2x text-primary mb-2"></i>
                    <h3 class="h6">Interview</h3>
                    <p class="small text-muted">If shortlisted, we'll contact you to schedule an interview</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <i class="fas fa-user-check fa-2x text-primary mb-2"></i>
                    <h3 class="h6">Onboarding</h3>
                    <p class="small text-muted">Successful candidates will receive our onboarding pack</p>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-4">
            <p class="mb-0"><strong>Important:</strong> Please check your email regularly, including spam/junk folders, for updates about your application.</p>
        </div>

        <div class="mt-5 pt-4 border-top">
            <h3 class="h5 mb-3">Need to get in touch?</h3>
            <p class="mb-2"><i class="fas fa-phone mr-2 text-primary"></i> <strong>Phone:</strong> 01698 701199</p>
            <p class="mb-2"><i class="fas fa-envelope mr-2 text-primary"></i> <strong>Email:</strong> info@ztl.care</p>
            <p class="mb-2"><i class="fas fa-globe mr-2 text-primary"></i> <strong>Website:</strong> www.ztl.care</p>
            <p class="mb-2"><i class="fas fa-map-marker-alt mr-2 text-primary"></i> <strong>Address:</strong> 358 Brandon Street, Motherwell, North Lanarkshire ML1 1XA</p>
        </div>

        <div class="mt-5">
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-home mr-2"></i> Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
