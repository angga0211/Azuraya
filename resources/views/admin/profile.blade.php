@extends('admin.layouts.app')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 class="speakable">Informasi Akun</h1>
            <div class="section-header-breadcrumb">
                <button class="speakable btn btn-success btn-icon icon-left d-block d-sm-inline-block" data-toggle="modal" data-target="#editModal"><i class="fas fa-pen"></i> Edit</button>
            </div>
        </div>
        <div class="row bread-crumb flex-w p-l-25 p-r-15 p-lr-0-lg">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img style="width: 80px;height: 80px;border: 1px solid #ddd;border-radius: 50%;object-fit: cover" src="{{ $dataUser->image === 'default' ? asset('defaultUser.png') : asset('storage/' . $dataUser->image) }}" alt="image">
                        <h5 class="my-3 text-20 speakable">{{ $dataUser->username }}</h5>
                        <p class="text-muted mb-1 text-14 speakable">{{ $dataUser->telepon }}</p>
                        <p class="text-muted mb-4 text-14 speakable">{{ $dataUser->email }}</p>
                        <div class="d-flex justify-content-center mb-2"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0 text-14-bold speakable">Nama</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0 text-14 speakable">{{ $dataUser->nama }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0 text-14-bold speakable">Gender</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0 text-14 speakable">{{ $dataUser->jenis_kelamin }}</p>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title speakable">Edit Informasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/profil" method="post" style="display: unset;" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group d-flex justify-content-center">
                        <div>
                            <div class="image-preview" id="imagePreview">
                                <img src="{{ $dataUser->image === 'default' ? asset('defaultUser.png') : asset('storage/' . $dataUser->image) }}" alt="Image Preview" id="imagePreviewImg">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="file" name="image" id="imageInput" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="nama" class="speakable">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{ $dataUser->nama }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="username" class="speakable">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required value="{{ $dataUser->username }}">
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin" class="speakable">Gender</label>
                        <select name="jenis_kelamin" class="form-control" id="jenis_kelamin">
                            <option value="" disabled {{ $dataUser->jenis_kelamin == '' ? 'selected' : '' }}>Gender</option>
                            <option value="Perempuan" {{ $dataUser->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            <option value="Laki-Laki" {{ $dataUser->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="telepon" class="speakable">Telepon</label>
                        <input type="text" name="telepon" id="telepon" class="form-control" required value="{{ $dataUser->telepon }}">
                    </div>
                      <div class="form-group">
                        <label for="email" class="speakable">Email</label>
                        <input type="text" id="email" class="form-control" disabled value="{{ $dataUser->email }}">
                    </div>
                      <div class="form-group">
                        <label for="password" class="speakable">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                      <div class="form-group">
                        <label for="password" class="speakable">Ulangi Password</label>
                        <input type="password" name="password_confirmation" id="password" class="form-control">
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-success speakable"><i class="fas fa-check"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    function openModal() {
        document.getElementById("editProfileModal").style.display = "block";
    }
    function closeModal() {
        document.getElementById("editProfileModal").style.display = "none";
    }
    window.onclick = function(event) {
        const modal = document.getElementById("editProfileModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
</script>
<script>
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const imagePreview = document.getElementById('imagePreviewImg');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            imagePreview.src = e.target.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
