@extends('layouts.app')
@section('title', 'Kategoriler')
@section('content')
<div class="page-header">
    <div><h1>📁 Kategoriler</h1><p>Kitap kategorilerini yönetin.</p></div>
    <a href="{{ route('categories.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Yeni Kategori</a>
</div>
<div class="grid-3">
    @forelse($categories as $cat)
    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:start">
            <div>
                <div style="font-size:2rem;margin-bottom:.5rem">{{ $cat->icon ?? '📂' }}</div>
                <h3 style="font-size:1rem;font-weight:700">{{ $cat->name }}</h3>
                <p style="font-size:.75rem;color:var(--text-muted);margin-top:.25rem">{{ $cat->description ?? 'Açıklama yok' }}</p>
                <div style="margin-top:.75rem"><span class="badge badge-info"><i class="fas fa-book"></i> {{ $cat->books_count }} kitap</span></div>
            </div>
            <div style="display:flex;gap:4px">
                <a href="{{ route('categories.edit', $cat) }}" class="btn btn-sm btn-secondary"><i class="fas fa-edit"></i></a>
                <form method="POST" action="{{ route('categories.destroy', $cat) }}" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1" class="empty-state"><i class="fas fa-folder-open"></i><p>Henüz kategori eklenmemiş</p></div>
    @endforelse
</div>
<div class="pagination-wrapper">{{ $categories->links() }}</div>
@endsection
