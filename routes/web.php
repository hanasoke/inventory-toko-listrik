<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\PurchaseController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');
});

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('dashboard'));

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});

Route::get('/cek-koneksi', function () {
    try {
        $result = DB::selectOne(
            'SELECT @@SERVERNAME AS server_name,
                    DB_NAME() AS database_name'
        );

        return response()->json([
            'status' => 'berhasil',
            'server' => $result->server_name,
            'database' => $result->database_name,
        ]);
    } catch (\Throwable $e) {
        report($e);

        return response()->json([
            'status' => 'gagal',
            'pesan' => 'Koneksi database gagal.',
        ], 500);
    }
});

Route::get('/stock-movements', [
    StockMovementController::class, 'index'
])->name('stock-movements.index');

Route::get('/stock-movements/create', [
    StockMovementController::class, 'create'
])->name('stock-movements.create');

Route::post('/stock-movements', [
    StockMovementController::class, 'store'
])->name('stock-movements.store');

Route::middleware('auth')->group(function() {
    Route::resource('suppliers', SupplierController::class);
});

Route::resource('purchases', PurchaseController::class)
    ->only(['index', 'create', 'store', 'show']);