<div class="container">
    <h1>Layanan Kami</h1>
    
    @if($isMember)
        <div class="alert alert-success">
            Selamat! Anda adalah <strong>Member VIP</strong>. Nikmati potongan harga!
        </div>
    @else
        <p>Lakukan {{ 5 - Auth::user()->transactions()->where('status', 'completed')->count() }} transaksi lagi untuk jadi Member!</p>
    @endif

    <div class="grid-services">
        @foreach($services as $service)
            <div class="card">
                <h3>{{ $service->name }}</h3>
                <p>{{ $service->description }}</p>
                <p>Harga: Rp {{ number_format($service->price) }}</p>
                
                <form action="{{ route('customer.transaction') }}" method="POST">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <input type="number" name="qty" value="1" min="1">
                    <button type="submit">Pesan Sekarang</button>
                </form>
            </div>
        @endforeach
    </div>
</div>