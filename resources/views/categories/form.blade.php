
@extends('layouts.app')

@section('title', $pageTitle)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h3 class="mb-4">{{ $pageTitle }}</h3>

                <form method="POST"
                    action="{{ $category->exists
                        ? route('categories.update', $category)
                        : route('categories.store') }}">
                    @csrf

                    @if ($category->exists)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $category->name) }}"
                            maxlength="100" required>

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" rows="3"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-primary float-end">Simpan</button>
                    <a href="{{ route('categories.index') }}"
                        class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
