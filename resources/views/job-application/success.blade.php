@extends('layouts.public')

@section('title', 'Application Submitted Successfully')

@section('content')
<div class="form-container">
    <div class="form-header" style="background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);">
        <i class="fas fa-check-circle fa-3x mb-3"></i>
        <h1>Application Submitted Successfully!</h1>
        <p>Thank you for applying to ZTL Care</p>
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
