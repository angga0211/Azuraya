@extends('user.index')
@section('konten')
<main class="content">
    <div class="page-width my-2"><span><a href="/" class="text-interactive speakable">Home</a><span> /
            </span></span><span class="speakable">Shop</span></div>
    <div class="page-width">
        <div class="mb-1 md:mb-2 category__general">
            <div class="category__info">
                <div>
                    <h1 class="category__name speakable" >Azuraya Store</h1>
                    <div class="category__description">
                        <div class="ck-content">
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-3">
        <div class="page-width">
            @if ($dataProduk->count())
                <div class="mb-3 text-center uppercase h5 tracking-widest">
                    <div class="product-sorting mb-1">
                        <div class="product-sorting-inner flex justify-end items-center space-x-05 mb-2">
                            <div class="dropdown-container">
                                <div class="dropdown">
                                    <form action="/produk" method="GET">
                                        @if (request('kategori'))
                                            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                                        @endif
                                        <div class="search-container">
                                            <input class="search-input" type="text" name="search" placeholder="Search"
                                                value="{{ request('search') }}">
                                            <button class="search-button" type="submit">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="product-sorting-inner flex justify-end items-center space-x-05">
                            <span class="speakable"> Kategori: &nbsp;</span>
                            <div class="dropdown-container">
                                <div class="dropdown">
                                    <button class="dropdown-button" id="dropdown-button"> Semua</button>
                                    <div class="dropdown-content" id="dropdown-content">
                                        <a href="/produk" class="speakable" data-value="semua">Semua</a>
                                        @foreach ($dataKategori as $kategori)
                                            <a class="speakable" href="/produk?kategori={{ $kategori->slug }}" data-value="{{ $kategori->slug }}">{{ $kategori->nama }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @foreach ($dataProduk as $produk)
                        <div class="listing-tem myProduk">
                            <div class="product-thumbnail-listing">
                                <a href="/produk/{{ $produk->slug }}">
                                    <img style="object-fit: fill" src="{{ $produk->image === 'default' ? asset('defaultProduk.jpg') : asset('storage/' . $produk->image) }}" alt="Image"/>
                                </a>
                            </div>
                            <div class="product-name product-list-name mt-1 mb-025"><a href="/produk/{{ $produk->slug }}"
                                    class="hover:underline h5 speakable"><span>{{ $produk->nama }}</span></a>
                            </div>
                            <div class="product-price-listing">
                                <div>
                                    <span class="sale-price speakable">
                                        Rp.
                                        @if ($produk->harga !== $produk->hargaTotal)
                                            <s>{{ number_format($produk->harga, 0, ',', '.') }}</s> {{ number_format($produk->hargaTotal, 0, ',', '.') }}
                                        @else
                                            {{ number_format($produk->harga, 0, ',', '.') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex items-center justify-center h-64">
                    <div class="text-center">
                        <h3 class="text-xl font-semibold speakable">Ups!! Produk Sedang Kosong</h3>
                    </div>
                </div>
            @endif
        </div>
    </div>
</main>
{{ $dataProduk->links('partials.paginator') }}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownButton = document.querySelector('#dropdown-button');
        const dropdownContent = document.querySelector('#dropdown-content');
        const urlParams = new URLSearchParams(window.location.search);
        const urlCategory = urlParams.get('kategori') || 'semua';
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
                newUrl.searchParams.set('kategori', categoryValue);
                window.location.href = newUrl.toString();

                dropdownContent.style.display = 'none';
            }
        });
    });
</script>
@endsection
