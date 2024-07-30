@extends('user.index')
@section('konten')
<main class="content">
    <div class="page-width my-2"><span><a href="/" class="text-interactive speakable">Home</a><span> /
            </span></span><span class="speakable">Tentang kami</span></div>
    <div class="flex justify-center items-center">
        <div class="about-form flex justify-center items-center">
            <div class="login-form-inner">
                <div class="centered-box">
                    <img style="object-fit: cover;height: 100px; width: 100px;" src="{{  asset('icon.png') }}" alt="">
                </div>
                <h3 class="text-center speakable mb-1">Tentang Kami</h3>
                <p class="mt-2 text-center speakable" style="font-size: 16px">
                    Selamat datang di Azuraya, toko vapor terkemuka yang menyediakan beragam produk berkualitas tinggi untuk memenuhi kebutuhan Anda. Kami berdedikasi untuk memberikan pengalaman vaping terbaik dengan produk-produk terbaik dan layanan pelanggan yang luar biasa.
                </p>
                <h3 class="text-center speakable mb-1 mt-2">Visi Kami</h3>
                <p style="font-size: 16px;text-align: center" class="speakable">
                    Visi kami adalah menjadi toko vapor yang paling dipercaya dan dihormati, tidak hanya di komunitas lokal, tetapi juga di seluruh negeri. Kami berusaha untuk terus berinovasi dan memperkenalkan produk-produk terbaru yang dapat memberikan pengalaman vaping yang aman dan menyenangkan.
                </p>
                <h3 class="text-center speakable mb-1 mt-2">Misi Kami</h3>
                <p style="font-size: 16px;text-align: center" class="speakable">
                    Misi kami adalah menyediakan berbagai pilihan produk vapor berkualitas tinggi, dari perangkat vapor, e-liquid, hingga aksesoris lainnya. Kami berkomitmen untuk memastikan setiap pelanggan kami menemukan produk yang sesuai dengan preferensi dan kebutuhan mereka.
                </p>
            </div>
        </div>
    </div>
</main>
@endsection
