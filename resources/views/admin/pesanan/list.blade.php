@extends('admin.layouts.app')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 class="speakable">Daftar Pesanan</h1>
        </div>
        <div class="section-body">
            @include('admin.pesanan.partials.menu')
            <div class="card">
                <div class="card-header">
                    <h4 class="speakable">{{ $currentStatus }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="speakable">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Invoice</th>
                                        <th>Pemesan</th>
                                        <th>Total</th>
                                        <th>Pembayaran</th>
                                        <th>Status Pesanan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="speakable">
                                    @forelse ($dataPesanan as $pesanan)
                                        <tr>
                                            <td class="text-center">{{$loop->iteration + $dataPesanan->firstItem() -1}}</td>
                                            <td>{{ $pesanan->invoice }}</td>
                                            <td>{{ $pesanan->nama_pemesan }}</td>
                                            <td>Rp. {{ number_format($pesanan->subtotal, 0, ',', '.') }}</td>
                                            <td>{{ $pesanan->bayar }}</td>
                                            <td>
                                                {{ $pesanan->status }}
                                            </td>
                                            <td class="text-center">
                                                <a href="/admin/detail-pesanan/{{ $pesanan->invoice }}" class="btn btn-warning">Lihat Detail</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data pesanan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pagination float-right">
                                {{ $dataPesanan->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
