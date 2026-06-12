<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\CategoryController as CategoryAdminController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TransactionController;
use App\Models\Transaction; // Jangan lupa tambahkan ini untuk rute tes

/*
|--------------------------------------------------------------------------
| Web Routes (Akses Umum / Publik)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/1', [EventAdminController::class, 'show'])->name('events.show');
Route::get('/checkout', [EventAdminController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [EventAdminController::class, 'ticket'])->name('ticket');
Route::get('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');

// 🔴 Rute Tes Database (Untuk pengecekan di cloud)
Route::get('/tes-db', function () {
    try {
        $t = new Transaction();
        $t->event_id = 1; // Pastikan event ID 1 ada di database cloud kamu
        $t->order_id = 'TRX-TEST-' . time();
        $t->customer_name = 'Nizar Testing';
        $t->customer_email = 'nizar@test.com';
        $t->customer_phone = '08123456789';
        $t->total_price = 50000;
        $t->status = 'pending';
        $t->save();
        return "Data berhasil disimpan ke database!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


/*
|--------------------------------------------------------------------------
| Admin Area Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::redirect('/', 'admin/dashboard');

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('events', EventAdminController::class);
        Route::resource('categories', CategoryAdminController::class);
        Route::resource('partners', PartnerController::class);

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
