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
                        <img src="{{ asset('images/navlogo.png') }}" alt="Logo Puskesmas" class="h-10 w-auto object-contain">
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

                    @if(Auth::user()->role === 'patient')
                    {{-- Profil Saya --}}
                    <a href="{{ route('patient.profile') }}"
                       class="group relative inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300
                              {{ request()->routeIs('patient.profile')
                                  ? 'text-white'
                                  : 'text-white/70 hover:text-white' }}">
                        @if(request()->routeIs('patient.profile'))
                            <div class="absolute inset-0 bg-white/15 backdrop-blur-sm rounded-xl border border-white/20"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-400/10 to-blue-400/10 rounded-xl"></div>
                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-1 bg-cyan-400 rounded-full shadow-lg shadow-cyan-400/50"></div>
                        @else
                            <div class="absolute inset-0 bg-white/0 hover:bg-white/10 rounded-xl transition-all duration-300"></div>
                        @endif
                        <svg class="w-4 h-4 relative z-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span class="relative z-10">Profil Saya</span>
                    </a>

                    {{-- Daftar Berobat --}}
                    <a href="{{ route('patient.registrations') }}"
                       class="group relative inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300
                              {{ request()->routeIs('patient.registrations')
                                  ? 'text-white'
                                  : 'text-white/70 hover:text-white' }}">
                        @if(request()->routeIs('patient.registrations'))
                            <div class="absolute inset-0 bg-white/15 backdrop-blur-sm rounded-xl border border-white/20"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-400/10 to-blue-400/10 rounded-xl"></div>
                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-1 bg-cyan-400 rounded-full shadow-lg shadow-cyan-400/50"></div>
                        @else
                            <div class="absolute inset-0 bg-white/0 hover:bg-white/10 rounded-xl transition-all duration-300"></div>
                        @endif
                        <svg class="w-4 h-4 relative z-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2" />
                        </svg>
                        <span class="relative z-10">Daftar Berobat</span>
                    </a>

                    {{-- Riwayat Pemeriksaan --}}
                    <a href="{{ route('patient.examinations') }}"
                       class="group relative inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300
                              {{ request()->routeIs('patient.examinations*')
                                  ? 'text-white'
                                  : 'text-white/70 hover:text-white' }}">
                        @if(request()->routeIs('patient.examinations*'))
                            <div class="absolute inset-0 bg-white/15 backdrop-blur-sm rounded-xl border border-white/20"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-400/10 to-blue-400/10 rounded-xl"></div>
                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-1 bg-cyan-400 rounded-full shadow-lg shadow-cyan-400/50"></div>
                        @else
                            <div class="absolute inset-0 bg-white/0 hover:bg-white/10 rounded-xl transition-all duration-300"></div>
                        @endif
                        <svg class="w-4 h-4 relative z-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span class="relative z-10">Riwayat Pemeriksaan</span>
                    </a>

                    {{-- Resep Obat --}}
                    <a href="{{ route('patient.prescriptions') }}"
                       class="group relative inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300
                              {{ request()->routeIs('patient.prescriptions')
                                  ? 'text-white'
                                  : 'text-white/70 hover:text-white' }}">
                        @if(request()->routeIs('patient.prescriptions'))
                            <div class="absolute inset-0 bg-white/15 backdrop-blur-sm rounded-xl border border-white/20"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-400/10 to-blue-400/10 rounded-xl"></div>
                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-1 bg-cyan-400 rounded-full shadow-lg shadow-cyan-400/50"></div>
                        @else
                            <div class="absolute inset-0 bg-white/0 hover:bg-white/10 rounded-xl transition-all duration-300"></div>
                        @endif
                        <svg class="w-4 h-4 relative z-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 0 0-1.022-.547l-2.387-.477a6 6 0 0 0-3.86.517l-.318.158a6 6 0 0 1-3.86.517L6.05 15.21a2 2 0 0 0-1.806.547M8 4h8l-1 1v5.172a2 2 0 0 0 .586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 0 0 9 10.172V5L8 4z" />
                        </svg>
                        <span class="relative z-10">Resep Obat</span>
                    </a>
                    @endif
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
                                    <x-dropdown-link :href="route('logout.get')"
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

                @if(Auth::user()->role === 'patient')
                <a href="{{ route('patient.profile') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-300
                          {{ request()->routeIs('patient.profile')
                              ? 'bg-white/15 text-white border border-white/20 shadow-lg shadow-white/5'
                              : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    Profil Saya
                    @if(request()->routeIs('patient.profile'))
                        <div class="ml-auto w-2 h-2 bg-cyan-400 rounded-full shadow-lg shadow-cyan-400/50"></div>
                    @endif
                </a>

                <a href="{{ route('patient.registrations') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-300
                          {{ request()->routeIs('patient.registrations')
                              ? 'bg-white/15 text-white border border-white/20 shadow-lg shadow-white/5'
                              : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2" />
                    </svg>
                    Daftar Berobat
                    @if(request()->routeIs('patient.registrations'))
                        <div class="ml-auto w-2 h-2 bg-cyan-400 rounded-full shadow-lg shadow-cyan-400/50"></div>
                    @endif
                </a>

                <a href="{{ route('patient.examinations') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-300
                          {{ request()->routeIs('patient.examinations*')
                              ? 'bg-white/15 text-white border border-white/20 shadow-lg shadow-white/5'
                              : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Riwayat Pemeriksaan
                    @if(request()->routeIs('patient.examinations*'))
                        <div class="ml-auto w-2 h-2 bg-cyan-400 rounded-full shadow-lg shadow-cyan-400/50"></div>
                    @endif
                </a>

                <a href="{{ route('patient.prescriptions') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-300
                          {{ request()->routeIs('patient.prescriptions')
                              ? 'bg-white/15 text-white border border-white/20 shadow-lg shadow-white/5'
                              : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 0 0-1.022-.547l-2.387-.477a6 6 0 0 0-3.86.517l-.318.158a6 6 0 0 1-3.86.517L6.05 15.21a2 2 0 0 0-1.806.547M8 4h8l-1 1v5.172a2 2 0 0 0 .586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 0 0 9 10.172V5L8 4z" />
                    </svg>
                    Resep Obat
                    @if(request()->routeIs('patient.prescriptions'))
                        <div class="ml-auto w-2 h-2 bg-cyan-400 rounded-full shadow-lg shadow-cyan-400/50"></div>
                    @endif
                </a>
                @endif
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

                    <a href="{{ route('logout.get') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-rose-300 hover:bg-rose-500/15 hover:text-rose-200 transition-all duration-300 cursor-pointer">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                            </svg>
                            {{ __('Log Out') }}
                        </a>
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