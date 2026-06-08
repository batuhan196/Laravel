@extends('layouts.app')
@section('title', 'Ödünçlerim')
@section('content')
<div class="page-header">
    <div><h1>📖 Ödünçlerim</h1><p>Aktif ve geçmiş ödünç kayıtlarınız.</p></div>
</div>
<h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem"><i class="fas fa-book-reader" style="color:var(--accent)"></i> Aktif Ödünçler</h3>
@forelse($activeLoans as $loan)
<div class="card" style="margin-bottom:1rem">
    <div style="display:flex;align-items:center;gap:16px">
        <div style="width:50px;height:65px;background:var(--bg-primary);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <i class="fas fa-book" style="color:var(--accent)"></i>
        </div>
        <div style="flex:1">
            <div style="font-weight:700;font-size:.9rem">{{ $loan->book->title ?? '-' }}</div>
            <div style="font-size:.8rem;color:var(--text-muted)">{{ $loan->book->author ?? '-' }}</div>
            <div style="font-size:.75rem;color:var(--text-muted);margin-top:.25rem">
                Alınma: {{ $loan->loan_date->format('d.m.Y') }} | İade: {{ $loan->due_date->format('d.m.Y') }}
            </div>
        </div>
        <div>
            @if($loan->due_date->isPast())
                <span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> {{ intval($loan->due_date->diffInDays(now())) }} gün gecikmiş</span>
            @else
                <span class="badge badge-success"><i class="fas fa-clock"></i> {{ intval(now()->diffInDays($loan->due_date)) }} gün kaldı</span>
            @endif
        </div>
    </div>
</div>
@empty
<div class="card"><div class="empty-state"><i class="fas fa-check-circle"></i><p>Aktif ödünç kitabınız bulunmuyor.</p></div></div>
@endforelse

<h3 style="font-size:1rem;font-weight:700;margin:2rem 0 1rem"><i class="fas fa-history" style="color:var(--info)"></i> Geçmiş</h3>
<div class="table-container">
    <table class="data-table">
        <thead><tr><th>Kitap</th><th>Alınma</th><th>İade</th><th>Durum</th></tr></thead>
        <tbody>
        @forelse($history as $loan)
        <tr>
            <td><div style="font-weight:500">{{ $loan->book->title ?? '-' }}</div></td>
            <td>{{ $loan->loan_date->format('d.m.Y') }}</td>
            <td>{{ $loan->return_date ? $loan->return_date->format('d.m.Y') : '-' }}</td>
            <td><span class="badge badge-success"><i class="fas fa-check"></i> İade Edildi</span></td>
        </tr>
        @empty
        <tr><td colspan="4"><div class="empty-state" style="padding:1.5rem"><p>Henüz geçmiş ödünç kaydınız yok.</p></div></td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="pagination-wrapper">{{ $history->links() }}</div>
@endsection
