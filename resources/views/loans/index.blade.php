@extends('layouts.app')
@section('title', 'Ödünç İşlemleri')
@section('content')
<div class="page-header">
    <div><h1>🔄 Ödünç İşlemleri</h1><p>Kitap ödünç verme ve iade işlemlerini yönetin.</p></div>
    <a href="{{ route('loans.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Yeni Ödünç</a>
</div>
<form method="GET" class="search-bar">
    <div class="search-input-wrapper">
        <i class="fas fa-search"></i>
        <input type="text" name="search" placeholder="Öğrenci adı, numara veya kitap ara..." value="{{ request('search') }}">
    </div>
    <select name="status" class="form-select" style="width:auto;min-width:140px">
        <option value="">Tüm Durumlar</option>
        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Gecikmiş</option>
        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>İade Edildi</option>
    </select>
    <button type="submit" class="btn btn-secondary"><i class="fas fa-filter"></i> Filtrele</button>
</form>
<div class="table-container">
    <table class="data-table">
        <thead><tr><th>Öğrenci</th><th>Kitap</th><th>Alınma</th><th>İade Tarihi</th><th>Durum</th><th>İşlem</th></tr></thead>
        <tbody>
        @forelse($loans as $loan)
        <tr>
            <td>
                <div style="font-weight:600">{{ $loan->user->name ?? '-' }}</div>
                <div style="font-size:.7rem;color:var(--text-muted)">{{ $loan->user->student_no ?? '-' }}</div>
            </td>
            <td>
                <div style="font-weight:500">{{ $loan->book->title ?? '-' }}</div>
                <div style="font-size:.7rem;color:var(--text-muted)">{{ $loan->book->author ?? '-' }}</div>
            </td>
            <td style="font-size:.8rem">{{ $loan->loan_date->format('d.m.Y') }}</td>
            <td style="font-size:.8rem">
                @if($loan->return_date)
                    {{ $loan->return_date->format('d.m.Y') }}
                @else
                    {{ $loan->due_date->format('d.m.Y') }}
                    @if($loan->due_date->isPast())
                        <div style="font-size:.65rem;color:var(--danger)">{{ intval($loan->due_date->diffInDays(now())) }} gün gecikmiş</div>
                    @endif
                @endif
            </td>
            <td>
                @if($loan->status === 'returned')
                    <span class="badge badge-success"><i class="fas fa-check"></i> İade Edildi</span>
                @elseif($loan->status === 'active' && $loan->due_date->isPast())
                    <span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> Gecikmiş</span>
                @else
                    <span class="badge badge-warning"><i class="fas fa-clock"></i> Aktif</span>
                @endif
            </td>
            <td>
                @if($loan->status === 'active')
                <form method="POST" action="{{ route('loans.return', $loan->id) }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-undo"></i> İade Al</button>
                </form>
                @else
                <span style="font-size:.75rem;color:var(--text-muted)">Tamamlandı</span>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="6"><div class="empty-state"><i class="fas fa-exchange-alt"></i><p>Henüz ödünç kaydı yok</p></div></td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="pagination-wrapper">{{ $loans->withQueryString()->links() }}</div>
@endsection
