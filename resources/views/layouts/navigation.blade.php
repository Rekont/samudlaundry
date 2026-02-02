<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 10) ? true : false"
     :class="{ 'bg-white/70 backdrop-blur-md shadow-lg': scrolled, 'bg-white': !scrolled }"
     class="fixed w-full z-50 transition-all duration-500 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('services.index') }}" class="flex items-center gap-3 group">
                        <div class="p-2 bg-blue-600 rounded-2xl shadow-lg group-hover:rotate-12 transition-all">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <span class="font-black text-2xl tracking-tighter text-gray-800 uppercase">Samud<span class="text-blue-600">Laundry</span></span>
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-6">
                <x-nav-link :href="route('services.index')" :active="request()->routeIs('services.index')" class="font-bold">Layanan</x-nav-link>
                @auth
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-bold">Dashboard</x-nav-link>
                    
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 bg-gray-50 p-1.5 pr-4 rounded-full hover:bg-gray-100 transition border border-gray-100">
                                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs uppercase">{{ substr(Auth::user()->name, 0, 1) }}</div>
                                <span class="text-sm font-bold text-gray-700">{{ Auth::user()->name }}</span>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Profil</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 font-bold">Logout</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-500 hover:text-blue-600">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-2xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition transform hover:scale-105">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>