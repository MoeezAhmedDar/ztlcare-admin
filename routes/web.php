<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\RejectionController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ReferenceRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomLetterController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PublicInterviewController;

// ROOT ROUTE - SMART REDIRECT
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->hasRole('admin')) {
            return Redirect::route('dashboard');
        }
        if (Auth::user()->hasRole('applicant')) {
            return redirect()->intended('/apply');
        }
    }
    return Redirect::route('login');
})->name('home');

// Public Interview Questionnaire (No Auth Required)
Route::prefix('interview')->name('interview.public.')->group(function () {
    Route::get('/{token}', [PublicInterviewController::class, 'show'])->name('show');
    Route::post('/{token}/submit', [PublicInterviewController::class, 'submit'])->name('submit');
    Route::get('/{token}/completed', [PublicInterviewController::class, 'completed'])->name('completed');
});

// Job Application Routes (Public - No Auth Required)
Route::prefix('apply')->name('job-application.')->group(function () {
    Route::get('/', [JobApplicationController::class, 'showStep'])->defaults('step', 1)->name('start');
    Route::get('/step/{step}', [JobApplicationController::class, 'showStep'])->name('step');
    Route::post('/step/{step}', [JobApplicationController::class, 'storeStep'])->name('store-step');
    Route::get('/review', [JobApplicationController::class, 'review'])->name('review');
    Route::post('/submit', [JobApplicationController::class, 'submit'])->name('submit');
    Route::get('/success', [JobApplicationController::class, 'success'])->name('success');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');

    Route::post('/login', function (Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->hasRole('admin')) {
                return redirect()->intended('/dashboard');
            }
            if ($user->hasRole('applicant')) {
                return redirect()->intended('/apply');
            }
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->onlyInput('email');
    });

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');

// Protected Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $interviewStats = [
            'total'    => \App\Models\Interview::count(),
            'pending'  => \App\Models\Interview::where('outcome', 'pending')->count(),
            'offers'   => \App\Models\Interview::where('outcome', 'offer')->count(),
            'rejected' => \App\Models\Interview::where('outcome', 'reject')->count(),
        ];
        $recentInterviews = \App\Models\Interview::latest()->limit(5)->get();

        return view('dashboard', compact('interviewStats', 'recentInterviews'));
    })->name('dashboard');

    // Users Management - granular permission
    Route::middleware('permission:manage users')->resource('users', UserController::class);

    // Interviews
    Route::resource('interviews', InterviewController::class);
    Route::get('interviews/{interview}/export-pdf', [InterviewController::class, 'exportPdf'])->name('interviews.export-pdf');

    // Job Applications Management
    Route::prefix('admin/job-applications')->name('admin.job-applications.')->group(function () {
        Route::get('/', [JobApplicationController::class, 'index'])->name('index')->middleware('permission:view job applications');
        Route::get('/{jobApplication}', [JobApplicationController::class, 'show'])->name('show')->middleware('permission:view job applications');
        Route::get('/{jobApplication}/export-pdf', [JobApplicationController::class, 'exportPdf'])->name('export-pdf')->middleware('permission:view job applications');
        Route::patch('/{jobApplication}/status', [JobApplicationController::class, 'updateStatus'])->name('update-status')->middleware('permission:view job applications'); // or more specific perm
        Route::delete('/{jobApplication}', [JobApplicationController::class, 'destroy'])->name('destroy')->middleware('permission:view job applications');
    });

    // Questionnaire Management
    Route::prefix('questionnaire')->name('questionnaire.')->middleware('permission:manage questionnaire')->group(function () {
        // Sections
        Route::get('/sections', [QuestionnaireController::class, 'sections'])->name('sections');
        Route::get('/sections/create', [QuestionnaireController::class, 'createSection'])->name('sections.create');
        Route::post('/sections', [QuestionnaireController::class, 'storeSection'])->name('sections.store');
        Route::get('/sections/{section}/edit', [QuestionnaireController::class, 'editSection'])->name('sections.edit');
        Route::put('/sections/{section}', [QuestionnaireController::class, 'updateSection'])->name('sections.update');
        Route::delete('/sections/{section}', [QuestionnaireController::class, 'destroySection'])->name('sections.destroy');
        Route::post('/sections/reorder', [QuestionnaireController::class, 'reorderSections'])->name('sections.reorder');

        // Questions
        Route::get('/sections/{section}/questions', [QuestionnaireController::class, 'questions'])->name('questions');
        Route::get('/sections/{section}/questions/create', [QuestionnaireController::class, 'createQuestion'])->name('questions.create');
        Route::post('/sections/{section}/questions', [QuestionnaireController::class, 'storeQuestion'])->name('questions.store');
        Route::get('/sections/{section}/questions/{question}/edit', [QuestionnaireController::class, 'editQuestion'])->name('questions.edit');
        Route::put('/sections/{section}/questions/{question}', [QuestionnaireController::class, 'updateQuestion'])->name('questions.update');
        Route::delete('/sections/{section}/questions/{question}', [QuestionnaireController::class, 'destroyQuestion'])->name('questions.destroy');
        Route::post('/sections/{section}/questions/reorder', [QuestionnaireController::class, 'reorderQuestions'])->name('questions.reorder');
    });

    Route::get('/invite-portal', [InviteController::class, 'index'])->name('invite.portal');
    Route::post('/invite-store', [InviteController::class, 'store'])->name('invite.store');
    Route::get('/invite-download/{id}', [InviteController::class, 'download'])->name('invite.download');

    Route::get('/offer-portal', [OfferController::class, 'index'])->name('offer.portal');
    Route::post('/offer-store', [OfferController::class, 'store'])->name('offer.store');
    Route::get('/offer-download/{id}', [OfferController::class, 'download'])->name('offer.download');

    Route::get('/rejection-portal', [RejectionController::class, 'index'])->name('rejection.portal')->middleware('permission:view rejection letters');
    Route::post('/rejection-store', [RejectionController::class, 'store'])->name('rejection.store');
    Route::get('/rejection-download/{id}', [RejectionController::class, 'download'])->name('rejection.download');
    Route::get('/ref-download', [RejectionController::class, 'downloadref'])->name('ref.download');

    Route::get('/character-portal', [CharacterController::class, 'index'])->name('character.portal');
    Route::post('/character-store', [CharacterController::class, 'store'])->name('character.store');
    Route::get('/character-download/{id}', [CharacterController::class, 'download'])->name('character.download');

    Route::get('/hr/reference', [ReferenceRequestController::class, 'index'])->name('reference.index');
    Route::post('/hr/reference', [ReferenceRequestController::class, 'store'])->name('reference.store');
    Route::get('/hr/reference/{id}/download', [ReferenceRequestController::class, 'download'])->name('reference.download');

    // Custom Letters
    Route::get('/custom-letters', [CustomLetterController::class, 'index'])->name('custom_letters.index');
    Route::post('/custom-letters', [CustomLetterController::class, 'store'])->name('custom_letters.store');
    Route::get('/custom-letters/{id}/download', [CustomLetterController::class, 'download'])->name('custom_letters.download');

    // Documents
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');

    Route::get('/download-document/{file}', function ($file) {
        $filePath = storage_path('app/public/documents/' . $file);
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }
        return response()->download($filePath, $file);
    })->name('download.document');
});