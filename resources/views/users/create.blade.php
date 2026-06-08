@extends('layouts.app')
@section('title', 'Kullanıcı Ekle')
@section('content')
<div class="page-header">
    <div><h1>👤 Yeni Kullanıcı</h1></div>
    <a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri</a>
</div>
<div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">Ad Soyad *</label>
            <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">E-posta *</label>
                <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
                @error('email')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Şifre *</label>
                <input type="password" name="password" class="form-input" required>
                @error('password')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="grid-3">
            <div class="form-group">
                <label class="form-label">Rol *</label>
                <select name="role" class="form-select" required>
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Öğrenci</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Yönetici</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Öğrenci No</label>
                <input type="text" name="student_no" class="form-input" value="{{ old('student_no') }}">
                @error('student_no')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Sınıf</label>
                <input type="text" name="class" class="form-input" value="{{ old('class') }}" placeholder="Ör: 10-A">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Telefon</label>
            <input type="text" name="phone" class="form-input" value="{{ old('phone') }}">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Kaydet</button>
    </form>
</div>
@endsection
