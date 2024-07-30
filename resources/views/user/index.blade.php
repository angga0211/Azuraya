@extends('base')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('style.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
@section('body')

<body id="body">
    <div id="app" class="bg-background">
        <div class="wrapper">
            @include('partials.header')
            @if (session()->has('success'))
                <div id="snackbar" class="show bg-success">
                    <div class="snackbar-header">
                        <span>Success !</span>
                        <span class="close-btn" onclick="closeSnackbar()">×</span>
                    </div>
                    <hr class="snackbar-divider">
                    <div class="snackbar-body">{{ session('success') }}</div>
                </div>
            @endif
            @if (session()->has('error'))
                <div id="snackbar" class="show bg-danger">
                    <div class="snackbar-header">
                        <span>Something Wrong !</span>
                        <span class="close-btn" onclick="closeSnackbar()">×</span>
                    </div>
                    <hr class="snackbar-divider">
                    <div class="snackbar-body">{{ session('error') }}</div>
                </div>
            @endif
            @yield('konten')
            @include('partials.footer')
        </div>
    </div>
    <script src="{{ asset('script.js') }}"></script>
    <script>
        function closeSnackbar() {
            document.getElementById("snackbar").classList.remove("show");
        }
        window.onload = function () {
            const snackbar = document.getElementById("snackbar");
            snackbar.classList.add("show");
            setTimeout(function () {
                snackbar.classList.remove("show");
            }, 3500);
        };
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const speakables = document.querySelectorAll('.speakable');
            function getVoiceByLang(lang) {
                const voices = window.speechSynthesis.getVoices();
                return voices.find(voice => voice.lang === lang);
            }
            function speakText(text) {
                window.speechSynthesis.cancel();
                const utterance = new SpeechSynthesisUtterance(text);
                const voice = getVoiceByLang('id-ID');
                if (voice) {
                    utterance.voice = voice;
                }
                utterance.lang = 'id-ID';
                window.speechSynthesis.speak(utterance);
            }
            window.speechSynthesis.onvoiceschanged = () => {
                speakables.forEach(element => {
                    element.addEventListener('mouseover', () => {
                        speakText(element.textContent);
                    });
                });
            };
        });
    </script>
</body>
@endsection
