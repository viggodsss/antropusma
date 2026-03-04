<nav x-data="{ open: false, scrolled: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })"
     :class="scrolled ? 'shadow-2xl shadow-indigo-500/20' : ''"
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-500"
     style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 25%, #4338ca 50%, #3b82f6 75%, #06b6d4 100%);">

    {{-- Animated background particles effect --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-4 -left-4 w-24 h-24 bg-white/5 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute top-2 right-1/4 w-16 h-16 bg-cyan-400/10 rounded-full blur-lg animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute -bottom-4 right-10 w-32 h-32 bg-indigo-300/5 rounded-full blur-2xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    {{-- Glass border bottom --}}
    <div class="absolute bottom-0 left-0 right-0 h-[1px] bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        {{-- Logo SVG Antropusma --}}
                        <div class="relative">
                            <div class="absolute inset-0 bg-cyan-400/40 rounded-xl blur-md group-hover:blur-lg transition-all duration-500 group-hover:bg-cyan-300/50"></div>
                            <div class="relative bg-white/15 backdrop-blur-xl p-2 rounded-xl border border-white/20 group-hover:border-white/40 group-hover:bg-white/25 transition-all duration-500 group-hover:scale-105">
                               
                                    <path d="M12 3.5L5 7.5V12.5C5 16.8 7.9 20.8 12 22C16.1 20.8 19 16.8 19 12.5V7.5L12 3.5Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 8V15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                    <path d="M8.5 11.5H15.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                </svg>
                            </div>
                        </div>
                        <div class="hidden sm:block">
                            <span class="text-lg font-extrabold text-white tracking-tight drop-shadow-lg">Sistem Antrian</span>
                            <div class="flex items-center gap-1.5 -mt-0.5">
                                <div class="h-[2px] w-4 bg-gradient-to-r from-cyan-400 to-transparent rounded-full"></div>
                                <span class="text-[10px] font-bold text-cyan-300/90 tracking-[0.2em] uppercase">Puskesmas</span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:ms-10 sm:flex items-center gap-1">
                    <a href="{{ route('dashboard') }}"
                       class="group relative inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300
                              {{ request()->routeIs('dashboard')
                                  ? 'text-white'
                                  : 'text-white/70 hover:text-white' }}">
                        @if(request()->routeIs('dashboard'))
                            <div class="absolute inset-0 bg-white/15 backdrop-blur-sm rounded-xl border border-white/20"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-400/10 to-blue-400/10 rounded-xl"></div>
                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-1 bg-cyan-400 rounded-full shadow-lg shadow-cyan-400/50"></div>
                        @else
                            <div class="absolute inset-0 bg-white/0 hover:bg-white/10 rounded-xl transition-all duration-300"></div>
                        @endif
                        <svg class="w-4 h-4 relative z-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span class="relative z-10">{{ __('Dashboard') }}</span>
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-3">
                {{-- Notification Bell --}}
                <button class="hidden sm:inline-flex relative p-2.5 rounded-xl text-white/60 hover:text-white hover:bg-white/10 transition-all duration-300 group">
                    <svg class="w-5 h-5 group-hover:animate-swing" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-indigo-800 animate-pulse"></span>
                </button>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="group flex items-center gap-3 px-2 py-1.5 rounded-2xl text-sm font-medium text-white bg-white/10 backdrop-blur-xl border border-white/10 hover:bg-white/20 hover:border-white/30 focus:outline-none focus:ring-2 focus:ring-cyan-400/50 transition-all duration-300">
                                <div class="relative">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-400 via-orange-500 to-rose-500 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-orange-500/30 group-hover:shadow-orange-500/50 transition-all duration-300 group-hover:scale-105">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 rounded-full border-2 border-indigo-800"></div>
                                </div>
                                <div class="text-left hidden lg:block">
                                    <div class="text-sm font-bold text-white leading-tight">{{ Auth::user()->name }}</div>
                                    <div class="text-[10px] text-white/50 leading-tight">Administrator</div>
                                </div>
                                <svg class="fill-current h-4 w-4 text-white/50 group-hover:text-white transition-all duration-500 group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-4 bg-gradient-to-br from-indigo-50 to-blue-50 border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 via-orange-500 to-rose-500 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                        <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-700">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                            Online
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="py-1">
                                <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-3 px-4 py-2.5 hover:bg-indigo-50 transition-colors duration-200">
                                    <div class="p-1.5 bg-indigo-100 rounded-lg">
                                        <svg class="w-4 h-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-700">{{ __('Profile') }}</span>
                                        <span class="block text-[10px] text-gray-400">Kelola akun kamu</span>
                                    </div>
                                </x-dropdown-link>
                            </div>

                            <div class="border-t border-gray-100 py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="flex items-center gap-3 px-4 py-2.5 hover:bg-red-50 transition-colors duration-200 group/logout">
                                        <div class="p-1.5 bg-red-100 rounded-lg group-hover/logout:bg-red-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-red-600">{{ __('Log Out') }}</span>
                                            <span class="block text-[10px] text-red-400">Keluar dari sistem</span>
                                        </div>
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="relative p-2.5 rounded-xl text-white/80 hover:text-white hover:bg-white/10 focus:outline-none transition-all duration-300 group">
                    <svg class="h-6 w-6 transition-transform duration-300" :class="{'rotate-90': open}" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}"
         class="hidden sm:hidden"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4">

        <div class="bg-white/10 backdrop-blur-2xl border-t border-white/10">
            <div class="pt-3 pb-3 space-y-1 px-4">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-300
                          {{ request()->routeIs('dashboard')
                              ? 'bg-white/15 text-white border border-white/20 shadow-lg shadow-white/5'
                              : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    {{ __('Dashboard') }}
                    @if(request()->routeIs('dashboard'))
                        <div class="ml-auto w-2 h-2 bg-cyan-400 rounded-full shadow-lg shadow-cyan-400/50"></div>
                    @endif
                </a>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-5 border-t border-white/10 px-4">
                <div class="flex items-center gap-3 px-4 mb-4">
                    <div class="relative">
                        {{-- Logo di mobile menu --}}
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 via-orange-500 to-rose-500 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-orange-500/30">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-400 rounded-full border-2 border-indigo-900"></div>
                    </div>
                    <div>
                        <div class="font-bold text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-xs text-white/50">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="space-y-1">
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-white/70 hover:bg-white/10 hover:text-white transition-all duration-300">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        {{ __('Profile') }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-rose-300 hover:bg-rose-500/15 hover:text-rose-200 transition-all duration-300 cursor-pointer">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                            </svg>
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

{{-- Spacer agar konten tidak tertutup fixed navbar --}}
<div class="h-16"></div>

{{-- Custom animation styles --}}
<style>
    @keyframes swing {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(12deg); }
        50% { transform: rotate(-8deg); }
        75% { transform: rotate(5deg); }
    }
    .group:hover .group-hover\:animate-swing {
        animation: swing 0.6s ease-in-out;
    }
</style>