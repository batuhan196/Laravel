@extends('layouts.app')
@section('title', 'QR Kod Tara')
@section('content')
<div class="page-header">
    <div><h1>📱 QR Kod Tarayıcı</h1><p>Kitap üzerindeki QR kodu kameranızla okutun.</p></div>
</div>
<div class="grid-2">
    <div class="card" style="text-align:center">
        <div id="qr-reader" style="width:100%;max-width:400px;margin:0 auto;border-radius:12px;overflow:hidden"></div>
        <p id="qr-status" style="margin-top:1rem;font-size:.85rem;color:var(--text-muted)">
            <i class="fas fa-camera"></i> Kamerayı QR koda doğrultun...
        </p>
    </div>
    <div class="card">
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem"><i class="fas fa-info-circle" style="color:var(--accent)"></i> Nasıl Kullanılır?</h3>
        <div style="font-size:.85rem;color:var(--text-sec);line-height:1.8">
            <p><strong>1.</strong> Kamera erişim izni verin</p>
            <p><strong>2.</strong> Kitap üzerindeki QR kodu kameraya gösterin</p>
            <p><strong>3.</strong> QR kod okunduğunda otomatik olarak kitap bilgilerine yönlendirileceksiniz</p>
        </div>
        <div style="margin-top:1.5rem;padding:1rem;background:var(--bg-primary);border-radius:10px">
            <h4 style="font-size:.85rem;font-weight:600;margin-bottom:.5rem">💡 İpucu</h4>
            <p style="font-size:.75rem;color:var(--text-muted)">QR kodun iyi aydınlatılmış bir ortamda olması okuma doğruluğunu artırır.</p>
        </div>
        <div style="margin-top:1rem">
            <h4 style="font-size:.85rem;font-weight:600;margin-bottom:.5rem">Manuel Arama</h4>
            <form method="GET" action="{{ route('books.catalog') }}" style="display:flex;gap:8px">
                <input type="text" name="search" class="form-input" placeholder="ISBN veya kitap adı girin...">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const html5QrCode = new Html5Qrcode("qr-reader");
    const config = { fps: 10, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 };

    html5QrCode.start(
        { facingMode: "environment" },
        config,
        (decodedText) => {
            html5QrCode.stop();
            document.getElementById('qr-status').innerHTML =
                '<i class="fas fa-check-circle" style="color:var(--success)"></i> QR kod okundu! Yönlendiriliyor...';
            window.location.href = decodedText;
        },
        (errorMessage) => {}
    ).catch(err => {
        document.getElementById('qr-status').innerHTML =
            '<i class="fas fa-exclamation-circle" style="color:var(--danger)"></i> Kamera erişimi sağlanamadı. Lütfen izin verin.';
    });
});
</script>
@endpush
