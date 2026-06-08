@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
<div class="grid-4 animate-in">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(245,158,11,0.15);color:var(--accent)"><i class="fas fa-book"></i></div>
        <div class="stat-value">{{ $totalBooks }}</div>
        <div class="stat-label">Toplam Kitap</div>
    </div>
    <div class="stat-card delay-1 animate-in">
        <div class="stat-icon" style="background:rgba(59,130,246,0.15);color:var(--info)"><i class="fas fa-users"></i></div>
        <div class="stat-value">{{ $totalUsers }}</div>
        <div class="stat-label">Toplam Öğrenci</div>
    </div>
    <div class="stat-card delay-2 animate-in">
        <div class="stat-icon" style="background:rgba(16,185,129,0.15);color:var(--success)"><i class="fas fa-exchange-alt"></i></div>
        <div class="stat-value">{{ $activeLoans }}</div>
        <div class="stat-label">Aktif Ödünç</div>
    </div>
    <div class="stat-card delay-3 animate-in">
        <div class="stat-icon" style="background:rgba(239,68,68,0.15);color:var(--danger)"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="stat-value">{{ $overdueLoans }}</div>
        <div class="stat-label">Gecikmiş İade</div>
    </div>
</div>

<div class="grid-2" style="margin-top:1.5rem">
    <!-- Son İşlemler -->
    <div class="card animate-in delay-2">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
            <h3 style="font-size:1rem;font-weight:700"><i class="fas fa-clock" style="color:var(--accent);margin-right:8px"></i>Son İşlemler</h3>
            <a href="{{ route('loans.index') }}" class="btn btn-sm btn-secondary">Tümünü Gör</a>
        </div>
        @forelse($recentLoans as $loan)
        <div style="display:flex;align-items:center;gap:12px;padding:.6rem 0;border-bottom:1px solid var(--border)">
            <div style="width:36px;height:36px;background:linear-gradient(135deg,var(--accent),#ef4444);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;color:#fff;flex-shrink:0">
                {{ strtoupper(substr($loan->user->name ?? 'X', 0, 2)) }}
            </div>
            <div style="flex:1;min-width:0">
                <div style="font-size:.8rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $loan->user->name ?? '-' }}</div>
                <div style="font-size:.7rem;color:var(--text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $loan->book->title ?? '-' }}</div>
            </div>
            <div>
                @if($loan->status === 'active' && $loan->due_date->isPast())
                    <span class="badge badge-danger"><i class="fas fa-clock"></i> Gecikmiş</span>
                @elseif($loan->status === 'active')
                    <span class="badge badge-warning"><i class="fas fa-book-reader"></i> Aktif</span>
                @else
                    <span class="badge badge-success"><i class="fas fa-check"></i> İade</span>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state"><i class="fas fa-inbox"></i><p>Henüz işlem yok</p></div>
        @endforelse
    </div>

    <!-- Popüler Kitaplar -->
    <div class="card animate-in delay-3">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
            <h3 style="font-size:1rem;font-weight:700"><i class="fas fa-fire" style="color:#ef4444;margin-right:8px"></i>En Çok Okunan</h3>
            <a href="{{ route('books.index') }}" class="btn btn-sm btn-secondary">Tüm Kitaplar</a>
        </div>
        @forelse($popularBooks as $i => $book)
        <div style="display:flex;align-items:center;gap:12px;padding:.6rem 0;{{ !$loop->last ? 'border-bottom:1px solid var(--border)' : '' }}">
            <div style="width:28px;height:28px;background:{{ $i < 3 ? 'var(--accent)' : 'var(--border)' }};border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:800;color:{{ $i < 3 ? '#000' : 'var(--text-sec)' }};flex-shrink:0">{{ $i + 1 }}</div>
            <div style="flex:1;min-width:0">
                <div style="font-size:.8rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $book->title }}</div>
                <div style="font-size:.7rem;color:var(--text-muted)">{{ $book->author }}</div>
            </div>
            <div style="font-size:.75rem;color:var(--text-muted)">{{ $book->loans_count }} kez</div>
        </div>
        @empty
        <div class="empty-state"><i class="fas fa-book"></i><p>Henüz veri yok</p></div>
        @endforelse
    </div>
</div>

<!-- Hızlı Erişim -->
<div class="grid-4" style="margin-top:1.5rem">
    <a href="{{ route('books.create') }}" class="card animate-in delay-3" style="text-decoration:none;text-align:center">
        <i class="fas fa-plus-circle" style="font-size:2rem;color:var(--accent);margin-bottom:.75rem;display:block"></i>
        <div style="font-weight:700;font-size:.9rem">Kitap Ekle</div>
        <div style="font-size:.7rem;color:var(--text-muted);margin-top:.25rem">Yeni kitap kaydet</div>
    </a>
    <a href="{{ route('loans.create') }}" class="card animate-in delay-3" style="text-decoration:none;text-align:center">
        <i class="fas fa-hand-holding" style="font-size:2rem;color:var(--info);margin-bottom:.75rem;display:block"></i>
        <div style="font-weight:700;font-size:.9rem">Ödünç Ver</div>
        <div style="font-size:.7rem;color:var(--text-muted);margin-top:.25rem">Kitap ödünç ver</div>
    </a>
    <a href="{{ route('qr.scan') }}" class="card animate-in delay-4" style="text-decoration:none;text-align:center">
        <i class="fas fa-qrcode" style="font-size:2rem;color:var(--success);margin-bottom:.75rem;display:block"></i>
        <div style="font-weight:700;font-size:.9rem">QR Tara</div>
        <div style="font-size:.7rem;color:var(--text-muted);margin-top:.25rem">QR kod okut</div>
    </a>
    <a href="{{ route('users.create') }}" class="card animate-in delay-4" style="text-decoration:none;text-align:center">
        <i class="fas fa-user-plus" style="font-size:2rem;color:var(--warning);margin-bottom:.75rem;display:block"></i>
        <div style="font-weight:700;font-size:.9rem">Kullanıcı Ekle</div>
        <div style="font-size:.7rem;color:var(--text-muted);margin-top:.25rem">Yeni kullanıcı</div>
    </a>
</div>
@endsection
