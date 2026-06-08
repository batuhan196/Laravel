@extends('layouts.app')
@section('title', 'Kitap Ekle')
@section('content')
<div class="page-header">
    <div><h1>📖 Yeni Kitap Ekle</h1><p>Kütüphaneye yeni bir kitap kaydedin.</p></div>
    <a href="{{ route('books.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri</a>
</div>
<div class="card" style="max-width:800px">
    <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Kitap Adı *</label>
                <input type="text" name="title" class="form-input" value="{{ old('title') }}" required>
                @error('title')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Yazar *</label>
                <input type="text" name="author" class="form-input" value="{{ old('author') }}" required>
                @error('author')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">ISBN *</label>
                <input type="text" name="isbn" class="form-input" value="{{ old('isbn') }}" placeholder="978-XXX-XX-XXXXX-X" required>
                @error('isbn')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Kategori *</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Seçiniz...</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="grid-3">
            <div class="form-group">
                <label class="form-label">Yayınevi</label>
                <input type="text" name="publisher" class="form-input" value="{{ old('publisher') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Sayfa Sayısı</label>
                <input type="number" name="page_count" class="form-input" value="{{ old('page_count') }}" min="1">
                @error('page_count')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Adet *</label>
                <input type="number" name="quantity" class="form-input" value="{{ old('quantity', 1) }}" min="1" required>
                @error('quantity')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Raf No</label>
                <input type="text" name="shelf_no" class="form-input" value="{{ old('shelf_no') }}" placeholder="Ör: A-01">
            </div>
            <div class="form-group">
                <label class="form-label">Kapak Fotoğrafı</label>
                <input type="file" name="cover_image" class="form-input" accept="image/*">
                @error('cover_image')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Açıklama</label>
            <textarea name="description" class="form-input" rows="3">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Kaydet</button>
    </form>
</div>
@endsection
