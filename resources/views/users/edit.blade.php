@extends('layouts.app')
@section('title', 'Kullanıcı Düzenle')
@section('content')
<div class="page-header">
    <div><h1>✏️ Kullanıcı Düzenle</h1></div>
    <a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri</a>
</div>
<div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Ad Soyad *</label>
            <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">E-posta *</label>
                <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Yeni Şifre (opsiyonel)</label>
                <input type="password" name="password" class="form-input" placeholder="Değiştirmek istemiyorsanız boş bırakın">
            </div>
        </div>
        <div class="grid-3">
            <div class="form-group">
                <label class="form-label">Rol *</label>
                <select name="role" class="form-select" required>
                    <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Öğrenci</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Yönetici</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Öğrenci No</label>
                <input type="text" name="student_no" class="form-input" value="{{ old('student_no', $user->student_no) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Sınıf</label>
                <input type="text" name="class" class="form-input" value="{{ old('class', $user->class) }}">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Telefon</label>
            <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Güncelle</button>
    </form>
</div>
@endsection
