@extends('layouts.app')
@section('title', 'Kategori Düzenle')
@section('content')
<div class="page-header">
    <div><h1>✏️ Kategori Düzenle</h1></div>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri</a>
</div>
<div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('categories.update', $category) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Kategori Adı *</label>
            <input type="text" name="name" class="form-input" value="{{ old('name', $category->name) }}" required>
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Açıklama</label>
            <textarea name="description" class="form-input" rows="3">{{ old('description', $category->description) }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">İkon (Emoji)</label>
            <input type="text" name="icon" class="form-input" value="{{ old('icon', $category->icon) }}">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Güncelle</button>
    </form>
</div>
@endsection
