@extends('layouts.app')
@section('title', 'Kitap Düzenle')
@section('content')
<div class="page-header">
    <div><h1>✏️ Kitap Düzenle</h1><p>{{ $book->title }} kitabını düzenliyorsunuz.</p></div>
    <a href="{{ route('books.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri</a>
</div>
<div class="card" style="max-width:800px">
    <form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Kitap Adı *</label>
                <input type="text" name="title" class="form-input" value="{{ old('title', $book->title) }}" required>
                @error('title')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Yazar *</label>
                <input type="text" name="author" class="form-input" value="{{ old('author', $book->author) }}" required>
                @error('author')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">ISBN *</label>
                <input type="text" name="isbn" class="form-input" value="{{ old('isbn', $book->isbn) }}" required>
                @error('isbn')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Kategori *</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $book->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="grid-3">
            <div class="form-group">
                <label class="form-label">Yayınevi</label>
                <input type="text" name="publisher" class="form-input" value="{{ old('publisher', $book->publisher) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Sayfa Sayısı</label>
                <input type="number" name="page_count" class="form-input" value="{{ old('page_count', $book->page_count) }}" min="1">
            </div>
            <div class="form-group">
                <label class="form-label">Adet *</label>
                <input type="number" name="quantity" class="form-input" value="{{ old('quantity', $book->quantity) }}" min="1" required>
            </div>
        </div>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Raf No</label>
                <input type="text" name="shelf_no" class="form-input" value="{{ old('shelf_no', $book->shelf_no) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Kapak Fotoğrafı</label>
                <input type="file" name="cover_image" class="form-input" accept="image/*">
                @if($book->cover_image)<p style="font-size:.7rem;color:var(--text-muted);margin-top:.25rem">Mevcut kapak var. Yeni dosya seçilmezse korunur.</p>@endif
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Açıklama</label>
            <textarea name="description" class="form-input" rows="3">{{ old('description', $book->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Güncelle</button>
    </form>
</div>
@endsection
