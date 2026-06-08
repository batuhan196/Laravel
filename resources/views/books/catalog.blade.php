@extends('layouts.app')
@section('title', 'Katalog')
@section('content')
<div class="page-header">
    <div><h1>📚 Kitap Kataloğu</h1><p>Kütüphanedeki mevcut kitapları keşfedin.</p></div>
</div>
<form method="GET" class="search-bar">
    <div class="search-input-wrapper">
        <i class="fas fa-search"></i>
        <input type="text" name="search" placeholder="Kitap veya yazar ara..." value="{{ request('search') }}">
    </div>
    <select name="category_id" class="form-select" style="width:auto;min-width:160px">
        <option value="">Tüm Kategoriler</option>
        @foreach($categories as $cat)
        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Ara</button>
</form>
<div class="grid-3">
    @forelse($books as $book)
    <div class="card" style="padding:0;overflow:hidden">
        <div style="height:140px;background:linear-gradient(135deg,var(--bg-primary),var(--bg-card));display:flex;align-items:center;justify-content:center;position:relative">
            @if($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" style="width:100%;height:100%;object-fit:cover" alt="">
            @else
                <i class="fas fa-book" style="font-size:3rem;color:var(--accent);opacity:.3"></i>
            @endif
            <div style="position:absolute;top:10px;right:10px">
                <span class="badge badge-success"><i class="fas fa-check"></i> {{ $book->available }} mevcut</span>
            </div>
        </div>
        <div style="padding:1.25rem">
            <span class="badge badge-info" style="margin-bottom:.5rem">{{ $book->category->name ?? '-' }}</span>
            <h3 style="font-size:.95rem;font-weight:700;margin-bottom:.25rem">{{ $book->title }}</h3>
            <p style="font-size:.8rem;color:var(--text-muted);margin-bottom:.5rem">{{ $book->author }}</p>
            @if($book->description)
            <p style="font-size:.75rem;color:var(--text-muted);line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">{{ $book->description }}</p>
            @endif
            <div style="margin-top:.75rem;display:flex;gap:6px;font-size:.7rem;color:var(--text-muted)">
                @if($book->page_count)<span><i class="fas fa-file-alt"></i> {{ $book->page_count }} sayfa</span>@endif
                @if($book->shelf_no)<span><i class="fas fa-map-marker-alt"></i> {{ $book->shelf_no }}</span>@endif
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1" class="empty-state"><i class="fas fa-search"></i><p>Aramanıza uygun kitap bulunamadı</p></div>
    @endforelse
</div>
<div class="pagination-wrapper">{{ $books->withQueryString()->links() }}</div>
@endsection
