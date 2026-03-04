<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AdminController;

require __DIR__.'/auth.php'; // perlu untuk route login/register bawaan Breeze

// root page
Route::get('/', function () {
    // jika sudah login, arahkan sesuai peran
    if (auth()->check()) {
        return redirect()->route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'dashboard');
    }
    return view('welcome');
});

// Halaman verifikasi pending (setelah registrasi)
Route::get('/verification-pending', function () {
    return view('auth.verification-pending');
})->name('verification.pending');

// Layar TV antrian publik
Route::get('/display', [\App\Http\Controllers\QueueController::class, 'display'])->name('queue.display');
Route::get('/display/data', [\App\Http\Controllers\QueueController::class, 'displayData'])->name('queue.display.data');

// Rute publik untuk melihat tiket antrian dengan token (QR Code)
Route::get('/antrian/{queue}', [\App\Http\Controllers\QueueController::class,'show'])
    ->whereNumber('queue')
    ->name('queue.show');

/*
|--------------------------------------------------------------------------
| LOGIN PASIEN
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login-pasien');
})->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);


/*
|--------------------------------------------------------------------------
| LOGIN ADMIN
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', function () {
    return view('auth.login-admin');
})->name('admin.login');

Route::post('/admin/login', [AuthenticatedSessionController::class, 'store']);

// fallback logout via URL (menghindari 419 saat akses langsung /logout)
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout.get');


/*
|--------------------------------------------------------------------------
| PASIEN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:patient'])->group(function () {
    Route::get('/dashboard', [PatientController::class,'dashboard'])->name('dashboard');

    // antrian pasien
    Route::get('/antrian/create', [\App\Http\Controllers\QueueController::class,'register'])->name('queue.create');
    Route::post('/antrian', [\App\Http\Controllers\QueueController::class,'store'])->name('queue.store');
    // note: tiket dapat diakses publik melalui QR scan, jadi rute show dibuat di luar middleware

});


/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class,'index'])->name('admin.dashboard');
    Route::get('/admin/scan/{queue}', [AdminController::class,'scanTicket'])->whereNumber('queue')->name('admin.queue.scan');
    
    // User verification
    Route::post('/admin/users/{user}/approve', [AdminController::class,'approveUser'])->name('admin.approve-user');
    Route::post('/admin/users/{user}/reject', [AdminController::class,'rejectUser'])->name('admin.reject-user');
    
    // Queue management
    Route::post('/admin/call-next', [AdminController::class,'callNext'])->name('admin.callNext');
    Route::post('/admin/mark-served/{id}', [AdminController::class,'markServed'])->name('admin.markServed');
    Route::get('/admin/waiting', [AdminController::class,'waiting'])->name('admin.waiting');
    Route::get('/admin/served', [AdminController::class,'served'])->name('admin.served');
});