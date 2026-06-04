<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Tutor\DashboardController as TutorDashboardController;
use App\Http\Controllers\Tutor\AvailabilityController;
use App\Http\Controllers\Tutor\AppointmentController as TutorAppointmentController;
use App\Http\Controllers\Estudiante\DashboardController as EstudianteDashboardController;
use App\Http\Controllers\Estudiante\SearchController;
use App\Http\Controllers\Estudiante\AppointmentController as EstudianteAppointmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/admin/db', function () {
    $tables = DB::select('SHOW TABLES');
    $data = [];
    foreach ($tables as $table) {
        $name = reset($table);
        $rows = Schema::hasColumn($name, 'created_at')
            ? DB::table($name)->orderBy('created_at', 'desc')->get()
            : DB::table($name)->get();
        if ($rows->isNotEmpty()) {
            $data[$name] = $rows;
        }
    }
    return view('db-viewer', compact('data'));
})->middleware(['auth', \App\Http\Middleware\CheckRole::class . ':admin'])->name('admin.db');

Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'tutor' => redirect()->route('tutor.dashboard'),
            'estudiante' => redirect()->route('estudiante.dashboard'),
            default => redirect()->route('login'),
        };
    }
    return view('landing');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::post('/email/verification-notification', [VerificationController::class, 'send'])->name('verification.send');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');

    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil');
    Route::post('/perfil', [ProfileController::class, 'update']);
    Route::post('/perfil/password', [ProfileController::class, 'updatePassword'])->name('perfil.password');

    Route::get('/notificaciones', [NotificationController::class, 'index'])->name('notificaciones.index');
    Route::get('/notificaciones/unread', [NotificationController::class, 'unread'])->name('notificaciones.unread');
    Route::get('/notificaciones/stream', [NotificationController::class, 'stream'])->name('notificaciones.stream');
    Route::get('/notificaciones/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notificaciones.read');
    Route::post('/notificaciones/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notificaciones.markAllRead');

    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'tutor' => redirect()->route('tutor.dashboard'),
            'estudiante' => redirect()->route('estudiante.dashboard'),
            default => redirect()->route('login'),
        };
    })->name('dashboard');

    Route::prefix('admin')->middleware('role:admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('usuarios', UserController::class)->parameters(['usuarios' => 'user']);
        Route::get('/materias/importar', [ImportController::class, 'index'])->name('materias.import');
        Route::post('/materias/importar', [ImportController::class, 'import']);
        Route::resource('materias', SubjectController::class);
        Route::get('/reportes', [ReportController::class, 'index'])->name('reportes');
        Route::get('/reportes/pdf', [ReportController::class, 'exportPdf'])->name('reportes.pdf');
        Route::get('/actividad', [ActivityLogController::class, 'index'])->name('actividad');
        Route::get('/exportar/usuarios', [ExportController::class, 'users'])->name('exportar.usuarios');
        Route::get('/exportar/materias', [ExportController::class, 'subjects'])->name('exportar.materias');
        Route::get('/exportar/citas', [ExportController::class, 'appointments'])->name('exportar.citas');
        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::patch('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
        Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
    });

    Route::prefix('tutor')->middleware('role:tutor')->name('tutor.')->group(function () {
        Route::get('/dashboard', [TutorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/disponibilidad', [AvailabilityController::class, 'index'])->name('disponibilidad');
        Route::post('/disponibilidad', [AvailabilityController::class, 'store']);
        Route::delete('/disponibilidad/{availability}', [AvailabilityController::class, 'destroy'])->name('disponibilidad.destroy');
        Route::get('/citas', [TutorAppointmentController::class, 'index'])->name('citas');
        Route::patch('/citas/{appointment}/confirmar', [TutorAppointmentController::class, 'confirm'])->name('citas.confirmar');
        Route::patch('/citas/{appointment}/completar', [TutorAppointmentController::class, 'complete'])->name('citas.completar');
        Route::patch('/citas/{appointment}/cancelar', [TutorAppointmentController::class, 'cancel'])->name('citas.cancelar');
    });

    Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{conversation}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{conversation}', [ChatController::class, 'storeMessage'])->name('chat.store');
    Route::get('/chat/{conversation}/poll', [ChatController::class, 'poll'])->name('chat.poll');
    Route::post('/chat/start/{user}', [ChatController::class, 'start'])->name('chat.start');

    Route::prefix('estudiante')->middleware('role:estudiante')->name('estudiante.')->group(function () {
        Route::get('/dashboard', [EstudianteDashboardController::class, 'index'])->name('dashboard');
        Route::get('/buscar', [SearchController::class, 'index'])->name('buscar');
        Route::get('/tutores/{user}', [SearchController::class, 'show'])->name('tutor.show');
        Route::get('/tutores/{user}/disponibilidad', [SearchController::class, 'tutorAvailability'])->name('tutor.disponibilidad');
        Route::get('/citas', [EstudianteAppointmentController::class, 'index'])->name('citas');
        Route::post('/citas', [EstudianteAppointmentController::class, 'store'])->name('citas.store');
        Route::patch('/citas/{appointment}/cancelar', [EstudianteAppointmentController::class, 'cancel'])->name('citas.cancelar');
        Route::post('/citas/{appointment}/review', [ReviewController::class, 'store'])->name('citas.review');
    });
});
