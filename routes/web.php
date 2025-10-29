<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InterviewController;

// ROOT ROUTE - SMART REDIRECT
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
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
})->middleware(['auth', 'verified'])->name('dashboard');

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
        
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    });
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/'); // Back to login
})->middleware('auth')->name('logout');

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


    Route::get('/documents', [App\Http\Controllers\DocumentController::class, 'index'])->name('documents.index');

});