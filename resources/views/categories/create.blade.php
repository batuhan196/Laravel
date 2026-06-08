@extends('layouts.app')
@section('title', 'Kategori Ekle')
@section('content')
<div class="page-header">
    <div><h1>📁 Yeni Kategori</h1></div>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri</a>
</div>
<div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">Kategori Adı *</label>
            <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Açıklama</label>
            <textarea name="description" class="form-input" rows="3">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">İkon (Emoji)</label>
            <input type="text" name="icon" class="form-input" value="{{ old('icon') }}" placeholder="Ör: 📚">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Kaydet</button>
    </form>
</div>
@endsection
