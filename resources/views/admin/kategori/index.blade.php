@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1 class="speakable">Kategori Produk</h1>
            <div class="section-header-breadcrumb">
              <a class="btn btn-primary speakable" href="/admin/tambah-kategori" role="button"><i class="fas fa-plus"></i> Add</a>
            </div>
          </div>
          <div class="section-body">
            <div class="card">
              <div class="card-header">
                <h4 class="speakable">Semua Kategori Produk</h4>
              </div>
              <div class="card-body p-2">
                <div class="table-responsive">
                    <table class="table table-striped w-100" id="categories-table">
                        <thead>
                            <tr class="speakable">
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Jumlah Produk</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataKategori as $kategori)
                                <tr class="speakable">
                                    <th scope="row">{{$loop->iteration + $dataKategori->firstItem() -1}}</th>
                                    <td>{{$kategori->nama}}</td>
                                    <td>{{$kategori->produk_count}}</td>
                                    <td class="text-center">
                                        <div class="form-group" style="display: inline-flex;">
                                            <div class="p-1">
                                                <a name="edit"" class="btn btn-warning btn-sm btnAction" href="/admin/edit-kategori/{{ $kategori->slug }}" role="button"><i class="fas fa-edit"></i></a>
                                            </div>
                                            <div class="p-1">
                                                <form action="/admin/hapus-kategori/{{ $kategori->slug }}" method="post">
                                                    @csrf
                                                    <button onclick="return confirm('Yakin ingin hapus?')" class="btn btn-danger btn-sm btnAction delete-confirm" type="submit" role="button"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center speakable">Tidak ada dat</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pagination float-right">
                    {{ $dataKategori->links() }}
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
    $(document).ready(function(){
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
            });
        }, 5000);
    });
</script>
@endsection
