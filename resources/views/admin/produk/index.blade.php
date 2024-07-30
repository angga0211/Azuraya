@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1 class="speakable">Produk</h1>
            <div class="section-header-breadcrumb">
              <a class="btn btn-primary speakable" href="/admin/tambah-produk" role="button"><i class="fas fa-plus"></i> Add</a>
            </div>
          </div>
          <div class="section-body">
            <div class="card">
              <div class="card-header">
                <h4 class="speakable">Semua Produk</h4>
              </div>
              <div class="card-body p-2">
                <div class="table-responsive">
                    <table class="table table-striped w-100 speakable" id="categories-table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Produk</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Berat</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Image</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataProduk as $produk)
                                <tr>
                                    <th scope="row">{{$loop->iteration + $dataProduk->firstItem() -1}}</th>
                                    <td>{{$produk->nama}}</td>
                                    <td>
                                        Rp.
                                        @if ($produk->harga !== $produk->hargaTotal)
                                            <s>{{ number_format($produk->harga, 0, ',', '.') }}</s> {{ number_format($produk->hargaTotal, 0, ',', '.') }}
                                        @else
                                            {{ number_format($produk->harga, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td>{{$produk->berat}}g</td>
                                    <td>{{$produk->produkkategori->nama}}</td>
                                    <td>{{$produk->stok}}</td>
                                    <td><img class="product-photo" src="{{ $produk->image === 'default' ? asset('defaultProduk.jpg') : asset('storage/' . $produk->image) }}" alt="Image"></td>
                                    <td class="text-center">
                                        <div style="display: inline-flex;">
                                            <div class="p-1">
                                                <a name="edit" class="btn btn-warning btn-sm btnAction" href="/admin/edit-produk/{{ $produk->slug }}" role="button"><i class="fas fa-edit"></i></a>
                                            </div>
                                            <div class="p-1">
                                                <form action="/admin/hapus-produk/{{ $produk->slug }}" method="post">
                                                    @csrf
                                                    <button name="delete" class="btn btn-danger btn-sm btnAction delete-confirm" type="submit" role="button"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <h6 class="speakable">Produk Tidak Tersedia</h6>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pagination float-right">
                    {{ $dataProduk->links() }}
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection
@section('js')
<script src="{{asset('js/admin/modules/sweetalert.js')}}"></script>
<script>
    $('.delete-confirm').click(function(event) {
        var form =  $(this).closest("form");
        var name = $(this).data("name").toLowerCase();
        event.preventDefault();
        swal({
            title: `Anda yakin ingin menghapus produk ${name}?`,
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
</script>
@endsection
