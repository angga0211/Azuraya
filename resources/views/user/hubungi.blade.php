@extends('user.index')
@section('konten')
<main class="content">
    <div class="page-width my-2"><span><a href="/" class="text-interactive">Home</a><span> /
            </span></span><span>Hubungi kami</span></div>
    <div class="flex justify-center items-center">
        <div class="login-form flex justify-center items-center">
            <div class="login-form-inner">
                <h3 class="text-center speakable mb-1">Hubungi Kami</h3>
                <div class="centered-box">
                    <img style="object-fit: cover;height: 100px; width: 100px;" src="{{  asset('icon.png') }}" alt="">
                </div>
                <ul class="mt-3 text-center" style="font-size: 16px;">
                    <li> 
                        <a class="speakable" href="https://ig.me/m/yuka3vt"> <i class="fa fa-instagram" aria-hidden="true"></i> Instagram: yuka3vt</a>
                    </li>
                    <li> 
                        <a class="speakable" href="http://www.facebook.com/yuka.wardana.37"> <i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook: Yuka Wardana</a>
                    </li>
                    <li> 
                        <a class="speakable" href="https://wa.me/+62895377343574"> <i class="fa fa-whatsapp" aria-hidden="true"></i> WhatsApp: 0895377343574</a>
                    </li>
                    <li> 
                        <a class="speakable" href="mailto:yukawardana587@gmail.com"> <i class="fa fa-envelope-o" aria-hidden="true"></i> Email: yukawardana587@gmail.com</a>
                    </li>
                </ul>
                <h3 class="speakable" class="text-center speakable mb-1 mt-2">Alamat</h3>
                <ul style="font-size: 16px;text-align: justify">
                    <li class="speakable">
                        <i class="fa fa-map-marker" aria-hidden="true"></i> Jl. Raya Jakarta Barat No. 32, Cibinong, Kecamatan Cibinong, Kabupaten Bekasi, Jawa Barat 17850
                    </li>
                </ul>
            </div>
        </div>
    </div>
</main>
@endsection
