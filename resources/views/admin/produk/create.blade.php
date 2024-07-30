@extends('admin.layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css">
@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 class="speakable">Tambah Produk</h1>
            <div class="section-header-breadcrumb">
                <a class="btn btn-primary speakable" href="/admin/produk" role="button"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4 class="speakable">Tambah Produk Baru</h4>
                </div>
                <div class="card-body">
                    <form action="/admin/tambah-produk" method="post" enctype="multipart/form-data"
                        class="need-validation">
                        @csrf
                        <div class="form-group">
                            <label for="nama" class="form-label speakable">Nama Produk</label>
                            <input autofocus placeholder="Nama Produk" type="text" id="nama" name="nama"
                                class="form-control @error('nama') is-invalid @enderror" required
                                value="{{old('nama')}}">
                            @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug" class="form-label speakable">Slug Produk</label>
                            <input autofocus placeholder="Slug Produk" type="text" id="slug" name="slug"
                                class="form-control @error('slug') is-invalid @enderror" required readonly
                                value="{{old('slug')}}">
                            @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-label speakable">Deskripsi Produk</label>
                            <textarea autofocus placeholder="Deskripsi Produk" type="text" id="description"
                                name="deskripsi"
                                class="form-control summernote-simple @error('deskripsi') is-invalid @enderror"
                                required>{{old('deskripsi')}}</textarea>
                            @error('deskripsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id" class="speakable">Kategori Produk</label>
                            @if (count($dataKategori) <= 0) <div class="alert alert-danger">
                                Buat kategori terlebih dulu</div>
                        @else
                        <select name="kategori_id" id="category_id"
                            class="form-control @error('kategori') is-invalid @enderror" required>
                            <option value="" selected disabled>Kategori Produk</option>
                            @foreach ($dataKategori as $kategori)
                            <option value="{{$kategori->id}}">{{$kategori->nama}}</option>
                            @endforeach
                        </select>
                        @endif
                        @error('kategori')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                </div>
                <div class="form-group">
                    <label for="image" class="speakable">Image</label>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image"
                        accept="image/*">
                    @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price" class="speakable">Harga Produk</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Rp</div>
                        </div>
                        <input type="number" name="harga" id="price"
                            class="form-control currency @error('price') is-invalid @enderror" value="{{old('harga')}}"
                            required>
                        @error('harga')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="diskon" class="speakable">Diskon Produk</label>
                    <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                        <input type="number" name="diskon" id="diskon"
                            class="form-control @error('diskon') is-invalid @enderror" value="{{old('diskon')}}" required min="0" max="100">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                %
                            </div>
                        </div>
                    </div>
                    @error('diskon')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="weight" class="speakable">Berat Produk</label>
                    <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                        <input type="number" name="berat" id="weight"
                            class="form-control @error('berat') is-invalid @enderror" value="{{old('berat')}}" required min="0" >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                gram
                            </div>
                        </div>
                    </div>
                    @error('berat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="quantity" class="speakable">Stok</label>
                    <input type="number" class="form-control @error('stok') is-invalid @enderror" id="quantity"
                        name="stok" value="{{old('stok')}}" required>
                    @error('stok')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary float-right speakable"><i class="fas fa-save"></i>
                    Simpan</button>
                </form>
            </div>
        </div>
</div>
</section>
</div>
@endsection
@section('js')
<script>
    $('#category_id').val({
        {
            old('category_id')
        }
    });
</script>
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
