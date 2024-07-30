@extends('user.index')
@section('konten')
<main class="content">
    <div class="page-width my-2">
        <span>
            <a href="/" class="text-interactive speakable">Home</a>
            <span> / </span>
        </span>
        <span>
            <a href="/riwayat-pesanan/{{ auth()->user()->username }}" class="text-interactive speakable">Histori Pesanan</a>
            <span> / </span>
        </span>
        <span class="speakable">Detail Pesanan</span>
    </div>
    <div class="page-width grid grid-cols-1 md:grid-cols-2 gap-">
        <div class="">
            <div class="profil-summary md:block speakable">
                <h3>Detail Pesanan - {{ $dataPesanan->invoice }}</h3>
                <p>Status : 
                    @if ($dataPesanan->status == "Pesanan Baru")
                        Belum dibayar
                    @elseif($dataPesanan->status == "Siap Dikirim")
                        Sedang dikemas
                    @elseif($dataPesanan->status == "Dalam Pengiriman")
                        Sedang dikirim
                    @elseif($dataPesanan->status == "Pesanan Selesai")
                        Pesanan selesai
                    @else
                        Pesanan dibatalkan
                    @endif
                </p>
                <p class="speakable">Pembayaran : {{ $dataPesanan->bayar }}</p>
                <div class="checkout-summary-block mt-3">
                    <div>
                        <h4 class="speakable"><i class="fa fa-truck" aria-hidden="true"></i> Informasi Pengiriman</h4>
                        @php
                            $layanan = $dataPesanan->layanan;
                            preg_match('/^(.*?)( - estimasi:|$)/', $layanan, $matches);
                            $layananAwal = $matches[1];
                        @endphp
                        <p class="speakable">{{ $layananAwal }} {{ $dataPesanan->nomor_resi !== null ? ' - ' . $dataPesanan->nomor_resi :'' }}</p>
                    </div>
                    <div class="checkout-summary-block mt-2">
                        <h4 class="speakable"><i class="fa fa-map-marker" aria-hidden="true"></i> Alamat Pengiriman</h4>
                        <p>{{ $dataPesanan->nama_pemesan }}</p>
                        <p>{{ $dataPesanan->telepon }}</p>
                        <p>{{ $dataPesanan->alamat_pengiriman }}</p>
                    </div>
                    <div class="checkout-summary-block mt-2">
                        <h4 class="speakable"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> Produk</h4>
                        <table class="listing">
                            <tbody>
                                @foreach ($dataPesanan->pesanan_detail as $item)
                                    <tr class="speakable">
                                        <td>
                                            <div class="flex justify-start space-x-1 ">
                                                <div class="product-image flex justify-center items-center">
                                                    <img style="width: 80px; height: 80px; object-fit: cover"
                                                        class="self-center"
                                                        src="{{ $item->image_produk === 'default' ? asset('defaultProduk.jpg') : asset('storage/' . $item->image_produk) }}"
                                                        alt="Image" />
                                                </div>
                                                <div class="cart-item-info">
                                                    {{ $item->nama_produk }}
                                                    <div class="cart-item-variant-options mt-0.5">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="flex justify-end full-tabel">
                                            <div class="flex-column">
                                                <div class="text-end">
                                                    x &nbsp; {{ $item->banyak_dibeli }}
                                                </div>
                                                <div>
                                                    Rp. {{ number_format($item->hargaTotal, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table class="listing">
                            <tbody>
                                <tr class="speakable">
                                    <td>
                                        <div class="flex justify-start space-x-1 ">
                                            <div class="flex-column">
                                                <div>
                                                    Subtotal Produk
                                                </div>
                                                <div >
                                                    Ongkos Kirim
                                                </div>
                                                <div >
                                                    Total Pesanan
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="flex justify-end ">
                                        <div class="flex-column">
                                            <div class="text-end">
                                                 Rp. {{ number_format($dataPesanan->total, 0, ',', '.') }}
                                            </div>
                                            <div class="text-end">
                                                 Rp. {{ number_format($dataPesanan->ongkir, 0, ',', '.') }}
                                            </div>
                                            <div>
                                                Rp. {{ number_format($dataPesanan->subtotal, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @if ($dataPesanan->bayar === 'Belum dibayar')
                            <a class="speakable" href="/proses-pembayaran/{{ $dataPesanan->invoice }}" style="width: 100%;background-color: #5bc0de; margin-top: 3rem;padding: 1.5rem;justify-content: center;display: flex;border-radius: 30px;color: #fff">
                                Bayar Sekarang
                            </a>
                        @endif
                        @if ($dataPesanan->status === 'Pesanan Baru' || $dataPesanan->status === 'Siap Dikirim')
                            <form method="POST" action="/batalkan-pesanan" >
                                @csrf
                                <input type="hidden" name="id" value="{{ $dataPesanan->id }}">
                                <button class="speakable" type="submit" style="width: 100%;background-color: #d9534f; margin-top: 1rem;padding: 1.5rem;justify-content: center;display: flex;border-radius: 30px;color: #fff">
                                    Batalkan Pesanan
                                </button>
                            </form>
                        @endif
                        @if ($dataPesanan->status === 'Dalam Pengiriman')
                            <form method="POST" action="/terima-pesanan" >
                                @csrf
                                <input type="hidden" name="id" value="{{ $dataPesanan->id }}">
                                <button class="speakable" type="submit" style="width: 100%;background-color: #5cb85c; margin-top: 1rem;padding: 1.5rem;justify-content: center;display: flex;border-radius: 30px;color: #fff">
                                    Terima Pesanan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
