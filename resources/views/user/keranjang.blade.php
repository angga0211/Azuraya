@extends('user.index')
@section('konten')
<main class="content">
    <div class="page-width my-2">
        <span>
            <a href="/" class="text-interactive speakable">Home</a>
            <span> / </span>
        </span>
        <span class="speakable">Keranjang Belanja</span>
    </div>
    @if ($dataKeranjang->count() < 1) <div class="empty-shopping-cart w-100" style="margin-top:150px">
        <div class="empty-shopping-cart w-100" style="margin-top:150px">
            <div>
                <div class="text-center">
                    <h2 class="speakable">Keranjang Belanja Kamu</h2>
                </div>
                <div class="mt-2 text-center">
                    <span class="speakable">Keranjang Belanja Kamu Kosong!</span>
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
                    <div class="grid gap-4 grid-cols-1 md:grid-cols-4">
                        <div class="col-span-1 md:col-span-3">
                            <div id="shopping-cart-items">
                                <table class="items-table listing">
                                    <thead>
                                        <tr class="speakable">
                                            <td><span>Produk</span></td>
                                            <td><span>Harga</span></td>
                                            <td class="hidden md:table-cell"><span>Quantity</span></td>
                                            <td class="hidden md:table-cell"><span>Total</span></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataKeranjang as $item)
                                        <tr class="speakable">
                                            <td>
                                                <div class="flex justify-start space-x-1 product-info">
                                                    <div class="product-image flex justify-center items-center">
                                                        <img style="width: 100px; height: 100px; object-fit: cover"
                                                            class="self-center"
                                                            src="{{ $item->produk->image === 'default' ? asset('defaultProduk.jpg') : asset('storage/' . $item->produk->image) }}"
                                                            alt="Image" />
                                                    </div>
                                                    <div class="cart-item-info">
                                                        <a href="{{ $item->produk->slug }}" class="name font-semibold hover:underline">
                                                            {{ $item->produk->nama }}
                                                        </a>
                                                        <div class="cart-item-variant-options mt-0.5">
                                                            .
                                                        </div>
                                                        <div class="mt-0.5">
                                                            <form method="POST" action="/hapus-keranjang">
                                                                @csrf
                                                                <input type="hidden" name="keranjang_id" value="{{ $item->id }}">
                                                                <button type="submit" class="text-textSubdued underline">Remove</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="sale-price">
                                                        Rp.
                                                        @if ($item->produk->harga !== $item->produk->hargaTotal)
                                                            <s>{{ number_format($item->produk->harga, 0, ',', '.') }}</s>
                                                            {{ number_format($item->produk->hargaTotal, 0, ',', '.') }}
                                                        @else
                                                            {{ number_format($item->produk->harga, 0, ',', '.') }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="hidden md:table-cell">
                                                <span>{{ $item->quantity }}</span>
                                            </td>
                                            <td class="hidden md:table-cell">
                                                <span>Rp. {{ number_format($item->produk->hargaTotal * $item->quantity, 0, ',', '.') }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-span-1 md:col-span-1">
                            <div class="summary">
                                @php
                                    $subtotal = 0;
                                    $discountTotal = 0;
                                    foreach ($dataKeranjang as $item) {
                                        $subtotal += $item['produk']['harga'] * $item['quantity'];
                                        $discountTotal += ($item['produk']['harga'] - $item['produk']['hargaTotal']) *  $item['quantity'];
                                    }
                                    $grandTotal = $subtotal - $discountTotal;
                                @endphp
                                <div class="grid grid-cols-1 gap-2">
                                    <h4 class="speakable">Proses Pesanan</h4>
                                    <div class="flex justify-between">
                                        <div class="speakable">Sub total</div>
                                        <div class="text-right speakable">Rp. {{ number_format($subtotal, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="flex justify-between">
                                        <div>Diskon</div>
                                        <div class="text-right speakable">Rp. {{ number_format($discountTotal, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="grand-total flex justify-between total">
                                        <div>
                                            <div class="font-bold speakable"><span>Total</span></div>
                                        </div>
                                        <div class="text-right font-bold speakable">Rp. {{ number_format($grandTotal, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                <div class="shopping-cart-checkout-btn flex justify-between mt-2">
                                    <a href="/checkout/{{ auth()->user()->username }}" class="button primary speakable"><span>CHECKOUT</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart-page-bottom"></div>
            </div>
        </div>
        {{ $dataKeranjang->links('partials.paginator') }}
    @endif
</main>
@endsection
