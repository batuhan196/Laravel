@extends('layouts.app')
@section('title', 'Öğrenci Paneli')
@section('content')
<div class="page-header">
    <div>
        <h1>Hoş Geldin, {{ auth()->user()->name }} 👋</h1>
        <p>Kütüphane durumun aşağıda özetleniyor.</p>
    </div>
</div>

<div class="grid-3">
    <div class="stat-card animate-in">
        <div class="stat-icon" style="background:rgba(59,130,246,0.15);color:var(--info)"><i class="fas fa-book-reader"></i></div>
        <div class="stat-value">{{ $myLoans->count() }}</div>
        <div class="stat-label">Aktif Ödünç</div>
    </div>
    <div class="stat-card animate-in delay-1">
        <div class="stat-icon" style="background:rgba(239,68,68,0.15);color:var(--danger)"><i class="fas fa-exclamation-circle"></i></div>
        <div class="stat-value">{{ $myOverdue->count() }}</div>
        <div class="stat-label">Gecikmiş İade</div>
    </div>
    <div class="stat-card animate-in delay-2">
        <div class="stat-icon" style="background:rgba(16,185,129,0.15);color:var(--success)"><i class="fas fa-check-circle"></i></div>
        <div class="stat-value">{{ $myHistory->count() }}</div>
        <div class="stat-label">Tamamlanan</div>
    </div>
</div>

<!-- Aktif Ödünçler -->
<div class="card" style="margin-top:1.5rem">
    <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem"><i class="fas fa-book-open" style="color:var(--accent);margin-right:8px"></i>Aktif Ödünçlerim</h3>
    @forelse($myLoans as $loan)
    <div style="display:flex;align-items:center;gap:16px;padding:.75rem 0;{{ !$loop->last ? 'border-bottom:1px solid var(--border)' : '' }}">
        <div style="width:50px;height:65px;background:var(--bg-primary);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
            @if($loan->book->cover_image)
                <img src="{{ asset('storage/' . $loan->book->cover_image) }}" style="width:100%;height:100%;object-fit:cover;border-radius:8px" alt="">
            @else
                <i class="fas fa-book" style="color:var(--accent)"></i>
            @endif
        </div>
        <div style="flex:1">
            <div style="font-weight:600;font-size:.85rem">{{ $loan->book->title }}</div>
            <div style="font-size:.75rem;color:var(--text-muted)">{{ $loan->book->author }}</div>
            <div style="font-size:.7rem;color:var(--text-muted);margin-top:.25rem">
                <i class="fas fa-calendar"></i> İade: {{ $loan->due_date->format('d.m.Y') }}
                @if($loan->due_date->isPast())
                    <span class="badge badge-danger" style="margin-left:4px"><i class="fas fa-clock"></i> {{ intval($loan->due_date->diffInDays(now())) }} gün gecikmiş</span>
                @else
                    <span class="badge badge-success" style="margin-left:4px">{{ intval($loan->due_date->diffInDays(now())) }} gün kaldı</span>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state"><i class="fas fa-inbox"></i><p>Aktif ödünç kitabınız bulunmuyor</p></div>
    @endforelse
</div>

<!-- Hızlı Erişim -->
<div class="grid-3" style="margin-top:1.5rem">
    <a href="{{ route('books.catalog') }}" class="card" style="text-decoration:none;text-align:center">
        <i class="fas fa-search" style="font-size:2rem;color:var(--accent);margin-bottom:.5rem;display:block"></i>
        <div style="font-weight:700;font-size:.85rem">Katalog</div>
        <div style="font-size:.7rem;color:var(--text-muted)">Kitapları keşfet</div>
    </a>
    <a href="{{ route('qr.scan') }}" class="card" style="text-decoration:none;text-align:center">
        <i class="fas fa-qrcode" style="font-size:2rem;color:var(--success);margin-bottom:.5rem;display:block"></i>
        <div style="font-weight:700;font-size:.85rem">QR Tara</div>
        <div style="font-size:.7rem;color:var(--text-muted)">QR kod okut</div>
    </a>
    <a href="{{ route('loans.my') }}" class="card" style="text-decoration:none;text-align:center">
        <i class="fas fa-history" style="font-size:2rem;color:var(--info);margin-bottom:.5rem;display:block"></i>
        <div style="font-weight:700;font-size:.85rem">Geçmiş</div>
        <div style="font-size:.7rem;color:var(--text-muted)">Ödünç geçmişim</div>
    </a>
</div>
@endsection
