<?php

use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', [App\Http\Controllers\LandingPageController::class, 'index'])->name('index');
Route::get('/produk/{slug}', [App\Http\Controllers\LandingPageController::class, 'produk'])->name('produk');
Route::post('/booking', [App\Http\Controllers\LandingPageController::class, 'produkBooking'])->name('produk.booking');
Route::get('/checkout', [App\Http\Controllers\LandingPageController::class, 'checkout'])->name('produk.checkout');
Route::post('/midtrans-callback', [App\Http\Controllers\BookingController::class, 'handleCallback'])->name('midtrans.callback');

// Booking Routes
Route::prefix('booking')->group(function () {
    Route::post('/process', [BookingController::class, 'processBooking'])->name('booking.process');
});

Route::get('/tentang-kami', [App\Http\Controllers\LandingPageController::class, 'about'])->name('tentang-kami');
Route::get('/sk', [App\Http\Controllers\LandingPageController::class, 'terms'])->name('sk');

Route::middleware(['auth', 'verified'])->prefix('admin')->as('admin.')->group(function () {
    // Dashboard Route
    Route::get('dashboard', App\Http\Controllers\Admin\DashboardController::class . '@index')->name('dashboard');

    // User Management Routes
    Route::prefix('produk')->as('produk.')->group(function () {
        Route::resource('category', App\Http\Controllers\Admin\Produk\CategoryController::class)->only(['index', 'store', 'edit', 'destroy']);
        Route::resource('produk', App\Http\Controllers\Admin\Produk\ProdukController::class)->only(['index', 'store', 'edit', 'destroy']);
        Route::resource('fasilitas', App\Http\Controllers\Admin\Produk\ProdukFasilitasController::class)->only(['index', 'store', 'edit', 'destroy']);
        Route::resource('wisata', App\Http\Controllers\Admin\Produk\ProdukWisataController::class)->only(['index', 'store', 'edit', 'destroy']);
        Route::resource('syarat', App\Http\Controllers\Admin\Produk\ProdukSyaratController::class)->only(['index', 'store', 'edit', 'destroy']);
        Route::resource('image', App\Http\Controllers\Admin\Produk\ProdukImageController::class)->only(['index', 'store', 'edit', 'destroy']);
    });

    // Transaksi Routes
    Route::prefix('transaksi')->as('transaksi.')->group(function () {
        Route::resource('transaksi', App\Http\Controllers\Admin\Transaksi\TransaksiController::class);
    });

    // Rekening Routes
    Route::resource('rekening', App\Http\Controllers\Admin\RekeningController::class);

    // User Management Routes
    Route::prefix('user-management')->as('user-management.')->group(function () {
        Route::resource('user', App\Http\Controllers\Admin\UserManagement\UserController::class)->only(['index', 'store', 'edit', 'destroy']);
        Route::post('user-access', [App\Http\Controllers\Admin\UserManagement\UserController::class, 'access'])->name('user.access');
        Route::resource('role', App\Http\Controllers\Admin\UserManagement\RoleController::class);
        Route::resource('permission', App\Http\Controllers\Admin\UserManagement\PermissionController::class)->only(['index', 'store', 'edit', 'destroy']);
    });

    // Activity Log Routes
    Route::get('activity-log', App\Http\Controllers\Admin\ActivityLogController::class . '@index')->name('activity-log.index');
    Route::delete('activity-log/destroy/{id}', App\Http\Controllers\Admin\ActivityLogController::class . '@destroy')->name('activity-log.destroy');

    // Setting Routes
    Route::get('setting', App\Http\Controllers\Admin\SettingController::class . '@index')->name('setting.index');
    Route::post('setting/general', App\Http\Controllers\Admin\SettingController::class . '@general')->name('setting.general');
    Route::post('setting/contact', App\Http\Controllers\Admin\SettingController::class . '@contact')->name('setting.contact');
    Route::post('setting/sosmed', App\Http\Controllers\Admin\SettingController::class . '@sosmed')->name('setting.sosmed');
    Route::post('setting/page', App\Http\Controllers\Admin\SettingController::class . '@page')->name('setting.page');
});

Route::middleware('auth')->group(function () {

    Route::get('/profile', App\Http\Controllers\ProfileController::class . '@edit')->name('profile.edit');
    Route::patch('/profile', App\Http\Controllers\ProfileController::class . '@update')->name('profile.update');
    Route::delete('/profile', App\Http\Controllers\ProfileController::class . '@destroy')->name('profile.destroy');
});

require __DIR__ . '/auth.php';

require __DIR__ .'/api.php';