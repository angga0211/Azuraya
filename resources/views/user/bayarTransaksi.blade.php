@extends('user.index')
@section('konten')
<main class="content">
    <div class="page-width my-2">
        <span>
            <a href="/" class="text-interactive speakable">Home</a>
            <span> / </span>
        </span>
        <span class="speakable">Pembayaran</span>
    </div>
    <div class="empty-shopping-cart w-100" style="margin-top:150px">
        <div class="empty-shopping-cart w-100" style="margin-top:150px">
            <div>
                <div class="text-center speakable">
                    <h2>Transaksi Kamu Berhasil Dibuat</h2>
                </div>
                <div class="mt-2 text-center speakable">
                    <h3>Total Pembayaran</h3>
                    <div class="flex justify-center">
                        <h4 class="totalBayar">Rp. {{ number_format($dataPesanan->subtotal, 0, ',', '.') }}</h4>
                    </div>
                </div>
                <div class="flex justify-center mt-2">
                    <button class="btn-bayar" id="pay-button">
                        <span>
                            <span class="flex space-x-1">
                                <span class="self-center speakable">Lakukan Pembayaran</span>
                                <svg class="self-center" style="width:2.5rem;height:2.5rem"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
      snap.pay('{{ $dataPesanan->snap_token }}', {
        onSuccess: function(result){
            window.location.href = '/pembayaran-berhasil/{{ auth()->user()->username }}/{{ $dataPesanan->invoice }}';
        },
        onPending: function(result){

        },
        onError: function(result){

        }
      });
    };
  </script>
@endsection
