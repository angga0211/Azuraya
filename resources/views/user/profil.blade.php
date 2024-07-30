@extends('user.index')
@section('konten')
<main class="content">
    <div class="page-width my-2">
        <span>
            <a href="/" class="text-interactive speakable">Home</a>
            <span> / </span>
        </span>
        <span class="speakable">Profile</span>
    </div>
    <div class="page-width grid grid-cols-1 md:grid-cols-2 gap-3">
        <div class="">
            <div class="profil-summary md:block ">
                <h3 class="speakable">Informasi Akun</h3>
                <div id="summary-items">
                    <table class="listing items-table">
                        <tbody>
                            <tr>
                                <td style="min-height: 100px; min-width: 100px;">
                                    <img style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);height: 80px; width: 80px; object-fit: cover; border-radius: 50%;"  src="{{ $dataUser->image === 'default' ? asset('defaultUser.png') : asset('storage/' . $dataUser->image) }}" alt="Image">
                                </td>
                                <td>
                                    <div class="product-column">
                                        <div>
                                            <span class="font-semibold speakable">{{ $dataUser->nama }}</span>
                                        </div>
                                        <div class="cart-item-variant-options mt-05">
                                            <ul>
                                                <li>
                                                    <span class="attribute-name"> </span>
                                                    <span class="speakable">{{ $dataUser->username }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span>
                                        <form action="/logout" method="POST" class="logout">
                                            @csrf
                                            <button class="speakable" type="submit" style="display: flex; align-items: center;">
                                                <i style="margin-right: 8px;" class="fa fa-sign-out" aria-hidden="true"></i>
                                                LogOut
                                            </button>
                                        </form>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="checkout-summary-block">
                    <div class="summary-row speakable">
                        <span>Email</span>
                        <div>
                            <div>{{ $dataUser->email }}</div>
                            <div></div>
                        </div>
                    </div>
                    <div class="summary-row speakable">
                        <span>Telepon</span>
                        <div>
                            <div>{{ $dataUser->telepon }}</div>
                            <div></div>
                        </div>
                    </div>
                    <div class="summary-row speakable">
                        <span>Gender</span>
                        <div>
                            <div>{{ $dataUser->jenis_kelamin }}</div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <button class="logout speakable" style="display: flex; align-items: center;" onclick="openModal()">
                    <i style="margin-right: 8px;" class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    Edit Profil
                </button>
            </div>
        </div>
    </div>
</main>
<div id="editProfileModal" class="modal" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title speakable">Edit Profil</h5>
                <button type="button" class="close" aria-label="Close" onclick="closeModal()">
                    <i class="fa fa-times" style="font-size:20px;" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="/update-profile" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="form-group pilih-gambar mb-2">
                        <label for="image">Gambar Profil:</label>
                        <div class="image-preview" id="imagePreview">
                            <img src="{{ $dataUser->image === 'default' ? asset('defaultUser.png') : asset('storage/' . $dataUser->image) }}" alt="Image Preview" id="imagePreviewImg">
                        </div>
                        <input type="file" name="image" id="imageInput" accept="image/*">
                    </div>
                    <div class="grid grid-cols-2 gap-1">
                        <div>
                            <div class="form-field-container null">
                                <label for="nama">Nama Lengkap</label>
                                <div class="field-wrapper flex flex-grow">
                                    <input type="text" name="nama" placeholder="Nama" value="{{ $dataUser->nama }}">
                                    <div class="field-border"></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="form-field-container null">
                                <label for="username">Username</label>
                                <div class="field-wrapper flex flex-grow">
                                    <input type="text" name="username" placeholder="Telephone" value="{{ $dataUser->username }}">
                                    <div class="field-border"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-field-container dropdown null">
                        <label for="gender">Gender</label>
                        <div class="myInput field-wrapper flex flex-grow items-baseline">
                            <select class="form-field" name="jenis_kelamin" id="gender">
                                <option value="" disabled {{ $dataUser->jenis_kelamin == '' ? 'selected' : '' }}>Gender</option>
                                <option value="Perempuan" {{ $dataUser->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                <option value="Laki-Laki" {{ $dataUser->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                            </select>
                            <div class="field-border"></div>
                            <div class="field-suffix">
                                <svg viewBox="0 0 20 20" width="1rem" height="1.25rem" focusable="false" aria-hidden="true">
                                    <path d="m10 16-4-4h8l-4 4zm0-12 4 4H6l4-4z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="form-field-container null">
                        <label for="telepon">Telepon</label>
                        <div class="field-wrapper flex flex-grow">
                            <input type="text" name="telepon" placeholder="Telepon" value="{{ $dataUser->telepon }}">
                            <div class="field-border"></div>
                        </div>
                    </div>
                    <div class="form-field-container null">
                        <label for="email">Email</label>
                        <div class="field-wrapper flex flex-grow">
                            <input type="text" placeholder="Email" value="{{ $dataUser->email }}" readonly>
                            <div class="field-border"></div>
                        </div>
                    </div>
                    <div class="form-field-container null">
                        <label for="password">Password</label>
                        <div class="field-wrapper flex flex-grow">
                            <input type="password" name="password" placeholder="Password">
                            <div class="field-border"></div>
                        </div>
                    </div>
                    <div class="form-field-container null">
                        <label for="ulangi-password">Ulangi Password</label>
                        <div class="field-wrapper flex flex-grow">
                            <input type="password" name="password_confirmation" placeholder="Ulangi Password">
                            <div class="field-border"></div>
                        </div>
                    </div>
                    <div class="form-submit-button flex  mt-1 pt-1">
                        <button type="submit" class="button primary speakable">Simpan Perbuahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
