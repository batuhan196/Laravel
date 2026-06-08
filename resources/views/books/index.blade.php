@extends('layouts.app')
@section('title', 'Kitaplar')
@section('content')
<div class="page-header">
    <div><h1>📚 Kitap Yönetimi</h1><p>Tüm kitapları görüntüleyin, ekleyin ve düzenleyin.</p></div>
    <a href="{{ route('books.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Yeni Kitap</a>
</div>

<form method="GET" class="search-bar">
    <div class="search-input-wrapper">
        <i class="fas fa-search"></i>
        <input type="text" name="search" placeholder="Kitap, yazar veya ISBN ara..." value="{{ request('search') }}">
    </div>
    <select name="category_id" class="form-select" style="width:auto;min-width:160px">
        <option value="">Tüm Kategoriler</option>
        @foreach($categories as $cat)
        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>
    <select name="availability" class="form-select" style="width:auto;min-width:130px">
        <option value="">Tüm Durum</option>
        <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Mevcut</option>
        <option value="unavailable" {{ request('availability') == 'unavailable' ? 'selected' : '' }}>Tükendi</option>
    </select>
    <button type="submit" class="btn btn-secondary"><i class="fas fa-filter"></i> Filtrele</button>
</form>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Kitap</th>
                <th>ISBN</th>
                <th>Kategori</th>
                <th>Raf</th>
                <th>Adet</th>
                <th>Durum</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:12px">
                        <div style="width:40px;height:55px;background:var(--bg-primary);border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" style="width:100%;height:100%;object-fit:cover" alt="">
                            @else
                                <i class="fas fa-book" style="color:var(--accent);font-size:.8rem"></i>
                            @endif
                        </div>
                        <div>
                            <div style="font-weight:600">{{ $book->title }}</div>
                            <div style="font-size:.75rem;color:var(--text-muted)">{{ $book->author }}</div>
                        </div>
                    </div>
                </td>
                <td><code style="font-size:.75rem;background:var(--bg-primary);padding:.2rem .4rem;border-radius:4px">{{ $book->isbn }}</code></td>
                <td><span class="badge badge-info">{{ $book->category->name ?? '-' }}</span></td>
                <td>{{ $book->shelf_no ?? '-' }}</td>
                <td>{{ $book->available }}/{{ $book->quantity }}</td>
                <td>
                    @if($book->available > 0)
                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Mevcut</span>
                    @else
                        <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Tükendi</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex;gap:4px">
                        <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-secondary" title="Detay"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-secondary" title="Düzenle"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('books.destroy', $book) }}" onsubmit="return confirm('Bu kitabı arşive taşımak istediğinize emin misiniz?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Sil"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7"><div class="empty-state"><i class="fas fa-book"></i><p>Henüz kitap eklenmemiş</p></div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination-wrapper">{{ $books->withQueryString()->links() }}</div>
@endsection
