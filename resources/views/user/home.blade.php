@extends('user.index')
@section('konten')
<main class="content">
    <div class="main-banner-home flex items-center">
        <div class="container grid grid-cols-1 md:grid-cols-2 gap-2">
            <div></div>
            <div class="text-center md:text-left px-2 ">
                <h2 class="h1 ">Discount 20% For All Orders Over $2000</h2>
                <p>Use coupon code<span class="font-bold">DISCOUNT20</span></p>
                <p>Use coupon DISCOUNT20</p>
                <p></p>
            </div>
        </div>
    </div>
    <div class="pt-3 bg-myimage">
        <div class="page-width">
            <h3 class="mt-3 mb-3 text-center uppercase h5 tracking-widest speakable">New Produk</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                @if ($produkBaru->count())
                    @foreach ($produkBaru as $produkBaru)
                        <div class="listing-tem myProduk">
                            <div class="product-thumbnail-listing">
                                <a href="/produk/{{ $produkBaru->slug }}">
                                    <img style="object-fit: fill" src="{{ $produkBaru->image === 'default' ? asset('defaultProduk.jpg') : asset('storage/' . $produkBaru->image) }}" alt="Image"/>
                                </a>
                            </div>
                            <div class="product-name product-list-name mt-1 mb-025"><a href="/produk/{{ $produkBaru->slug }}"
                                    class="hover:underline h5 speakable"><span>{{ $produkBaru->nama }}</span></a>
                            </div>
                            <div class="product-price-listing">
                                <div>
                                    <span class="sale-price speakable">
                                        Rp.
                                        @if ($produkBaru->harga !== $produkBaru->hargaTotal)
                                            <s>{{ number_format($produkBaru->harga, 0, ',', '.') }}</s> {{ number_format($produkBaru->hargaTotal, 0, ',', '.') }}
                                        @else
                                            {{ number_format($produkBaru->harga, 0, ',', '.') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="pt-3 bg-myimage">
        <div class="page-width">
            <h3 class="mt-3 mb-3 text-center uppercase h5 tracking-widest speakable">Produk Terpopuler</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                @if ($banyakDibeli->count())
                    @foreach ($banyakDibeli as $banyakDibeli)
                        <div class="listing-tem myProduk">
                            <div class="product-thumbnail-listing">
                                <a href="/produk/{{ $banyakDibeli->slug }}">
                                    <img style="object-fit: fill" src="{{ $banyakDibeli->image === 'default' ? asset('defaultProduk.jpg') : asset('storage/' . $banyakDibeli->image) }}" alt="Image"/>
                                </a>
                            </div>
                            <div class="product-name product-list-name mt-1 mb-025"><a href="/produk/{{ $banyakDibeli->slug }}"
                                    class="hover:underline h5 speakable"><span>{{ $banyakDibeli->nama }}</span></a>
                            </div>
                            <div class="product-price-listing">
                                <div>
                                    <span class="sale-price speakable">
                                        Rp.
                                        @if ($banyakDibeli->harga !== $banyakDibeli->hargaTotal)
                                            <s>{{ number_format($banyakDibeli->harga, 0, ',', '.') }}</s> {{ number_format($banyakDibeli->hargaTotal, 0, ',', '.') }}
                                        @else
                                            {{ number_format($banyakDibeli->harga, 0, ',', '.') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
