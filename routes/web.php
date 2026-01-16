<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\RejectionController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ReferenceRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomLetterController;
use App\Http\Controllers\Auth\RegisterController;

// ROOT ROUTE - SMART REDIRECT
Route::get('/', function () {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
        return Redirect::route('dashboard');
    }elseif(Auth::check() && Auth::user()->hasRole('applicant')){
        return redirect()->intended('/apply');
    }

    return Redirect::route('login');
})->name('home');

// Dashboard (Logged in only)
Route::get('/dashboard', function () {
    $interviewStats = [
        'total' => \App\Models\Interview::count(),
        'pending' => \App\Models\Interview::where('outcome', 'pending')->count(),
        'offers' => \App\Models\Interview::where('outcome', 'offer')->count(),
        'rejected' => \App\Models\Interview::where('outcome', 'reject')->count(),
    ];
    
    $recentInterviews = \App\Models\Interview::latest()->limit(5)->get();
    
    return view('dashboard', compact('interviewStats', 'recentInterviews'));
})->middleware(['auth', 'verified','role:admin'])->name('dashboard');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');
    $remember = $request->boolean('remember');

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect based on role
        if ($user->hasRole('admin')) {
            return redirect()->intended('/dashboard');
        }

        if ($user->hasRole('applicant')) {
            return redirect()->intended('/apply'); // or route('apply')
        }

        // Optional: fallback for other roles or if role is missing
        return redirect()->intended('/dashboard');
    }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    });

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/'); // Back to login
})->middleware('auth')->name('logout');

// Public Interview Questionnaire (No Auth Required)
Route::prefix('interview')->name('interview.public.')->group(function () {
    Route::get('/{token}', [\App\Http\Controllers\PublicInterviewController::class, 'show'])->name('show');
    Route::post('/{token}/submit', [\App\Http\Controllers\PublicInterviewController::class, 'submit'])->name('submit');
    Route::get('/{token}/completed', [\App\Http\Controllers\PublicInterviewController::class, 'completed'])->name('completed');
});

// Job Application Routes (Public - No Auth Required)
Route::prefix('apply')->name('job-application.')->group(function () {
    Route::get('/', [\App\Http\Controllers\JobApplicationController::class, 'showStep'])->defaults('step', 1)->name('start');
    Route::get('/step/{step}', [\App\Http\Controllers\JobApplicationController::class, 'showStep'])->name('step');
    Route::post('/step/{step}', [\App\Http\Controllers\JobApplicationController::class, 'storeStep'])->name('store-step');
    Route::get('/review', [\App\Http\Controllers\JobApplicationController::class, 'review'])->name('review');
    Route::post('/submit', [\App\Http\Controllers\JobApplicationController::class, 'submit'])->name('submit');
    Route::get('/success', [\App\Http\Controllers\JobApplicationController::class, 'success'])->name('success');
});

