@extends('layouts.app')

@section('title', 'Riwayat Transaksi Stok')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                <div>
                    <h2 class="mb-1">Riwayat Transaksi Stok</h2>
                    <p class="text-secondary mb-0">
                        Catatan barang masuk dan barang keluar.
                    </p>
                </div>

                <a href="{{ route('stock-movements.create') }}"
                    class="btn btn-primary">
                    + Transaksi Baru
                </a>
            </div>

            <form method="GET" class="row g-2 mb-3">
                <div class="col-8 col-md-4">
                    <select name="type" class="form-select">
                        <option value="">Semua Transaksi</option>
                        <option value="masuk"
                            @selected(request('type') === 'masuk')>
                            Barang Masuk
                        </option>
                        <option value="keluar"
                            @selected(request('type') === 'keluar')>
                            Barang Keluar
                        </option>
                    </select>
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary">Filter</button>
                    <a href="{{ route('stock-movements.index') }}"
                        class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Nomor Referensi</th>
                                <th>Produk</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Petugas</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($movements as $movement)
                                <tr>
                                    <td>{{ $movement->created_at->format('d-m-Y H:i') }}</td>
                                    <td>{{ $movement->reference_number ?: '-' }}</td>
                                    <td>
                                        {{ $movement->product->sku }}<br>
                                        <small class="text-secondary">
                                            {{ $movement->product->name }}
                                        </small>
                                    </td>
                                    <td>
                                        @if ($movement->type === 'masuk')
                                            <span class="badge text-bg-success">Masuk</span>
                                        @else
                                            <span class="badge text-bg-danger">Keluar</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($movement->quantity) }}
                                        {{ $movement->product->unit }}</td>
                                    <td>{{ $movement->user->name }}</td>
                                    <td>{{ $movement->notes ?: '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        Belum ada transaksi stok.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                {{ $movements->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
