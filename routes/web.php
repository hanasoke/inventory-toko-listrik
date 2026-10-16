<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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