@extends('layouts.app')
@section('title', 'Arşiv - Silinen Kitaplar')
@section('content')
<div class="page-header">
    <div><h1>🗑️ Arşiv (Silinen Kitaplar)</h1><p>Soft delete ile silinen kitapları geri yükleyebilirsiniz.</p></div>
    <a href="{{ route('books.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kitaplara Dön</a>
</div>
<div class="table-container">
    <table class="data-table">
        <thead><tr><th>Kitap</th><th>ISBN</th><th>Kategori</th><th>Silinme Tarihi</th><th>İşlemler</th></tr></thead>
        <tbody>
        @forelse($books as $book)
        <tr>
            <td>
                <div style="font-weight:600">{{ $book->title }}</div>
                <div style="font-size:.75rem;color:var(--text-muted)">{{ $book->author }}</div>
            </td>
            <td><code style="font-size:.75rem;background:var(--bg-primary);padding:.2rem .4rem;border-radius:4px">{{ $book->isbn }}</code></td>
            <td><span class="badge badge-info">{{ $book->category->name ?? '-' }}</span></td>
            <td style="font-size:.8rem">{{ $book->deleted_at->format('d.m.Y H:i') }}</td>
            <td>
                <div style="display:flex;gap:4px">
                    <form method="POST" action="{{ route('books.restore', $book->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-undo"></i> Geri Yükle</button>
                    </form>
                    <form method="POST" action="{{ route('books.forceDelete', $book->id) }}" onsubmit="return confirm('Bu kitap kalıcı olarak silinecek! Emin misiniz?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Kalıcı Sil</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="5"><div class="empty-state"><i class="fas fa-check-circle"></i><p>Arşivde kitap bulunmuyor</p></div></td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="pagination-wrapper">{{ $books->links() }}</div>
@endsection
