@extends('layouts.app')
@section('title', 'Profil Ayarları')
@section('content')
<div class="page-header">
    <div><h1>⚙️ Profil Ayarları</h1><p>Hesap bilgilerinizi güncelleyin.</p></div>
</div>

<!-- Profil Bilgileri -->
<div class="card" style="max-width:700px;margin-bottom:1.5rem">
    <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem"><i class="fas fa-user" style="color:var(--accent);margin-right:8px"></i>Profil Bilgileri</h3>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf @method('PATCH')
        <div class="form-group">
            <label class="form-label">Ad Soyad</label>
            <input type="text" name="name" class="form-input" value="{{ old('name', auth()->user()->name) }}" required>
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">E-posta</label>
            <input type="email" name="email" class="form-input" value="{{ old('email', auth()->user()->email) }}" required>
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Bilgileri Güncelle</button>
        @if(session('status') === 'profile-updated')
        <span style="font-size:.8rem;color:var(--success);margin-left:1rem"><i class="fas fa-check"></i> Güncellendi!</span>
        @endif
    </form>
</div>

<!-- Şifre Değiştir -->
<div class="card" style="max-width:700px;margin-bottom:1.5rem">
    <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem"><i class="fas fa-lock" style="color:var(--info);margin-right:8px"></i>Şifre Değiştir</h3>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Mevcut Şifre</label>
            <input type="password" name="current_password" class="form-input" required>
            @error('current_password', 'updatePassword')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Yeni Şifre</label>
                <input type="password" name="password" class="form-input" required>
                @error('password', 'updatePassword')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Yeni Şifre (Tekrar)</label>
                <input type="password" name="password_confirmation" class="form-input" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-key"></i> Şifreyi Güncelle</button>
        @if(session('status') === 'password-updated')
        <span style="font-size:.8rem;color:var(--success);margin-left:1rem"><i class="fas fa-check"></i> Şifre güncellendi!</span>
        @endif
    </form>
</div>

<!-- Hesap Bilgileri -->
<div class="card" style="max-width:700px">
    <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem"><i class="fas fa-info-circle" style="color:var(--warning);margin-right:8px"></i>Hesap Bilgileri</h3>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;font-size:.85rem">
        <div>
            <span style="color:var(--text-muted)">Rol:</span>
            @if(auth()->user()->isAdmin())
                <span class="badge badge-warning"><i class="fas fa-crown"></i> Yönetici</span>
            @else
                <span class="badge badge-info"><i class="fas fa-graduation-cap"></i> Öğrenci</span>
            @endif
        </div>
        @if(auth()->user()->student_no)
        <div><span style="color:var(--text-muted)">Öğrenci No:</span> <strong>{{ auth()->user()->student_no }}</strong></div>
        @endif
        @if(auth()->user()->class)
        <div><span style="color:var(--text-muted)">Sınıf:</span> <strong>{{ auth()->user()->class }}</strong></div>
        @endif
        @if(auth()->user()->phone)
        <div><span style="color:var(--text-muted)">Telefon:</span> <strong>{{ auth()->user()->phone }}</strong></div>
        @endif
        <div><span style="color:var(--text-muted)">Kayıt Tarihi:</span> <strong>{{ auth()->user()->created_at->format('d.m.Y') }}</strong></div>
    </div>
</div>
@endsection
