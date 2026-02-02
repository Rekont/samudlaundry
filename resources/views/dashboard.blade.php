<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg text-blue-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Pesanan</p>
                        <p class="text-2xl font-bold text-gray-800">{{ Auth::user()->transactions()->count() }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 {{ Auth::user()->isMember() ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }} rounded-lg mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04 Pelangi0 10 0 0012 21.314 10 10 0 008.458-11.812z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Status Akun</p>
                        <p class="text-2xl font-bold text-gray-800">{{ Auth::user()->isMember() ? 'Member VIP' : 'Regular' }}</p>
                    </div>
                </div>

                <a href="{{ route('services.index') }}" class="bg-blue-600 p-6 rounded-2xl shadow-lg hover:bg-blue-700 transition group flex items-center justify-between">
                    <div>
                        <p class="text-white font-bold text-lg">Butuh Laundry?</p>
                        <p class="text-blue-100 text-sm italic">Pesan layanan sekarang &rarr;</p>
                    </div>
                    <svg class="w-10 h-10 text-blue-200 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-gray-800">Riwayat Pesanan Terakhir</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold">Layanan</th>
                                <th class="px-6 py-4 font-semibold text-center">Qty</th>
                                <th class="px-6 py-4 font-semibold text-center">Total</th>
                                <th class="px-6 py-4 font-semibold text-center">Status</th>
                                <th class="px-6 py-4 font-semibold text-right">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse(Auth::user()->transactions()->latest()->take(10)->get() as $trans)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800">{{ $trans->service->name }}</div>
                                    <div class="text-xs text-gray-400 font-mono italic">INV-#{{ $trans->id }}</div>
                                </td>
                                <td class="px-6 py-4 text-center font-medium">{{ $trans->weight_or_qty }} kg/pcs</td>
                                <td class="px-6 py-4 text-center font-bold text-blue-600">Rp{{ number_format($trans->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $badge = match($trans->status) {
                                            'pending' => 'bg-amber-100 text-amber-700',
                                            'processing' => 'bg-blue-100 text-blue-700',
                                            'completed' => 'bg-emerald-100 text-emerald-700',
                                            default => 'bg-gray-100 text-gray-700'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badge }}">
                                        {{ strtoupper($trans->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-gray-500">{{ $trans->created_at->diffForHumans() }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Belum ada aktivitas pesanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>