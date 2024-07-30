@extends('admin.layouts.app')
@section('content')
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1 class="speakable">Kategori Produk</h1>
            <div class="section-header-breadcrumb">
              <a class="btn btn-primary speakable" href="/admin/produk-kategori" role="button"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
          </div>
          <div class="section-body">
            <div class="card">
              <div class="card-header">
                <h4 class="speakable">Tambah Produk Kategori</h4>
              </div>
              <div class="card-body">
                <form action="/admin/tambah-kategori" method="post" class="need-validation">
                  @csrf
                  <div class="form-group">
                      <label for="nama" class="form-label speakable">Nama</label>
                      <input autofocus placeholder="Kategori" type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')}}">
                      @error('nama')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
                  
                  <div class="form-group">
                      <label for="slug" class="speakable">Slug:</label>
                      <input value="{{old('slug')}}" type="text" class="form-control" name="slug" id="slug" placeholder="Slug" readonly required>
                  </div>
                    <button type="submit" class="btn btn-primary float-right speakable"><i class="fas fa-save"></i> Simpan</button>
                </form>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection

@section('js')
<script>
  $(document).ready(function() {
      $('#nama').on('input', function() {
          const namaValue = $(this).val().toLowerCase();
          const slugValue = namaValue.trim()
              .replace(/\s+/g, '-')
              .replace(/[^a-z0-9-]/g, '');
          $('#slug').val(slugValue);
      });
  });
</script>
@endsection
