@extends('user.index')
@section('konten')
<main class="content">
    <div class="page-width my-2">
        <span>
            <a href="/" class="text-interactive speakable">Home</a>
            <span> / </span>
        </span>
        <span class="speakable">Riwayat Pemesanan</span>
    </div>
    <h3 class="mt-3 mb-3 page-width speakable">Riwayat Pemesanan</h3>
    <div class="page-width grid gap-4 grid-cols-1 md:grid-cols-6">
        <div class="col-span-1 md:col-span-3">
            <div id="shopping-cart-items">
                <table class="listing">
                    <div class="mb-1">
                        <div class="flex justify-end items-center">
                            <div class="dropdown-container-status">
                                <div class="dropdown">
                                    <button class="dropdown-button-status" id="dropdown-button">Semua</button>
                                    <div class="dropdown-content-status" id="dropdown-content">
                                        <a href="/riwayat-pesanan/{{ $dataUser->username }}" data-value="semua">Semua</a>
                                        <a href="/riwayat-pesanan/{{ $dataUser->username }}?status=Pesanan Baru" data-value="Pesanan Baru">Belum dibayar</a>
                                        <a href="/riwayat-pesanan/{{ $dataUser->username }}?status=Siap Dikirim" data-value="Siap Dikirim">Sedang dikemas</a>
                                        <a href="/riwayat-pesanan/{{ $dataUser->username }}?status=Dalam Pengiriman" data-value="Dalam Pengiriman"">Dikirim</a>
                                        <a href="/riwayat-pesanan/{{ $dataUser->username }}?status=Pesanan Selesai" data-value="Pesanan Selesai">Selesai</a>
                                        <a href="/riwayat-pesanan/{{ $dataUser->username }}?status=Pesanan Dibatalkan" data-value="Pesanan Dibatalkan">Dibatalkan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </table>
            </div>
        </div>
    </div>
    @if ($dataPesanan->count() < 1) <div class="empty-shopping-cart w-100" style="margin-top:150px">
        <div class="empty-shopping-cart w-100" style="margin-top:150px">
            <div>
                <div class="text-center">
                    <h2 class="speakable">Riwayat Pesanan Kamu</h2>
                </div>
                <div class="mt-2 text-center">
                    <span class="speakable">Kamu Belum Ada Membeli!</span>
                </div>
                <div class="flex justify-center mt-2">
                    <a href="/produk" class="button primary">
                        <span>
                            <span class="flex space-x-1">
                                <span class="self-center speakable">AYO BELANJA DULU</span>
                                <svg class="self-center" style="width:2.5rem;height:2.5rem"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    @else
        <div>
            <div class="cart page-width">
                <div class="cart-page-top"></div>
                <div class="cart-page-middle">
                    <div class="grid gap-4 grid-cols-1 md:grid-cols-6">
                        <div class="col-span-1 md:col-span-3">
                            <div id="shopping-cart-items">
                                <table class="listing">
                                    <tbody>
                                        @foreach ($dataPesanan as $item) 
                                        <tr class="myRiwayat">
                                            <td>
                                                <a class="speakable" href="/detail-pesanan/{{ auth()->user()->username }}/{{ $item->invoice }}">
                                                    <div class="flex justify-start space-x-1 ">
                                                        <div class="product-image flex justify-center items-center">
                                                            <img style="width: 80px; height: 80px; object-fit: cover"
                                                                class="self-center"
                                                                src="{{ $item->pesanan_detail[0]->image_produk === 'default' ? asset('defaultProduk.jpg') : asset('storage/' . $item->pesanan_detail[0]->image_produk) }}"
                                                                alt="Image" />
                                                        </div>
                                                        <div class="cart-item-info">
                                                            {{ $item->pesanan_detail[0]->nama_produk }}
                                                            <div class="cart-item-variant-options mt-0.5">
                                                                <ul>
                                                                    <li><span class="attribute-name">Color:</span> <span>Black</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="flex justify-end full-tabel text-end">
                                                <a class="speakable" href="/detail-pesanan/{{ auth()->user()->username }}/{{ $item->invoice }}">
                                                    <div class="flex-column">
                                                        <div class="text-end">
                                                            x &nbsp; {{ $item->pesanan_detail[0]->banyak_dibeli }}
                                                        </div>
                                                        <div>
                                                            Rp. {{ number_format($item->pesanan_detail[0]->hargaTotal, 0, ',', '.') }}
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="myRiwayat mb-5">
                                            <td>
                                                <div class="flex-column-bawah">
                                                    <div class="speakable">
                                                        {{ $item->pesanan_detail->count() }} produk
                                                    </div>
                                                    <div class="speakable">
                                                        <i class="fa fa-truck" aria-hidden="true"></i> {{ $item->status }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="flex justify-end">
                                                <div class="flex-column-bawah">
                                                    <div>
                                                        &nbsp;
                                                    </div>
                                                    <div class="speakable">
                                                        Total : Rp.{{ number_format($item->subtotal, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{ $dataPesanan->links() }}
            </div>
        </div>
    @endif
</main>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownButton = document.querySelector('#dropdown-button');
        const dropdownContent = document.querySelector('#dropdown-content');
        const urlParams = new URLSearchParams(window.location.search);
        const urlCategory = urlParams.get('status') || 'semua';
        dropdownButton.textContent = urlCategory.charAt(0).toUpperCase() + urlCategory.slice(1);
        dropdownButton.addEventListener('click', function (event) {
            event.stopPropagation();
            dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
        });
        document.addEventListener('click', function () {
            dropdownContent.style.display = 'none';
        });
        dropdownContent.addEventListener('click', function (event) {
            event.stopPropagation();
        });
        dropdownContent.addEventListener('click', function (event) {
            const target = event.target;
            if (target.tagName === 'A') {
                const categoryValue = target.dataset.value;
                const newUrl = new URL(window.location.href);
                newUrl.searchParams.set('status', categoryValue);
                window.location.href = newUrl.toString();

                dropdownContent.style.display = 'none';
            }
        });
    });
</script>
@endsection
