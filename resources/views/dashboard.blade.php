
@extends('layouts.app')

@section('title', 'Dashboard Inventory')

@section('content')
<h2 class="mb-4">Dashboard Inventory</h2>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-secondary mb-1">Total Produk</p>
                <h3>{{ $totalProducts }}</h3>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-secondary mb-1">Kategori</p>
                <h3>{{ $totalCategories }}</h3>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-secondary mb-1">Total Stok</p>
                <h3>{{ number_format($totalStock) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-secondary mb-1">Stok Menipis</p>
                <h3 class="text-danger">{{ $lowStock }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5>Riwayat Pergerakan Stok</h5>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($recentMovements as $movement)
                    <tr>
                        <td>{{ $movement->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $movement->product->name }}</td>
                        <td>{{ ucfirst($movement->type) }}</td>
                        <td>{{ number_format($movement->quantity) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-secondary">
                            Belum ada pergerakan stok.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
