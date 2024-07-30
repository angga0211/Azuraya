<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ $judul }}</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{asset('icon.png')}}">
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('admin/app.css') }}">
        <style>
            .toast-container {
                position: fixed;
                top: 1rem;
                right: 1rem;
                z-index: 1050;
                width: 20rem;
            }
            .myToastHead{
                color: #000;
            }
            .myToast{
                background-color: #fff;
                color: #000;
            }
            .active{
                box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.5);
            }
        </style>
        @yield('css')
    </head>
    <body>
        <div id="app">
            <div class="main-wrapper main-wrapper-1">
                @include('admin.layouts.partials.header')
                @include('admin.layouts.partials.sidebar')
                @if (session()->has('success'))
                    <div class="toast-container">
                        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                            <div class="toast-header bg-success myToastHead">
                                <strong class="mr-auto speakable">Success</strong>
                                <small class="speakable">Just now</small>
                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="toast-body myToast">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="toast-container">
                        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                            <div class="toast-header bg-danger">
                                <strong class="mr-auto speakable">Something Wrong</strong>
                                <small class="speakable">Just now</small>
                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="toast-body">
                                {{ session('error') }}
                            </div>
                        </div>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
        <script src="{{ asset('js/admin/app.js') }}"></script>
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
        <script>
            $(document).ready(function(){
                $('.toast').toast('show');
            });
        </script>
        @yield('js')
    </body>
</html>
