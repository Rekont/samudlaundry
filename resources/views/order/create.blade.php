<x-app-layout>
    <div class="pt-32 pb-20 bg-[#F8FAFC] min-h-screen">
        <div class="max-w-2xl mx-auto px-6">
            <div class="bg-white rounded-[3rem] shadow-2xl overflow-hidden border border-gray-50" 
                 x-data="{ 
                    qty: 1, 
                    price: {{ $service->price }}, 
                    discount: {{ $isMember ? 0.1 : 0 }} 
                 }">
                
                <div class="bg-blue-600 p-10 text-white">
                    <h2 class="text-3xl font-black italic uppercase mb-2">{{ $service->name }}</h2>
                    <p class="opacity-80 font-medium">Konfirmasi detail pesanan Anda di bawah ini.</p>
                </div>

                <div class="p-10">
                    <form action="{{ route('transaction.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">

                        <div class="mb-10">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-4">Jumlah (Kg / Pcs)</label>
                            <input type="number" name="weight" x-model="qty" min="1" 
                                   class="w-full bg-gray-50 border-none rounded-2xl p-5 text-2xl font-black text-gray-800 focus:ring-2 focus:ring-blue-500 transition-all">
                        </div>

                        <div class="bg-gray-50 rounded-[2rem] p-8 space-y-4 mb-10">
                            <div class="flex justify-between text-sm font-bold text-gray-500 uppercase tracking-tighter">
                                <span>Harga Dasar</span>
                                <span x-text="'Rp' + (qty * price).toLocaleString('id-ID')"></span>
                            </div>
                            @if($isMember)
                            <div class="flex justify-between text-sm font-bold text-emerald-600 uppercase tracking-tighter">
                                <span>Diskon Member VIP (10%)</span>
                                <span x-text="'- Rp' + (qty * price * 0.1).toLocaleString('id-ID')"></span>
                            </div>
                            @endif
                            <div class="h-px bg-gray-200 my-2"></div>
                            <div class="flex justify-between items-center text-gray-900">
                                <span class="text-xs font-black uppercase tracking-widest">Total Bayar</span>
                                <span class="text-4xl font-black tracking-tighter" x-text="'Rp' + (qty * price * (1 - discount)).toLocaleString('id-ID')"></span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-6 rounded-2xl font-black text-xl hover:bg-blue-700 shadow-xl shadow-blue-100 transform transition active:scale-95 uppercase italic tracking-widest">
                            Konfirmasi & Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>