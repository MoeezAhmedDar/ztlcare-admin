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


 <div class="form-header">

        <!-- Centered title & subtitle -->
        <div class="text-center">
            <h1>Job Application Form</h1>
            <p>ZAN Traders Ltd - ZTL Care</p>
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