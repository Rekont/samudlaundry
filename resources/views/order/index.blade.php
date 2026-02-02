<x-app-layout>
    <div class="pt-32 pb-20 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="text-center mb-16 transform transition-all duration-700 translate-y-0 opacity-100">
                <span class="bg-blue-100 text-blue-600 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest mb-4 inline-block">Premium Laundry Service</span>
                <h1 class="text-5xl md:text-6xl font-black text-gray-900 mb-6 tracking-tight">Cucian Bersih,<br><span class="text-blue-600">Hati Tenang.</span></h1>
            </div>

            @auth
            <div class="max-w-3xl mx-auto mb-16">
                @if($isMember)
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-8 rounded-[2.5rem] shadow-2xl shadow-blue-200 text-white flex justify-between items-center relative overflow-hidden">
                        <div class="relative z-10">
                            <h2 class="text-2xl font-black italic mb-1 uppercase text-blue-200">Member VIP Aktif</h2>
                            <p class="text-lg font-medium">Nikmati Diskon 10% di setiap transaksi Anda!</p>
                        </div>
                        <div class="text-6xl opacity-20 absolute -right-2 -bottom-2 rotate-12">💎</div>
                    </div>
                @else
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                        <div class="flex justify-between items-end mb-4">
                            <h3 class="font-black text-gray-800 uppercase italic">Progress Member VIP</h3>
                            <span class="text-blue-600 font-black text-xl">{{ $completedCount }}/5</span>
                        </div>
                        <div class="w-full bg-gray-100 h-4 rounded-full overflow-hidden p-1">
                            <div class="bg-blue-600 h-full rounded-full transition-all duration-1000 shadow-lg" style="width: {{ ($completedCount / 5) * 100 }}%"></div>
                        </div>
                        <p class="mt-4 text-sm text-gray-400 font-medium italic">*Selesaikan {{ $remainingToMember }} transaksi lagi untuk mendapatkan diskon permanen.</p>
                    </div>
                @endif
            </div>
            @endauth

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @foreach($services as $service)
                <div class="bg-white rounded-[3rem] p-10 shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-50 group flex flex-col justify-between">
                    <div>
                        <div class="w-16 h-16 bg-blue-50 rounded-3xl flex items-center justify-center text-blue-600 mb-8 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-gray-800 mb-3">{{ $service->name }}</h3>
                        <p class="text-gray-400 text-sm leading-relaxed mb-8">{{ $service->description }}</p>
                    </div>
                    
                    <div class="pt-6 border-t border-gray-50 flex items-center justify-between">
                        <div>
                            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Harga / Kg</p>
                            <p class="text-3xl font-black text-gray-900">Rp{{ number_format($service->price, 0, ',', '.') }}</p>
                        </div>
                        <a href="{{ route('transaction.create', $service->id) }}" class="w-14 h-14 bg-gray-900 text-white rounded-2xl flex items-center justify-center hover:bg-blue-600 transition-colors shadow-xl active:scale-90 transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>