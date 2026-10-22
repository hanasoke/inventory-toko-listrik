
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Riwayat Pembelian</h3>
            <p class="text-muted mb-0">
                Daftar pembelian barang dari supplier.
            </p>
        </div>
        <a href="{{ route('purchases.create') }}" class="btn btn-primary">
            + Pembelian Baru
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Nomor Faktur</th>
                        <th>Supplier</th>
                        <th>Petugas</th>
                        <th class="text-start">Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($purchases as $purchase)
                        <tr>
                            <td>{{ $purchases->firstItem() + $loop->index }}</td>
                            <td>{{ $purchase->purchase_date->format('d-m-Y') }}</td>
                            <td>{{ $purchase->invoice_number }}</td>
                            <td>{{ $purchase->supplier->name }}</td>
                            <td>{{ $purchase->user->name }}</td>
                            <td class="text-start">
                                Rp{{ number_format((float) $purchase->total, 2, ',', '.') }}
                            </td>
                            <td>
                                <a href="{{ route('purchases.show', $purchase) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                Belum ada transaksi pembelian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $purchases->links() }}
    </div>
</div>
@endsection
