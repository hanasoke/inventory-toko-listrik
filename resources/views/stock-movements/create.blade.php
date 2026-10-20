
@extends('layouts.app')

@section('title', 'Transaksi Stok')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h3 class="mb-1">Transaksi Stok</h3>
                <p class="text-secondary mb-4">
                    Catat penerimaan atau pengeluaran barang.
                </p>

                @if ($products->isEmpty())
                    <div class="alert alert-warning">
                        Belum ada produk.
                        <a href="{{ route('products.create') }}">
                            Tambahkan produk terlebih dahulu.
                        </a>
                    </div>
                @else
                    <form method="POST"
                        action="{{ route('stock-movements.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Jenis Transaksi</label>
                            <select name="type"
                                class="form-select @error('type') is-invalid @enderror"
                                required>
                                <option value="">Pilih transaksi</option>
                                <option value="masuk"
                                    @selected(old('type') === 'masuk')>
                                    Barang Masuk
                                </option>
                                <option value="keluar"
                                    @selected(old('type') === 'keluar')>
                                    Barang Keluar
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Produk</label>
                            <select name="product_id"
                                class="form-select @error('product_id') is-invalid @enderror"
                                required>
                                <option value="">Pilih produk</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        @selected((string) old('product_id') === (string) $product->id)>
                                        {{ $product->sku }} — {{ $product->name }}
                                        (Stok: {{ $product->stock }} {{ $product->unit }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Barang</label>
                            <input type="number" name="quantity"
                                class="form-control @error('quantity') is-invalid @enderror"
                                min="1" step="1"
                                value="{{ old('quantity') }}"
                                required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Nomor Referensi (opsional)
                            </label>
                            <input type="text" name="reference_number"
                                maxlength="50" class="form-control"
                                value="{{ old('reference_number') }}"
                                placeholder="Contoh: INV-2026-001">
                            @error('reference_number')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Keterangan</label>
                            <textarea name="notes" rows="3"
                                class="form-control @error('notes') is-invalid @enderror"
                                placeholder="Contoh: Pembelian lampu dari supplier">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary">
                            Simpan Transaksi
                        </button>
                        <a href="{{ route('stock-movements.index') }}"
                            class="btn btn-secondary">
                            Kembali
                        </a>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
