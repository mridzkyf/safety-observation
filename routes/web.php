<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SafetyObservationController;
use App\Http\Controllers\ApproverController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\AdminController;
use App\Exports\SafetyObservationExport;
use App\Http\Controllers\ExportController;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;



Route::get('/', function () {
    return view('welcome');
});

// Redirect user setelah login, tergantung rolenya
Route::get('/redirect-after-login', function () {
    $user = auth()->user();

    if ($user->is_admin) {
        return redirect()->route('admin.dashboard');
    }

    if (in_array($user->role, ['supervisor', 'manager'])) {
        return redirect()->route('approver.dashboard');
    }

    // Default untuk user biasa
    return redirect()->route('user.dashboard');
})->middleware(['auth'])->name('redirect-after-login');

// Admin Dashboard
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard/{id}', [AdminController::class, 'show'])->name('admin.detail');
    Route::get('/admin/tabel', [AdminController::class, 'tabel'])->name('admin.tabel');
    Route::get('/admin/users/dashusers', [AdminController::class, 'dashUsers'])->name('admin.users.dashusers');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users', [AdminController::class, 'listUsers'])->name('admin.users.tabeluser');
    Route::delete('/admin/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/admin/users/edit/{id}', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/update/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    // === SIC Area Management ===
    Route::get('/admin/area', [AdminController::class, 'indexArea'])->name('admin.area.index');
    Route::get('/admin/area/create', [AdminController::class, 'createArea'])->name('admin.area.create');
    Route::post('/admin/area/store', [AdminController::class, 'storeArea'])->name('admin.area.store');
    Route::get('/admin/area/edit/{id}', [AdminController::class, 'editArea'])->name('admin.area.edit');
    Route::put('/admin/area/update/{id}', [AdminController::class, 'updateArea'])->name('admin.area.update');
    Route::delete('/admin/area/delete/{id}', [AdminController::class, 'deleteArea'])->name('admin.area.delete');
    Route::post('/area/{area}/assign/{user}', [AdminController::class, 'assignUserToArea'])->name('admin.area.assignUser');
    Route::delete('/area/{area}/remove/{user}', [AdminController::class, 'removeUserFromArea'])->name('admin.area.removeUser');
});


// User Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/approver/dashboard', [ApproverController::class, 'index'])->name('approver.dashboard');
    Route::get('/approver/temuan', [ApproverController::class, 'temuanSeksi'])->name('approver.temuan');
    // Route::get('/approver/terlapor', [ApproverController::class, 'laporanTerlapor'])->name('approver.terlapor');
    //tabel berdasarkan seksi
    Route::get('/approver/temuan', [ApproverController::class, 'temuanSeksi'])->name('approver.temuan');
    Route::get('/approver/temuan/{id}', [ApproverController::class, 'show'])->name('approver.temuan.detail');
    Route::post('/approver/approve/{id}', [ApproverController::class, 'approve'])->name('approver.approve');
    Route::get('/approver/terlapor', [ApproverController::class, 'terlapor'])->name('approver.terlapor');
    Route::post('/approver/terlapor/update-status/{id}', [ApproverController::class, 'updateStatusTerlapor'])->name('approver.terlapor.update');
    Route::post('/approver/close/{id}', [ApproverController::class, 'close'])->name('approver.close');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/laporan-saya', [SafetyObservationController::class, 'laporanSaya'])->name('user.laporan');
    Route::get('/user/detail/{id}/{source?}', [SafetyObservationController::class, 'show'])->name('user.userdetail');
});

// Form Safety Observation (untuk user biasa)
Route::get('/safety-observation/form', [SafetyObservationController::class, 'create'])->name('safety-observation.form');
Route::post('/safety-observation/store', [SafetyObservationController::class, 'store'])->name('safety-observation.store');

// Profile Routes (bisa diakses user login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//untuk chart 
Route::get('/chart/data/pie', [ChartController::class, 'pieData']);
Route::get('/chart/data/pieStatus', [ChartController::class, 'pieDataStatus']);
Route::get('/chart/data/bar-area', [ChartController::class, 'barByAreaData']);
Route::get('/chart/data/pie-seksi', [ChartController::class, 'pieSeksiData']);
Route::get('/analisis/pie', [ChartController::class, 'pieView'])->name('analisis.pie');

//untuk export data Excel
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/export-so', [ExportController::class, 'exportAdmin'])->name('admin.export.so');

    Route::get('/manager/export-so', [ExportController::class, 'exportManagerPelapor'])->name('manager.export.so');

    Route::get('/manager/export-terlapor', [ExportController::class, 'exportManagerTerlapor'])->name('manager.export.terlapor');
});
require __DIR__.'/auth.php';
