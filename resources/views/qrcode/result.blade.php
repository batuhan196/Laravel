@extends('layouts.app')
@section('title', $book->title . ' - QR Bilgi')
@section('content')
<div class="page-header">
    <div><h1>📖 {{ $book->title }}</h1><p>QR kod ile erişilen kitap bilgileri</p></div>
    <a href="{{ route('qr.scan') }}" class="btn btn-secondary"><i class="fas fa-qrcode"></i> Tekrar Tara</a>
</div>
<div class="grid-2">
    <div class="card">
        <div style="display:flex;gap:20px">
            <div style="width:100px;height:140px;background:var(--bg-primary);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" style="width:100%;height:100%;object-fit:cover" alt="">
                @else
                    <i class="fas fa-book" style="font-size:2.5rem;color:var(--accent)"></i>
                @endif
            </div>
            <div>
                <h2 style="font-size:1.2rem;font-weight:800;margin-bottom:.5rem">{{ $book->title }}</h2>
                <p style="color:var(--text-sec);margin-bottom:.75rem">{{ $book->author }}</p>
                <div style="font-size:.8rem;display:flex;flex-direction:column;gap:.4rem">
                    <div><i class="fas fa-barcode" style="color:var(--accent);width:20px"></i> {{ $book->isbn }}</div>
                    <div><i class="fas fa-folder" style="color:var(--accent);width:20px"></i> {{ $book->category->name ?? '-' }}</div>
                    <div><i class="fas fa-building" style="color:var(--accent);width:20px"></i> {{ $book->publisher ?? '-' }}</div>
                    <div><i class="fas fa-map-marker" style="color:var(--accent);width:20px"></i> Raf: {{ $book->shelf_no ?? '-' }}</div>
                </div>
                <div style="margin-top:1rem">
                    @if($book->isAvailable())
                        <span class="badge badge-success" style="font-size:.8rem;padding:.35rem .8rem"><i class="fas fa-check-circle"></i> {{ $book->available }}/{{ $book->quantity }} Mevcut</span>
                    @else
                        <span class="badge badge-danger" style="font-size:.8rem;padding:.35rem .8rem"><i class="fas fa-times-circle"></i> Şu anda mevcut değil</span>
                    @endif
                </div>
            </div>
        </div>
        @if($book->description)
        <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border)">
            <p style="font-size:.8rem;color:var(--text-sec);line-height:1.6">{{ $book->description }}</p>
        </div>
        @endif
    </div>
    <div class="card" style="text-align:center">
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem">QR Kod</h3>
        <div style="background:#fff;display:inline-block;padding:20px;border-radius:12px">
            <div id="qrcode"></div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
new QRCode(document.getElementById("qrcode"), {
    text: "{{ $qrUrl }}",
    width: 250,
    height: 250,
    colorDark: "#000000",
    colorLight: "#ffffff",
});
</script>
@endpush
