
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Transaksi Pembelian Barang</h3>
            <p class="text-muted mb-0">
                Pembelian berhasil disimpan akan menambah stok otomatis.
            </p>
        </div>
        <a href="{{ route('purchases.index') }}"
           class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali data pembelian:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('purchases.store') }}" method="POST">
        @csrf

        <div class="card mb-4">
            <div class="card-header">Informasi Pembelian</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Supplier</label>
                        <select name="supplier_id" class="form-select" required>
                            <option value="">Pilih supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    @selected(old('supplier_id') == $supplier->id)>
                                    {{ $supplier->name }}
                                    {{ $supplier->code ? '('.$supplier->code.')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Nomor Faktur</label>
                        <input type="text"
                               name="invoice_number"
                               class="form-control"
                               value="{{ old('invoice_number') }}"
                               maxlength="50"
                               placeholder="INV-2026-001"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tanggal Pembelian</label>
                        <input type="date"
                               name="purchase_date"
                               class="form-control"
                               value="{{ old('purchase_date', now()->format('Y-m-d')) }}"
                               required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Catatan</label>
                        <textarea name="notes"
                                  class="form-control"
                                  rows="2"
                                  maxlength="2000">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Detail Barang</span>
                <button type="button" id="add-row" class="btn btn-sm btn-primary">
                    + Tambah Barang
                </button>
            </div>

            <div class="card-body">
                @if ($products->isEmpty())
                    <div class="alert alert-warning">
                        Belum ada produk. Tambahkan produk terlebih dahulu
                        melalui menu Barang.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th style="min-width: 220px">Produk</th>
                                    <th style="min-width: 120px">Jumlah</th>
                                    <th style="min-width: 180px">Harga Beli</th>
                                    <th style="min-width: 160px">Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="purchase-items">
                                @php
                                    $oldItems = old('items', [
                                        ['product_id' => '', 'quantity' => 1, 'unit_price' => '']
                                    ]);
                                @endphp

                                @foreach ($oldItems as $i => $item)
                                    <tr class="purchase-row">
                                        <td>
                                            <select name="items[{{ $i }}][product_id]"
                                                    class="form-select product-select"
                                                    required>
                                                <option value="">Pilih produk</option>
                                                @foreach ($products as $product)
                                                    <option
                                                        value="{{ $product->id }}"
                                                        data-price="{{ $product->purchase_price }}"
                                                        @selected(($item['product_id'] ?? '') == $product->id)>
                                                        {{ $product->sku }} -
                                                        {{ $product->name }}
                                                        (Stok: {{ $product->stock }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number"
                                                   name="items[{{ $i }}][quantity]"
                                                   class="form-control quantity-input"
                                                   min="1"
                                                   step="1"
                                                   value="{{ $item['quantity'] ?? 1 }}"
                                                   required>
                                        </td>
                                        <td>
                                            <input type="number"
                                                   name="items[{{ $i }}][unit_price]"
                                                   class="form-control price-input"
                                                   min="0"
                                                   step="0.01"
                                                   value="{{ $item['unit_price'] ?? '' }}"
                                                   required>
                                        </td>
                                        <td class="subtotal">Rp0</td>
                                        <td>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger remove-row">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end mt-3">
                        <span class="text-muted">Total Pembelian</span>
                        <h4 id="grand-total">Rp0</h4>
                    </div>
                @endif
            </div>
        </div>

        @if ($products->isNotEmpty())
            <div class="text-end">
                <button type="submit" class="btn btn-success btn-lg">
                    Simpan Pembelian dan Tambah Stok
                </button>
            </div>
        @endif
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.getElementById('purchase-items');
    const addButton = document.getElementById('add-row');
    let nextIndex = {{ count(old('items', [
        ['product_id' => '', 'quantity' => 1, 'unit_price' => '']
    ])) }};

    const rupiah = value => new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 2
    }).format(value || 0);

    function calculate() {
        let total = 0;

        tbody.querySelectorAll('.purchase-row').forEach(row => {
            const qty = Number(row.querySelector('.quantity-input').value) || 0;
            const price = Number(row.querySelector('.price-input').value) || 0;
            const subtotal = qty * price;

            row.querySelector('.subtotal').textContent = rupiah(subtotal);
            total += subtotal;
        });

        document.getElementById('grand-total').textContent = rupiah(total);
    }

    function bindRow(row) {
        row.querySelector('.product-select').addEventListener('change', function () {
            const option = this.selectedOptions[0];
            const priceInput = row.querySelector('.price-input');

            if (option && option.dataset.price !== undefined) {
                priceInput.value = option.value ? option.dataset.price : '';
            }

            calculate();
        });

        row.querySelectorAll('.quantity-input, .price-input').forEach(input => {
            input.addEventListener('input', calculate);
        });

        row.querySelector('.remove-row').addEventListener('click', function () {
            if (tbody.querySelectorAll('.purchase-row').length > 1) {
                row.remove();
                calculate();
            } else {
                alert('Minimal harus ada satu baris barang.');
            }
        });
    }

    addButton?.addEventListener('click', function () {
        const template = tbody.querySelector('.purchase-row');
        const row = template.cloneNode(true);

        row.querySelectorAll('input').forEach(input => {
            if (input.classList.contains('quantity-input')) {
                input.value = 1;
            } else {
                input.value = '';
            }
        });

        row.querySelector('.product-select').selectedIndex = 0;
        row.querySelector('.subtotal').textContent = rupiah(0);

        row.querySelectorAll('input, select').forEach(input => {
            input.name = input.name.replace(
                /items\[\d+\]/,
                'items[' + nextIndex + ']'
            );
        });

        nextIndex++;
        tbody.appendChild(row);
        bindRow(row);
        calculate();
    });

    tbody.querySelectorAll('.purchase-row').forEach(bindRow);
    calculate();
});
</script>
@endsection
