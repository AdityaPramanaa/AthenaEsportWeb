<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\AdminMessageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');
Route::get('/galleries', [GalleryController::class, 'index'])->name('galleries.index');
Route::get('/galleries/{gallery}', [GalleryController::class, 'show'])->name('galleries.show');

// Messages Routes (Public)
Route::post('/messages', [MessageController::class, 'store'])->name('admin.messages.store');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Chat routes
    Route::get('/messages/{message}/replies', [MessageController::class, 'getLatestReplies'])->name('messages.get-replies');
    Route::post('/messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');
    Route::get('/messages/check-active', [MessageController::class, 'checkActiveChat'])->name('messages.check-active');
    Route::post('messages/{message}/end', [MessageController::class, 'endChat'])->name('messages.end');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::prefix('admin')->name('admin.')->group(function () {
        // User Management
        Route::get('/users', [AdminController::class, 'indexUsers'])->name('users.index');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
        Route::post('/users/{user}/verify', [AdminController::class, 'verifyUser'])->name('users.verify');
        Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
        Route::post('/users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
        
        // Events Management
        Route::resource('events', AdminEventController::class);
        Route::post('/events/{event}/increment-views', [AdminEventController::class, 'incrementViews'])->name('events.increment-views');
        
        // News Management
        Route::resource('news', AdminNewsController::class);
        
        // Messages Management
        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
        Route::post('/messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');

        // Gallery Management
        Route::resource('galleries', AdminGalleryController::class);
    });
});

// Member Routes
Route::middleware(['auth', 'role:anggota'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Event Participation
    Route::post('/events/{event}/participate', [EventController::class, 'participate'])->name('events.participate');
    Route::get('/my-events', [EventController::class, 'myEvents'])->name('events.my');
    
    // Messages
    Route::get('/messages', [MessageController::class, 'userMessages'])->name('messages.my');
    
    // Certificates
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/{certificate}', [CertificateController::class, 'show'])->name('certificates.show');
});

// Admin & Pengurus Routes
Route::middleware(['auth', 'role:admin,pengurus'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Event Management
    Route::post('/events/{event}/approve-participants', [EventController::class, 'approveParticipants'])->name('events.approve-participants');
    
    // Certificate Management
    Route::resource('certificates', CertificateController::class)->except(['index', 'show']);
    
    // Attendance Management
    // Route::resource('attendances', AttendanceController::class);
    // Route::post('/attendances/{attendance}/check-out', [AttendanceController::class, 'checkOut'])->name('attendances.check-out');
});

// Route untuk pesan kontak
Route::post('/contact', [MessageController::class, 'store'])->name('contact.store');

// Route untuk admin
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'role:admin']
], function () {
    Route::resource('messages', App\Http\Controllers\MessageController::class, ['only' => ['index', 'show', 'destroy']]);
    Route::post('messages/{message}/reply', [App\Http\Controllers\MessageController::class, 'reply'])->name('messages.reply');
    Route::post('messages/{message}/reset-password', [App\Http\Controllers\MessageController::class, 'resetPassword'])->name('messages.resetPassword');
});

// Route untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Chat routes
    Route::get('/chat', [MessageController::class, 'chat'])->name('messages.chat');
    Route::post('/chat', [MessageController::class, 'sendMessage'])->name('messages.send');
    Route::get('/chat/{user}', [MessageController::class, 'chatWithUser'])->name('messages.chat-with');
    Route::post('/chat/{user}', [MessageController::class, 'sendMessageToUser'])->name('messages.send-to');
    Route::get('/chat-history', [MessageController::class, 'chatHistory'])->name('messages.history');
});

require __DIR__.'/auth.php';
