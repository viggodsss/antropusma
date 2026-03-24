<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;

require __DIR__.'/auth.php'; // perlu untuk route login/register bawaan Breeze

// root page
Route::get('/', function () {
    // jika sudah login, arahkan sesuai peran
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if ($user->role === 'petugas') {
            return redirect()->route('petugas.dashboard');
        }

        return redirect()->route('dashboard');
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
// Login pasien menggunakan route bawaan di routes/auth.php (guest middleware)


/*
|--------------------------------------------------------------------------
| LOGIN ADMIN
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', function () {
    return view('auth.login-admin');
})->middleware('guest')->name('admin.login');

Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');

// fallback logout via URL (menghindari 419 saat akses langsung /logout)
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout.get');

/*
|--------------------------------------------------------------------------
| PROFILE (semua pengguna terautentikasi)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


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

    // Profil Pasien
    Route::get('/profil', [PatientController::class, 'profile'])->name('patient.profile');
    Route::put('/profil', [PatientController::class, 'updateProfile'])->name('patient.profile.update');

    // Daftar Berobat (Riwayat Pendaftaran/Antrian)
    Route::get('/daftar-berobat', [PatientController::class, 'registrations'])->name('patient.registrations');

    // Riwayat Pemeriksaan (read-only)
    Route::get('/riwayat-pemeriksaan', [PatientController::class, 'examinations'])->name('patient.examinations');
    Route::get('/riwayat-pemeriksaan/{examination}', [PatientController::class, 'showExamination'])->name('patient.examinations.show');

    // Resep Obat (read-only)
    Route::get('/resep-obat', [PatientController::class, 'prescriptions'])->name('patient.prescriptions');
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
    
    // Patient profile view (admin)
    Route::get('/admin/patients', [AdminController::class, 'patients'])->name('admin.patients');
    Route::get('/admin/patients/{user}/profile', [AdminController::class, 'showPatientProfile'])->name('admin.patient.profile');
    Route::post('/admin/patients/{user}/profile-photo', [AdminController::class, 'updatePatientProfilePhoto'])->name('admin.patient.profile-photo.update');
    Route::delete('/admin/patients/{user}/profile-photo', [AdminController::class, 'deletePatientProfilePhoto'])->name('admin.patient.profile-photo.delete');
    Route::get('/admin/petugas', [AdminController::class, 'petugas'])->name('admin.petugas');
    Route::post('/admin/petugas', [AdminController::class, 'storePetugas'])->name('admin.petugas.store');
    Route::put('/admin/petugas/{user}', [AdminController::class, 'updatePetugas'])->name('admin.petugas.update');
    Route::post('/admin/petugas/{user}/deactivate', [AdminController::class, 'deactivatePetugas'])->name('admin.petugas.deactivate');
    Route::delete('/admin/petugas/{user}', [AdminController::class, 'destroyPetugas'])->name('admin.petugas.destroy');
    
    // Queue management
    Route::get('/admin/call-next', [AdminController::class,'callNext'])->name('admin.callNext.get');
    Route::post('/admin/call-next', [AdminController::class,'callNext'])->name('admin.callNext');
    Route::post('/admin/mark-served/{id}', [AdminController::class,'markServed'])->name('admin.markServed');
    Route::post('/admin/mark-served-all', [AdminController::class,'markAllWaitingServed'])->name('admin.markServedAll');
    Route::post('/admin/queues/manual', [AdminController::class, 'storeManualQueue'])->name('admin.queues.manual.store');
    Route::post('/admin/queues/{queue}/approve', [AdminController::class,'approveQueue'])->name('admin.queues.approve');
    Route::post('/admin/queues/{queue}/reject', [AdminController::class,'rejectQueue'])->name('admin.queues.reject');
    Route::delete('/admin/queues/{queue}/stuck', [AdminController::class,'destroyStuckQueue'])->name('admin.queues.destroy-stuck');
    Route::get('/admin/waiting', [AdminController::class,'waiting'])->name('admin.waiting');
    Route::get('/admin/served', [AdminController::class,'served'])->name('admin.served');
    Route::get('/admin/reports/queues/download', [AdminController::class, 'downloadQueueReport'])->name('admin.reports.queues.download');
    
    // Settings
    Route::get('/admin/settings', [AdminController::class,'settings'])->name('admin.settings');
    Route::post('/admin/settings', [AdminController::class,'updateSettings'])->name('admin.settings.update');
    Route::post('/admin/settings/video/{slot}/delete', [AdminController::class, 'removeDisplayVideo'])->name('admin.settings.video.delete');
});

/*
|--------------------------------------------------------------------------
| PETUGAS KLASTER AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/petugas', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');
    Route::get('/petugas/call-next', [PetugasController::class, 'callNextFromUrl'])->name('petugas.callNext.get');
    Route::post('/petugas/call-next', [PetugasController::class, 'callNext'])->name('petugas.callNext');
    Route::post('/petugas/queues/{queue}/served', [PetugasController::class, 'markServed'])->name('petugas.markServed');

    // Khusus klaster 2,3,4: input pemeriksaan + resep
    Route::get('/petugas/examinations/{queue}/create', [PetugasController::class, 'createExamination'])->name('petugas.examinations.create');
    Route::post('/petugas/examinations/{queue}', [PetugasController::class, 'storeExamination'])->name('petugas.examinations.store');

    // Khusus klaster 5: update status resep
    Route::post('/petugas/prescriptions/{prescription}/status', [PetugasController::class, 'updatePrescriptionStatus'])->name('petugas.prescriptions.update-status');
});