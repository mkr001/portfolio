<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PortfolioController;

Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::post('/contact', [PortfolioController::class, 'sendMessage'])->name('contact.post');
Route::post('/request-callback', [PortfolioController::class, 'requestCallback'])->name('callback.post');


Route::get('/contact', function () {
    return redirect('/#contact');
})->name('contact.get');

Route::get('/request-callback', function () {
    return redirect('/#contact');
})->name('callback.get');

// Admin Routes
use App\Http\Controllers\AdminController;

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'doLogin'])->name('login.post');
    Route::match(['get', 'post'], '/logout', [AdminController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/contacts', [AdminController::class, 'contacts'])->name('contacts');
        Route::get('/career-requests', [AdminController::class, 'careerRequests'])->name('career_requests');
        Route::post('/career-requests/{application}/status', [AdminController::class, 'adminUpdateStatus'])->name('career_requests.status');
        Route::get('/career-requests/{application}/download', [AdminController::class, 'adminDownloadCv'])->name('career_requests.download');
        
        Route::get('/business-inquiries', [AdminController::class, 'businessInquiries'])->name('business_inquiries');
        Route::post('/business-inquiries/{inquiry}/status', [AdminController::class, 'adminUpdateBusinessStatus'])->name('business_inquiries.status');
        
        Route::get('/freelance-inquiries', [AdminController::class, 'freelanceInquiries'])->name('freelance_inquiries');
        Route::post('/freelance-inquiries/{inquiry}/status', [AdminController::class, 'adminUpdateFreelanceStatus'])->name('freelance_inquiries.status');
        
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
        
        Route::get('/chats', [AdminController::class, 'chats'])->name('chats');
        Route::get('/chats/{user}', [AdminController::class, 'userChat'])->name('user_chat');
        Route::post('/chats/{user}/send', [AdminController::class, 'adminSendMessage'])->name('chats.send');
        
        Route::get('/feedbacks', [AdminController::class, 'feedbacks'])->name('feedbacks');
        Route::post('/feedbacks/{feedback}/status', [AdminController::class, 'adminUpdateFeedbackStatus'])->name('feedbacks.status');
        Route::delete('/feedbacks/{feedback}', [AdminController::class, 'deleteFeedback'])->name('feedbacks.delete');
        
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        
        Route::get('/callbacks', [AdminController::class, 'callbacks'])->name('callbacks');
        Route::get('/projects', [AdminController::class, 'projects'])->name('projects');
        Route::post('/projects', [AdminController::class, 'storeProject'])->name('projects.store');
        Route::put('/projects/{project}', [AdminController::class, 'updateProject'])->name('projects.update');
        Route::delete('/projects/{project}', [AdminController::class, 'deleteProject'])->name('projects.delete');
        Route::post('/contacts/{contact}/read', [AdminController::class, 'markContactAsRead'])->name('contacts.read');
        Route::post('/callbacks/{callback}/read', [AdminController::class, 'markCallbackAsRead'])->name('callbacks.read');
    });
});

// Job Portal Routes
use App\Http\Controllers\JobPortalController;

Route::prefix('portal')->name('portal.')->group(function () {
    Route::get('/login', [JobPortalController::class, 'login'])->name('login');
    Route::post('/login', [JobPortalController::class, 'doLogin'])->name('login.post');
    Route::match(['get', 'post'], '/logout', [JobPortalController::class, 'logout'])->name('logout');

    Route::get('/register', [JobPortalController::class, 'register'])->name('register');
    Route::post('/register', [JobPortalController::class, 'doRegister'])->name('register.post');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [JobPortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/chat', [JobPortalController::class, 'chat'])->name('chat');
        Route::post('/chat/send', [JobPortalController::class, 'sendChatMessage'])->name('chat.send');
        
        Route::post('/feedback', [JobPortalController::class, 'submitFeedback'])->name('feedback.submit');
        
        Route::get('/support', function () {
            return view('portal.support');
        })->name('support');
        
        // Job Seeker Routes
        Route::post('/upload-cv', [JobPortalController::class, 'uploadCv'])->name('upload_cv');

        // Employer specific routes
        Route::get('/applicants', [JobPortalController::class, 'applicants'])->name('applicants');
        Route::get('/view-cv/{application}', [JobPortalController::class, 'viewCv'])->name('view_cv');
        Route::post('/update-status/{application}', [JobPortalController::class, 'updateStatus'])->name('update_status');
        
        // Business Partner Routes
        Route::post('/business-submit', [JobPortalController::class, 'submitBusinessInquiry'])->name('business.submit');
        
        // Freelance Client Routes
        Route::post('/freelance-submit', [JobPortalController::class, 'submitFreelanceInquiry'])->name('freelance.submit');
    });
});




