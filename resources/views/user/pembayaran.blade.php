@extends('user.index')
@section('konten')
<main class="content">
    <div class="page-width my-2">
        <span>
            <a href="/" class="text-interactive">Home</a>
            <span> / </span>
        </span>
        <span>Checkout</span>
    </div>
    <div class="page-width grid grid-cols-1 md:grid-cols-2 gap-3">
        <div class="">
            <div class="mb-2 mt-1 flex checkout-breadcrumb">
                <span class="text-muted flex items-center">
                    <span class="speakable">Informasi</span>
                    <span class="separator">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" width="10" height="10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                </span>
                <span class="text-interactive flex items-center">
                    <span class="speakable">Pengiriman</span>
                </span>
            </div>
            <div class="checkout-steps">
                <div class="checkout-payment checkout-step">
                    <div>
                        <h4 class="mb-1 mt-3 speakable">Shipping Address</h4>
                        <form id="checkoutShippingAddressForm" action="/checkout/{{ auth()->user()->username }}" method="POST">
                            @csrf
                            <div class="">
                                <div class="form-field-container null mb-2">
                                    <div class="field-wrapper flex flex-grow speakable">
                                        <input type="text" name="email" placeholder="Email" value="{{ $dataKeranjang[0]->user->email }}" readonly>
                                        <div class="field-border"></div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-1">
                                    <div>
                                        <div class="form-field-container null speakable">
                                            <label for="nama">Nama Lengkap</label>
                                            <div class="field-wrapper flex flex-grow">
                                                <input type="text" name="nama_pemesan" placeholder="Nama" value="{{ $dataKeranjang[0]->user->nama }}">
                                                <div class="field-border"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-field-container null speakable">
                                            <label for="telepon">Telepon</label>
                                            <div class="field-wrapper flex flex-grow">
                                                <input type="text" name="telepon" placeholder="Telephone" value="{{ $dataKeranjang[0]->user->telepon }}" readonly>
                                                <div class="field-border"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-field-container null speakable">
                                    <label for="catatan">Catatan</label>
                                    <div class="field-wrapper flex flex-grow">
                                        <input type="text" name="catatan" placeholder="Catatan">
                                        <div class="field-border"></div>
                                    </div>
                                </div>
                                <div class="form-field-container null speakable">
                                    <label for="detail_alamat">Alamat Detail</label>
                                    <div class="field-wrapper flex flex-grow">
                                        <input type="text" name="detail_alamat" placeholder="Alamat Detail">
                                        <div class="field-border"></div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-1 mt-1">
                                    <div>
                                        <div class="form-field-container dropdown null">
                                            <label for="provinsi" class="speakable">Provinsi</label>
                                            <div class="myInput field-wrapper flex flex-grow items-baseline">
                                                <select class="form-field" id="provinsi" placeholder="Provinsi">
                                                    <option value="" disabled selected>Provinsi</option>
                                                    @foreach($daftarProvinsi as $provinsi)
                                                        <option value="{{ $provinsi->province_id }}">{{ $provinsi->province }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="field-border"></div>
                                                <div class="field-suffix">
                                                    <svg viewBox="0 0 20 20" width="1rem" height="1.25rem" focusable="false" aria-hidden="true">
                                                        <path d="m10 16-4-4h8l-4 4zm0-12 4 4H6l4-4z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-field-container dropdown null">
                                            <label for="kota" class="speakable">Kota</label>
                                            <div class="myInput field-wrapper flex flex-grow items-baseline">
                                                <select class="form-field" id="kota" name="kota" placeholder="Kota" disabled>
                                                    <option value="" disabled selected>Kota</option>
                                                </select>
                                                <div class="field-border"></div>
                                                <div class="field-suffix">
                                                    <svg viewBox="0 0 20 20" width="1rem" height="1.25rem" focusable="false" aria-hidden="true">
                                                        <path d="m10 16-4-4h8l-4 4zm0-12 4 4H6l4-4z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="provinsi" id="hidden-provinsi">
                                    <input type="hidden" name="kota" id="hidden-kota">
                                </div>
                                <div class="grid grid-cols-2 gap-1 mt-1">
                                    <div class="form-field-container null">
                                        <label for="kecamatan" class="speakable">Kecamatan</label>
                                        <div class="field-wrapper flex flex-grow">
                                            <input id="kecamatan" class="myInput" type="text" name="kecamatan" placeholder="Kecamatan" disabled>
                                            <div class="field-border"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-field-container null">
                                            <label for="kode_pos" class="speakable">Kode Pos</label>
                                            <div class="field-wrapper flex flex-grow">
                                                <input id="kode_pos" class="myInput" type="text" name="kode_pos" placeholder="Kode Pos" disabled>
                                                <div class="field-border"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="shipping-methods">
                                    <h4 class="mt-3 mb-1" class="speakable">Metode Pengiriman</h4>
                                    <div class="divide-y border rounded border-divider p-1 mb-2">
                                        <div id="shipping-methods-container" class="form-field-container null">
                                            <!-- Shipping methods will be loaded here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="ongkir" id="ongkir">
                            <input type="hidden" name="layanan" id="layanan">
                            <div class="form-submit-button flex border-t border-divider mt-1 pt-1">
                                <button style="background-color: rgb(118, 118, 118);color: #fff" type="submit" class="button speakable" id="payment-button" disabled>Continue to payment</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="checkout-payment checkout-step"></div>
            </div>
        </div>
        <div class="">
            <div class="checkout-summary hidden md:block">
                <div id="summary-items">
                    <table class="listing items-table">
                        <tbody>
                            @foreach ($dataKeranjang as $item)
                            <tr>
                                <td>
                                    <div class="product-thumbnail">
                                        <div class="thumbnail">
                                            <img src="{{ $item->produk->image === 'default' ? asset('defaultProduk.jpg') : asset('storage/' . $item->produk->image) }}" alt="Image">
                                        </div>
                                        <span class="qty">{{ $item->quantity }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="product-column">
                                        <div>
                                            <span class="font-semibold speakable">{{ $item->produk->nama }}</span>
                                        </div>
                                        <div class="cart-item-variant-options mt-05">
                                            <ul>
                                                <li>
                                                    -
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="speakable">
                                        Rp.
                                        @if ($item->produk->harga !== $item->produk->hargaTotal)
                                        <s>{{ number_format($item->produk->harga, 0, ',', '.') }}</s>
                                        {{ number_format($item->produk->hargaTotal, 0, ',', '.') }}
                                        @else
                                        {{ number_format($item->produk->harga, 0, ',', '.') }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="checkout-summary-block">
                    <div class="summary-row">
                        <span class="speakable">Sub total</span>
                        @php
                            $subtotal = 0;
                            $discountTotal = 0;
                            foreach ($dataKeranjang as $item) {
                                $subtotal += $item['produk']['harga'] * $item['quantity'];
                                $discountTotal += ($item['produk']['harga'] - $item['produk']['hargaTotal']) * $item['quantity'];
                            }
                            $grandTotal = $subtotal - $discountTotal;
                        @endphp
                        <div>
                            <div>{{ $dataKeranjang->count() }} items</div>
                            <div class="speakable">Rp. {{ number_format($subtotal, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="summary-row">
                        <span class="speakable">Discount</span>
                        <div>
                            <div></div>
                            <div class="speakable">Rp. {{ number_format($discountTotal, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="summary-row">
                        <span class="speakable">Pengiriman</span>
                        <div>
                            <div></div>
                            <div class="speakable" id="shipping-cost">Rp. 0</div>
                        </div>
                    </div>
                    <div class="summary-row grand-total flex justify-between">
                        <div>
                            <div class="font-bold">
                                <span class="speakable">Total</span>
                            </div>
                        </div>
                        <div>
                            <div></div>
                            <div id="grand-total" class="grand-total-value speakable">Rp. {{ number_format($grandTotal, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const daftarKota = @json($daftarKota);
        const provinsiSelect = document.getElementById('provinsi');
        const kotaSelect = document.getElementById('kota');
        const kecamatanInput = document.getElementById('kecamatan');
        const kodePosInput = document.getElementById('kode_pos');
        const shippingMethodsContainer = document.getElementById('shipping-methods-container');
        const shippingCostElement = document.getElementById('shipping-cost');
        const grandTotalElement = document.getElementById('grand-total');
        const paymentButton = document.getElementById('payment-button');
        const baseGrandTotal = @json($grandTotal); 
        const hiddenProvinsiInput = document.getElementById('hidden-provinsi');
        const hiddenKotaInput = document.getElementById('hidden-kota');
        provinsiSelect.addEventListener('change', function() {
            const provinsiId = this.value;
            const selectedOption = provinsiSelect.options[provinsiSelect.selectedIndex];
            hiddenProvinsiInput.value = selectedOption.textContent; 
            kotaSelect.innerHTML = '<option value="" disabled selected>Kota</option>';
            daftarKota.forEach(function(kota) {
                if (kota.province_id === provinsiId) {
                    kotaSelect.innerHTML += `<option value="${kota.city_id}" data-name="${kota.city_name}">${kota.city_name}</option>`;
                }
            });
            kotaSelect.disabled = false;
            kecamatanInput.disabled = false;
            kodePosInput.disabled = false;
            shippingMethodsContainer.innerHTML = '';
            shippingCostElement.textContent = 'Rp. 0';
            grandTotalElement.textContent = `Rp. ${baseGrandTotal.toLocaleString()}`;
            paymentButton.disabled = true; 
        });

        kotaSelect.addEventListener('change', function() {
            const kotaId = this.value;
            const selectedOption = kotaSelect.options[kotaSelect.selectedIndex];
            hiddenKotaInput.value = selectedOption.dataset.name;
            const weight = 1000; 

            fetch('/fetch-shipping-methods', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    provinsi: provinsiSelect.value,
                    kota: kotaId,
                    weight: weight
                })
            })
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data)) {
                    shippingMethodsContainer.innerHTML = '';
                    let shippingCost = 0;
                    data.forEach((courier) => {
                        if (Array.isArray(courier.costs)) {
                            courier.costs.forEach((cost) => {
                                const method = document.createElement('div');
                                method.className = 'radio-container';
                                method.innerHTML = `
                                    <input type="radio" id="method-${courier.code}-${cost.service}" name="kurir" value="${cost.cost[0].value}" data-description="(JNE) ${cost.description} - estimasi: ${cost.cost[0].etd} hari - (Rp. ${cost.cost[0].value})">
                                    <label for="method-${courier.code}-${cost.service}">(JNE) ${cost.description} - estimasi: ${cost.cost[0].etd} hari - (Rp. ${cost.cost[0].value})</label>
                                `;
                                shippingMethodsContainer.appendChild(method);
                            });
                        }
                    });
                    document.querySelectorAll('input[name="kurir"]').forEach((radio) => {
                        radio.addEventListener('change', function() {
                            const costValue = parseInt(this.value);
                            shippingCost = costValue;
                            const description = this.getAttribute('data-description');
                            document.getElementById('layanan').value = description;
                            document.getElementById('ongkir').value = shippingCost;
                            shippingCostElement.textContent = `Rp. ${shippingCost.toLocaleString()}`;
                            const newGrandTotal = baseGrandTotal + shippingCost;
                            grandTotalElement.textContent = `Rp. ${newGrandTotal.toLocaleString()}`;
                            paymentButton.disabled = false;
                        });
                    });
                } else {
                    console.error('Invalid response format:', data);
                    shippingMethodsContainer.innerHTML = '<p>No shipping methods available.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching shipping methods:', error);
            });
        });
    });
</script>
@endsection
