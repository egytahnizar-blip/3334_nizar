<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\CategoryController as CategoryAdminController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes (Akses Umum / Publik)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/1', [EventAdminController::class, 'show'])->name('events.show');
Route::get('/checkout', [EventAdminController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [EventAdminController::class, 'ticket'])->name('ticket');

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


/*
|--------------------------------------------------------------------------
| Admin Area Routes (Grup Bertumpuk Sesuai Modul Praktikum)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // 1. Redirect URL /admin langsung ke halaman dashboard admin
    Route::redirect('/', 'admin/dashboard');

    // 2. Rute Autentikasi / Login (Bebas Akses)
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // 3. Proteksi Lapisan Keamanan Middleware (Wajib Login)
    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Resource Controllers (Event, Kategori, Partner)
        Route::resource('events', EventAdminController::class);
        Route::resource('categories', CategoryAdminController::class);
        Route::resource('partners', PartnerController::class);

        // Rute Laporan Transaksi Admin
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    });
});


/*
|--------------------------------------------------------------------------
| Halaman Statis Tambahan
|--------------------------------------------------------------------------
*/

Route::get('/tentang', function() {
    return '<h1>Ini adalah halaman tentang aplikasi Event Hub</h1>';
});

Route::get('/kontak', function() {
    return view('contact');
});

Route::get('/profil', function(){
    return view('profil');
});

Route::get('/katalog', function(){
    return view('katalog');
});


Route::get('/bantuan', function(){
    return view('bantuan');
});
