@extends('layouts.app')
@section('title', 'Kullanıcılar')
@section('content')
<div class="page-header">
    <div><h1>👥 Kullanıcı Yönetimi</h1><p>Tüm kullanıcıları görüntüleyin ve yönetin.</p></div>
    <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Yeni Kullanıcı</a>
</div>
<form method="GET" class="search-bar">
    <div class="search-input-wrapper">
        <i class="fas fa-search"></i>
        <input type="text" name="search" placeholder="Ad, e-posta veya öğrenci no ara..." value="{{ request('search') }}">
    </div>
    <select name="role" class="form-select" style="width:auto;min-width:130px">
        <option value="">Tüm Roller</option>
        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Yönetici</option>
        <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Öğrenci</option>
    </select>
    <button type="submit" class="btn btn-secondary"><i class="fas fa-filter"></i> Filtrele</button>
</form>
<div class="table-container">
    <table class="data-table">
        <thead><tr><th>Kullanıcı</th><th>E-posta</th><th>Öğrenci No</th><th>Sınıf</th><th>Rol</th><th>İşlemler</th></tr></thead>
        <tbody>
        @forelse($users as $user)
        <tr>
            <td>
                <div style="display:flex;align-items:center;gap:10px">
                    <div style="width:36px;height:36px;background:linear-gradient(135deg,var(--accent),#ef4444);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;color:#fff;flex-shrink:0">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div style="font-weight:600">{{ $user->name }}</div>
                </div>
            </td>
            <td style="font-size:.8rem">{{ $user->email }}</td>
            <td>{{ $user->student_no ?? '-' }}</td>
            <td>{{ $user->class ?? '-' }}</td>
            <td>
                @if($user->isAdmin())
                    <span class="badge badge-warning"><i class="fas fa-crown"></i> Yönetici</span>
                @else
                    <span class="badge badge-info"><i class="fas fa-graduation-cap"></i> Öğrenci</span>
                @endif
            </td>
            <td>
                <div style="display:flex;gap:4px">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-secondary"><i class="fas fa-edit"></i></a>
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="6"><div class="empty-state"><i class="fas fa-users"></i><p>Kullanıcı bulunamadı</p></div></td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="pagination-wrapper">{{ $users->withQueryString()->links() }}</div>
@endsection
