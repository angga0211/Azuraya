@extends('admin.layouts.app')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 class="speakable">Detail Pesanan</h1>
            <div class="section-header-breadcrumb">
                @if ($dataPesanan->status=="Siap Dikirim")
                    <button class="speakable btn btn-success btn-icon icon-left d-block d-sm-inline-block" data-toggle="modal" data-target="#resiModal"><i class="fas fa-shipping-fast"></i> Input No. Resi</button>&nbsp;
                @endif
                @if ($dataPesanan->status=="Dalam Pengiriman")
                    <form action="/admin/selesaikan-pesanan/{{ $dataPesanan->invoice }}" method="post" style="display: unset;">
                        @csrf
                        <button class="speakable btn btn-danger btn-icon icon-left done-confirm d-block d-sm-inline-block" data-name="{{$dataPesanan->invoice}}"><i class="fas fa-check"></i> Selesai</button>
                    </form>&nbsp;
                @endif
                @if ($dataPesanan->status=="Pesanan Baru")
                <form action="/admin/batalkan-pesanan/{{ $dataPesanan->invoice }}" method="post" style="display: unset;">
                    @csrf
                    <button class="speakable btn btn-danger btn-icon icon-left cancel-confirm d-block d-sm-inline-block" data-name="{{$dataPesanan->invoice}}"><i class="fas fa-window-close"></i> Batal Pesanan</button>
                </form>&nbsp;
                @endif
            </div>
        </div>
        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                <div class="row w-100">
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="invoice-title mb-4">
                            <h2 class="speakable">Pesanan</h2>
                            <div class="invoice-number">{{$dataPesanan->invoice}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tbody class="speakable">
                                            <tr>
                                                <th>Nama</th>
                                                <td>:</td>
                                                <td>{{$dataPesanan->nama_pemesan}}</td>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td>:</td>
                                                <td>{{$dataPesanan->alamat_pengiriman}}</td>
                                            </tr>
                                            <tr>
                                                <th>Telepon</th>
                                                <td>:</td>
                                                <td>{{$dataPesanan->telepon}}</td>
                                            </tr>
                                            <tr>
                                                <th>Catatan</th>
                                                <td>:</td>
                                                <td>{{$dataPesanan->catatan}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tbody class="speakable">
                                            <tr>
                                                @php
                                                    $layanan = $dataPesanan->layanan;
                                                    preg_match('/^(.*?)( - estimasi:|$)/', $layanan, $matches);
                                                    $layananAwal = $matches[1];
                                                @endphp
                                                <th>Jasa Pengiriman</th>
                                                <td>:</td>
                                                <td>
                                                    {{ $layananAwal }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Pembayaran</th>
                                                <td>:</td>
                                                <td>{{$dataPesanan->bayar ?: '-'}}</td>
                                            </tr>
                                            <tr>
                                                <th>Nomor Resi</th>
                                                <td>:</td>
                                                <td>{{$dataPesanan->nomor_resi ?: '-'}}</td>
                                            </tr>
                                            <tr>
                                                <th>Status Pesanan</th>
                                                <td>:</td>
                                                <td>{{$dataPesanan->status}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-0">
                    <div class="col-md-12">
                    <div class="section-title speakable">Ringkasan Pesanan</div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tr class="speakable">
                                <th data-width="40">#</th>
                                <th class="text-center">Gambar</th>
                                <th>Nama Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-right">Total</th>
                            </tr>
                            <tbody class="speakable">
                                @foreach ($dataPesanan->pesanan_detail as $produk)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td class="text-center"><img src="{{ $produk->image_produk === 'default' ? asset('defaultProduk.jpg') : asset('storage/' . $produk->image_produk) }}" alt="" srcset="" width="50"></td>
                                        <td>{{ $produk->nama_produk }}</td>
                                        <td class="text-center">Rp. {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $produk->banyak_dibeli }}</td>
                                        <td class="text-right">Rp. {{ number_format($produk->hargaTotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-8 speakable">
                            <div class="section-title ">Pembayaran</div>
                            {{$dataPesanan->bayar ?: '-'}}
                        </div>
                        <div class="col-lg-4 text-right">
                            <div class="invoice-detail-item speakable">
                                <div class="invoice-detail-name">Subtotal</div>
                                <div class="invoice-detail-value">Rp. {{ number_format($dataPesanan->total, 0, ',', '.') }}</div>
                            </div>
                            <div class="invoice-detail-item speakable">
                                <div class="invoice-detail-name">Biaya Pengiriman</div>
                                <div class="invoice-detail-value">Rp. {{ number_format($dataPesanan->ongkir, 0, ',', '.') }}</div>
                            </div>
                            <hr class="mt-2 mb-2">
                            <div class="invoice-detail-item speakable">
                                <div class="invoice-detail-name">Total</div>
                                <div class="invoice-detail-value invoice-detail-value-lg">Rp. {{ number_format($dataPesanan->subtotal, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        @if ($dataPesanan->status=="Siap Dikirim")
            <div class="modal fade" tabindex="-1" role="dialog" id="resiModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Input Nomor Resi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/admin/tambah-nomor-resi/{{ $dataPesanan->invoice }}" method="post" style="display: unset;">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="jasa">Jasa Pengiriman</label>
                                    <input type="text" class="form-control" value="{{ $layananAwal }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="tracking_number">Nomor Resi Pengiriman</label>
                                    <input type="text" name="nomor_resi" id="tracking_number" class="form-control" required autofocus>
                                </div>
                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </section>
</div>
@endsection
@section('js')
<script src="{{asset('js/admin/modules/sweetalert.js')}}"></script>
<script>
    $('.cancel-confirm').click(function(event) {
        var form =  $(this).closest("form");
        var name = $(this).data("name").toLowerCase();
        event.preventDefault();
        swal({
            title: `Anda yakin ingin membatalkan pesanan ${name}?`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ['Tidak', 'Ya']
        })
        .then((willDelete) => {
            if (willDelete) {
            form.submit();
            }
        });
    });
    $(document).ready(function(){
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
            });
        }, 5000);
    });
    $('.done-confirm').click(function(event) {
        var form =  $(this).closest("form");
        var name = $(this).data("name").toLowerCase();
        event.preventDefault();
        swal({
            title: `Anda yakin ingin menyelesaikan pesanan ${name}?`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ['Tidak', 'Ya']
        })
        .then((willDelete) => {
            if (willDelete) {
            form.submit();
            }
        });
    });
</script>
<script>
    $('.modal').on('shown.bs.modal', function() {
        $('.modal').appendTo("body")
    });
</script>
@endsection
