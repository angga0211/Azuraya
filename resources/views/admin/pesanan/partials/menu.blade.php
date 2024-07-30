<div class="container-fluid mb-2 p-0">
    <a class="speakable" href="/admin/pesanan" class="btn {{ $currentStatus == 'Semua Pesanan' ? 'btn-primary' : 'btn-secondary' }}">
        Semua Pesanan ({{ $jumlahPesanan['semua'] }})
    </a>
    <a class="speakable" href="/admin/pesanan?status=Pesanan Baru" class="btn {{ $currentStatus == 'Pesanan Baru' ? 'btn-primary' : 'btn-secondary' }}">
        Pesanan Baru ({{ $jumlahPesanan['baru'] }})
    </a>
    <a class="speakable" href="/admin/pesanan?status=Siap Dikirim" class="btn {{ $currentStatus == 'Siap Dikirim' ? 'btn-primary' : 'btn-secondary' }}">
        Siap Dikirim ({{ $jumlahPesanan['siap'] }})
    </a>
    <a class="speakable" href="/admin/pesanan?status=Dalam Pengiriman" class="btn {{ $currentStatus == 'Dalam Pengiriman' ? 'btn-primary' : 'btn-secondary' }}">
        Dalam Pengiriman ({{ $jumlahPesanan['kirim'] }})
    </a>
    <a class="speakable" href="/admin/pesanan?status=Pesanan Selesai" class="btn {{ $currentStatus == 'Pesanan Selesai' ? 'btn-primary' : 'btn-secondary' }}">
        Pesanan Selesai ({{ $jumlahPesanan['selesai'] }})
    </a>
    <a class="speakable" href="/admin/pesanan?status=Pesanan Dibatalkan" class="btn {{ $currentStatus == 'Pesanan Dibatalkan' ? 'btn-primary' : 'btn-secondary' }}">
        Dibatalkan ({{ $jumlahPesanan['batal'] }})
    </a>
</div>
