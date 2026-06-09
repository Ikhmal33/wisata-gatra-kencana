<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashflowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RekapanController;
use Illuminate\Support\Facades\Route;

// ── Public ────────────────────────────────────────────────────────
Route::get('/',        [PublicController::class, 'index'])->name('home');
Route::get('/booking', [PublicController::class, 'booking'])->name('public.booking');

// ── Auth ──────────────────────────────────────────────────────────
Route::get('/admin',         [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login',  [AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// ── Protected admin/cashier routes ────────────────────────────────
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // POS Dashboard (cashiers + admin; not content_admin)
    Route::middleware(['can_access_finance'])->group(function () {
        Route::get('/dashboard',      [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/ticket/store',  [DashboardController::class, 'storeTicket'])->name('ticket.store');
        
        Route::get('/rekapan',             [RekapanController::class, 'index'])->name('rekapan');
        Route::get('/rekapan/export',      [RekapanController::class, 'export'])->name('rekapan.export');
        Route::get('/rekapan/bulanan',     [RekapanController::class, 'monthly'])->name('rekapan.bulanan');
        Route::get('/rekapan/bulanan/export', [RekapanController::class, 'exportMonthly'])->name('rekapan.bulanan.export');
        
        Route::get('/kas',        [CashflowController::class, 'index'])->name('kas');
        Route::post('/kas/store', [CashflowController::class, 'store'])->name('kas.store');
        Route::get('/kas/export', [CashflowController::class, 'export'])->name('kas.export');
    });

    // News CRUD (content_admin + admin)
    Route::middleware(['can_access_news'])->group(function () {
        Route::get('/news',              [NewsController::class, 'index'])->name('news.index');
        Route::get('/news/create',       [NewsController::class, 'create'])->name('news.create');
        Route::post('/news',             [NewsController::class, 'store'])->name('news.store');
        Route::get('/news/{article}/edit', [NewsController::class, 'edit'])->name('news.edit');
        Route::put('/news/{article}',    [NewsController::class, 'update'])->name('news.update');
        Route::delete('/news/{article}', [NewsController::class, 'destroy'])->name('news.destroy');
        Route::post('/news/{article}/toggle', [NewsController::class, 'togglePublish'])->name('news.toggle');
    });
});