// Admin Routes (Auth Required)
Route::middleware('auth')->group(function () {
    Route::resource('interviews', InterviewController::class);
    Route::get('interviews/{interview}/export-pdf', [\App\Http\Controllers\InterviewController::class, 'exportPdf'])->name('interviews.export-pdf');
    
    // Job Applications Management
    Route::prefix('admin/job-applications')->name('admin.job-applications.')->group(function () {
        Route::get('/', [\App\Http\Controllers\JobApplicationController::class, 'index'])->name('index');
        Route::get('/{jobApplication}', [\App\Http\Controllers\JobApplicationController::class, 'show'])->name('show');
        Route::get('/{jobApplication}/export-pdf', [\App\Http\Controllers\JobApplicationController::class, 'exportPdf'])->name('export-pdf');
        Route::patch('/{jobApplication}/status', [\App\Http\Controllers\JobApplicationController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{jobApplication}', [\App\Http\Controllers\JobApplicationController::class, 'destroy'])->name('destroy');
    });

    // Questionnaire Management
    Route::prefix('questionnaire')->name('questionnaire.')->group(function () {
        // Sections
        Route::get('/sections', [\App\Http\Controllers\QuestionnaireController::class, 'sections'])->name('sections');
        Route::get('/sections/create', [\App\Http\Controllers\QuestionnaireController::class, 'createSection'])->name('sections.create');
        Route::post('/sections', [\App\Http\Controllers\QuestionnaireController::class, 'storeSection'])->name('sections.store');
        Route::get('/sections/{section}/edit', [\App\Http\Controllers\QuestionnaireController::class, 'editSection'])->name('sections.edit');
        Route::put('/sections/{section}', [\App\Http\Controllers\QuestionnaireController::class, 'updateSection'])->name('sections.update');
        Route::delete('/sections/{section}', [\App\Http\Controllers\QuestionnaireController::class, 'destroySection'])->name('sections.destroy');
        Route::post('/sections/reorder', [\App\Http\Controllers\QuestionnaireController::class, 'reorderSections'])->name('sections.reorder');
        
        // Questions
        Route::get('/sections/{section}/questions', [\App\Http\Controllers\QuestionnaireController::class, 'questions'])->name('questions');
        Route::get('/sections/{section}/questions/create', [\App\Http\Controllers\QuestionnaireController::class, 'createQuestion'])->name('questions.create');
        Route::post('/sections/{section}/questions', [\App\Http\Controllers\QuestionnaireController::class, 'storeQuestion'])->name('questions.store');
        Route::get('/sections/{section}/questions/{question}/edit', [\App\Http\Controllers\QuestionnaireController::class, 'editQuestion'])->name('questions.edit');
        Route::put('/sections/{section}/questions/{question}', [\App\Http\Controllers\QuestionnaireController::class, 'updateQuestion'])->name('questions.update');
        Route::delete('/sections/{section}/questions/{question}', [\App\Http\Controllers\QuestionnaireController::class, 'destroyQuestion'])->name('questions.destroy');
        Route::post('/sections/{section}/questions/reorder', [\App\Http\Controllers\QuestionnaireController::class, 'reorderQuestions'])->name('questions.reorder');
    });

    Route::get('/documents', [App\Http\Controllers\DocumentController::class, 'index'])->name('documents.index');

    // routes/web.php
    Route::get('/download-document/{file}', function ($file) {
        $filePath = storage_path('app/public/documents/' . $file);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath, $file);
    })->name('download.document');

   // Route::get('/invite-letter/pdf', [App\Http\Controllers\DocumentController::class, 'generate'])->name('invite-letter.pdf');

   // routes/web.php

    Route::get('/invite-portal', [InviteController::class, 'index'])->name('invite.portal');
    Route::post('/invite-store', [InviteController::class, 'store'])->name('invite.store');
    Route::get('/invite-download/{id}', [InviteController::class, 'download'])->name('invite.download');

    Route::get('/offer-portal', [OfferController::class, 'index'])->name('offer.portal');
    Route::post('/offer-store', [OfferController::class, 'store'])->name('offer.store');
    Route::get('/offer-download/{id}', [OfferController::class, 'download'])->name('offer.download');

    Route::get('/rejection-portal', [RejectionController::class, 'index'])->name('rejection.portal');
    Route::post('/rejection-store', [RejectionController::class, 'store'])->name('rejection.store');
    Route::get('/rejection-download/{id}', [RejectionController::class, 'download'])->name('rejection.download');
    Route::get('/ref-download', [RejectionController::class, 'downloadref'])->name('ref.download');

    Route::get('/character-portal', [CharacterController::class, 'index'])->name('character.portal');
    Route::post('/character-store', [CharacterController::class, 'store'])->name('character.store');
    Route::get('/character-download/{id}', [CharacterController::class, 'download'])->name('character.download');

    Route::get('/hr/reference', [ReferenceRequestController::class, 'index'])->name('reference.index');
    Route::post('/hr/reference', [ReferenceRequestController::class, 'store'])->name('reference.store');
    Route::get('/hr/reference/{id}/download', [ReferenceRequestController::class, 'download'])->name('reference.download');
    Route::resource('users', UserController::class);

    Route::get('/custom-letters', [CustomLetterController::class, 'index'])
        ->name('custom_letters.index');

    Route::post('/custom-letters', [CustomLetterController::class, 'store'])
        ->name('custom_letters.store');

    Route::get('/custom-letters/{id}/download', [CustomLetterController::class, 'download'])
        ->name('custom_letters.download');
    
});