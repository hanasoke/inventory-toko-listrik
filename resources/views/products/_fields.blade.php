
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Kategori</label>
        <select name="category_id"
            class="form-select @error('category_id') is-invalid @enderror"
            required>
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    @selected((string) old('category_id', $product->category_id) === (string) $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Kode Barang (SKU)</label>
        <input name="sku" maxlength="50"
            class="form-control @error('sku') is-invalid @enderror"
            value="{{ old('sku', $product->sku) }}" required>
        @error('sku')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Nama Produk</label>
        <input name="name" maxlength="150"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $product->name) }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Satuan</label>
        <select name="unit" class="form-select" required>
            @foreach (['pcs', 'meter', 'roll', 'dus', 'set', 'box'] as $unit)
                <option value="{{ $unit }}"
                    @selected(old('unit', $product->unit ?: 'pcs') === $unit)>
                    {{ $unit }}
                </option>
            @endforeach
        </select>
        @error('unit')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Harga Beli (Rp)</label>
        <input type="number" name="purchase_price"
            min="0" step="0.01"
            class="form-control @error('purchase_price') is-invalid @enderror"
            value="{{ old('purchase_price', $product->purchase_price ?? 0) }}"
            required>
        @error('purchase_price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Harga Jual (Rp)</label>
        <input type="number" name="selling_price"
            min="0" step="0.01"
            class="form-control @error('selling_price') is-invalid @enderror"
            value="{{ old('selling_price', $product->selling_price ?? 0) }}"
            required>
        @error('selling_price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Stok Minimum</label>
        <input type="number" name="min_stock" min="0"
            class="form-control @error('min_stock') is-invalid @enderror"
            value="{{ old('min_stock', $product->min_stock ?? 5) }}"
            required>
        @error('min_stock')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @if ($product->exists)
        <div class="col-md-6">
            <label class="form-label">Stok Saat Ini</label>
            <input class="form-control"
                value="{{ $product->stock }} {{ $product->unit }}" disabled>
            <div class="form-text">
                Ubah stok melalui menu transaksi barang masuk/keluar.
            </div>
        </div>
    @endif

    <div class="col-12">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" rows="3"
            class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<hr class="my-4">
