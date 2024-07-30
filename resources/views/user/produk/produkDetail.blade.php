@extends('user.index')

@section('konten')
<main class="content">
    <div class="page-width my-2">
        <span><a href="/" class="text-interactive speakable">Home</a><span> / </span></span>
        <span><a href="/produk" class="text-interactive speakable">Produk</a><span> / </span></span>
        <span class="speakable">{{ $dataProduk->nama }}</span>
    </div>
    <div class="product-detail">
        <div class="product-page-top"></div>
        
        <div class="product-page-middle page-width">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                <div>
                    <div class="product-single-media">
                        <div id="product-current-image" class="product-image product-single-page-image flex justify-center items-center" style="background:#f6f6f6">
                            <img src="{{ $dataProduk->image === 'default' ? asset('defaultProduk.jpg') : asset('storage/' . $dataProduk->image) }}" alt="Nike air zoom pegasus 35" class="self-center" />
                        </div>
                    </div>
                </div>
                <div>
                    <div class="flex flex-col gap-1">
                        <h1 class="product-single-name speakable">{{ $dataProduk->nama }}</h1>
                        <h4 class="product-single-price">
                            <div>
                                <span class="sale-price speakable">
                                    Rp.
                                        @if ($dataProduk->harga !== $dataProduk->hargaTotal)
                                            <s>{{ number_format($dataProduk->harga, 0, ',', '.') }}</s> {{ number_format($dataProduk->hargaTotal, 0, ',', '.') }}
                                        @else
                                            {{ number_format($dataProduk->harga, 0, ',', '.') }}
                                        @endif
                                </span>
                            </div>
                        </h4>
                        <div class="product-single-sku text-textSubdued speakable"><span>Stok</span><span> : </span>{{ $dataProduk->stok }}</div>
                    </div>
                    
                    <form id="productForm" action="/tambah-ke-keranjang" method="POST">
                        @csrf
                        <div class="add-to-cart mt-2">
                            <input type="hidden" name="produk_id" value="{{ $dataProduk->id }}">
                            <input class="btn-qty" type="number" name="quantity" placeholder="Quantity" required min="1" max="10" value="1">
                            <div class="variant variant-container grid grid-cols-1 gap-1 mt-2">
                                <div><input type="hidden" name="variant_options[0][attribute_id]" value="2" /><input
                                        type="hidden" name="variant_options[0][optionId]" />
                                    <div class="mb-05 text-textSubdued uppercase"><span></span></div>
                                    <ul class="variant-option-list flex justify-start gap-05 flex-wrap">
                                        {{-- <li class=""><a href="#">M</a></li>
                                        <li class=""><a href="#">L</a></li> --}}
                                    </ul>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn-beli"><span>ADD TO CART</span></button>
                            </div>
                        </div>
                    </form>
                    <div class="mt-5 md:mt-3">
                        <div class="product-description">
                            <div class="ck-content">
                                <h5 class="speakable">Deskripsi :</h5>
                                <p class="speakable">{!! $dataProduk->deskripsi !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
