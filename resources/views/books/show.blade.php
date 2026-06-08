@extends('layouts.app')
@section('title', $book->title)
@section('content')
<div class="page-header">
    <div><h1>📖 {{ $book->title }}</h1><p>Kitap detayları ve QR kodu</p></div>
    <div style="display:flex;gap:8px">
        <a href="{{ route('books.edit', $book) }}" class="btn btn-secondary"><i class="fas fa-edit"></i> Düzenle</a>
        <a href="{{ route('books.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Geri</a>
    </div>
</div>
<div class="grid-2">
    <div class="card">
        <div style="display:flex;gap:20px">
            <div style="width:120px;height:170px;background:var(--bg-primary);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" style="width:100%;height:100%;object-fit:cover" alt="">
                @else
                    <i class="fas fa-book" style="font-size:3rem;color:var(--accent)"></i>
                @endif
            </div>
            <div style="flex:1">
                <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:.5rem">{{ $book->title }}</h2>
                <p style="color:var(--text-sec);font-size:.9rem;margin-bottom:1rem">{{ $book->author }}</p>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;font-size:.8rem">
                    <div><span style="color:var(--text-muted)">ISBN:</span> <strong>{{ $book->isbn }}</strong></div>
                    <div><span style="color:var(--text-muted)">Kategori:</span> <span class="badge badge-info">{{ $book->category->name ?? '-' }}</span></div>
                    <div><span style="color:var(--text-muted)">Yayınevi:</span> {{ $book->publisher ?? '-' }}</div>
                    <div><span style="color:var(--text-muted)">Sayfa:</span> {{ $book->page_count ?? '-' }}</div>
                    <div><span style="color:var(--text-muted)">Raf:</span> {{ $book->shelf_no ?? '-' }}</div>
                    <div><span style="color:var(--text-muted)">Durum:</span>
                        @if($book->available > 0)<span class="badge badge-success">{{ $book->available }}/{{ $book->quantity }} Mevcut</span>
                        @else<span class="badge badge-danger">Tükendi</span>@endif
                    </div>
                </div>
            </div>
        </div>
        @if($book->description)
        <div style="margin-top:1.25rem;padding-top:1rem;border-top:1px solid var(--border)">
            <h4 style="font-size:.85rem;font-weight:600;margin-bottom:.5rem">Açıklama</h4>
            <p style="font-size:.8rem;color:var(--text-sec);line-height:1.6">{{ $book->description }}</p>
        </div>
        @endif
    </div>
    <div class="card" style="text-align:center">
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem"><i class="fas fa-qrcode" style="color:var(--accent)"></i> QR Kod</h3>
        <div style="background:#fff;display:inline-block;padding:20px;border-radius:12px;margin-bottom:1rem">
            <div id="qrcode"></div>
        </div>
        <p style="font-size:.75rem;color:var(--text-muted)">Bu QR kodu kitabın üzerine yapıştırarak hızlı erişim sağlayabilirsiniz.</p>
        <button onclick="window.print()" class="btn btn-secondary" style="margin-top:1rem"><i class="fas fa-print"></i> QR Kodu Yazdır</button>
    </div>
</div>

<!-- Ödünç Geçmişi -->
<div class="card" style="margin-top:1.5rem">
    <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem"><i class="fas fa-history" style="color:var(--accent)"></i> Ödünç Geçmişi</h3>
    @if($book->loans->count() > 0)
    <table class="data-table">
        <thead><tr><th>Öğrenci</th><th>Alınma</th><th>İade Tarihi</th><th>Durum</th></tr></thead>
        <tbody>
        @foreach($book->loans as $loan)
        <tr>
            <td>{{ $loan->user->name ?? '-' }}</td>
            <td>{{ $loan->loan_date->format('d.m.Y') }}</td>
            <td>{{ $loan->return_date ? $loan->return_date->format('d.m.Y') : $loan->due_date->format('d.m.Y') }}</td>
            <td>
                @if($loan->status === 'returned')<span class="badge badge-success">İade Edildi</span>
                @elseif($loan->due_date->isPast())<span class="badge badge-danger">Gecikmiş</span>
                @else<span class="badge badge-warning">Aktif</span>@endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state"><i class="fas fa-inbox"></i><p>Bu kitap henüz ödünç verilmemiş</p></div>
    @endif
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
new QRCode(document.getElementById("qrcode"), {
    text: "{{ $qrUrl }}",
    width: 200,
    height: 200,
    colorDark: "#000000",
    colorLight: "#ffffff",
});
</script>
@endpush

