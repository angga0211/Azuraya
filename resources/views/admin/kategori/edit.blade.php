@extends('admin.layouts.app')
@section('content')
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1 class="speakable">Edit Kategori</h1>
            <div class="section-header-breadcrumb">
              <a class="btn btn-primary speakable" href="/admin/kategori-produk" role="button"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
          </div>

          <div class="section-body">
            <div class="card">
              <div class="card-header">
                <h4 class="speakable">Edit Kategori - {{$produkKategori->nama}}</h4>
              </div>
              <div class="card-body">
                <form action="/admin/edit-kategori/{{ $produkKategori->slug }}" method="post" class="need-validation">
                    @csrf
                    <input type="hidden" value="{{ $produkKategori->id }}" name="id">
                    <div class="form-group">
                      <label for="nama" class="form-label speakable">Nama</label>
                      <input value="{{ $produkKategori->nama }}" autofocus type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror">
                      @error('nama')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>
                  <div class="form-group">
                      <labe class="speakable" for="slug">Slug:</labe>
                      <input value="{{ $produkKategori->slug }}" type="text" class="form-control" name="slug" id="slug" placeholder="Slug" readonly required>
                  </div>
                    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Update</button>
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
