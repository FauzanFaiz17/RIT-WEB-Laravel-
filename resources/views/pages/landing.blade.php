@extends('layouts.fullscreen-layout')

@section('content')
<!-- Custom Styles for RIT Color Palette (Definitions/Animations Only) -->
<style>
    :root {
        --rit-black: #1C1515;
        --rit-cyan: #05D9E7;
    }
    
    .rit-gradient-text {
        background: linear-gradient(90deg, #05D9E7 0%, #2563EB 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .dark .rit-gradient-text {
        background: linear-gradient(90deg, #05D9E7 0%, #FFFFFF 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .rit-card {
        transition: all 0.3s ease;
    }
    .rit-card:hover {
        transform: translateY(-5px);
    }

    /* Smooth Scroll Behavior */
    html {
        scroll-behavior: smooth;
    }
</style>

<div class="bg-gray-50 dark:bg-[#0a0a0a] min-h-screen text-gray-900 dark:text-white overflow-x-hidden selection:bg-[#05D9E7] selection:text-[#1C1515]">

    @php
        $menus = [
            [
                'name' => 'Home', 
                'href' => '#home', 
                'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'
            ],
            [
                'name' => 'About', 
                'href' => '#about', 
                'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
            ],
            [
                'name' => 'Journey', 
                'href' => '#journey', 
                // REVISI: Icon Compass (Kompas)
                'icon' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm2.19 12.19L6 18l3.81-8.19L18 6l-3.81 8.19z'
            ],
            [
                'name' => 'Community', 
                'href' => '#divisions', 
                'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
            ],
        ];
    @endphp

    <nav 
        x-data="{ 
            current: '{{ Request::path() == '/' ? 'Home' : '' }}',
            active: '{{ Request::path() == '/' ? 'Home' : '' }}', 
            scrolled: false,
            mobileMenuOpen: false
        }"
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        class="fixed inset-x-0 z-50 mx-auto transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] flex flex-col items-center"
        :class="{ 'top-5 w-[95%] max-w-7xl': !scrolled, 'top-0 w-full': scrolled }"
    >
        
        <div class="relative w-full bg-white/80 dark:bg-[#1C1515]/80 backdrop-blur-xl border border-gray-200 dark:border-white/10 
                    shadow-[0_0_20px_rgba(5,217,231,0.1)] dark:shadow-[0_0_25px_rgba(5,217,231,0.15)]
                    h-[65px] flex items-center justify-between px-3 pr-4 transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)]"
             :class="{ 'rounded-full': !scrolled, 'rounded-none border-x-0': scrolled }">
            
            <div class="flex items-center gap-1">
                <a href="{{ url('/') }}" class="flex items-center justify-center w-12 h-12 rounded-full hover:bg-gray-100 dark:hover:bg-white/5 transition-colors group">
                    <img src="{{ asset('images/logo/rit-logo.png') }}" alt="RIT Logo" class="w-8 h-8 object-contain transition-transform group-hover:scale-110 drop-shadow-[0_0_5px_rgba(5,217,231,0.5)]">
                </a>
                
                <div class="hidden lg:block h-6 w-px bg-gray-300 dark:bg-white/20 mx-1"></div>

                <div class="hidden lg:flex items-center gap-1" @mouseleave="active = current">
                    @foreach($menus as $menu)
                        <a href="{{ $menu['href'] }}"
                           @mouseenter="active = '{{ $menu['name'] }}'" 
                           @click="current = '{{ $menu['name'] }}'; active = '{{ $menu['name'] }}'"
                           class="relative flex items-center justify-center h-10 px-3 rounded-full transition-colors duration-300"
                           :class="active === '{{ $menu['name'] }}' 
                                ? 'bg-[#05D9E7]/10 text-[#05D9E7] dark:text-[#05D9E7]' 
                                : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5'"
                        >
                            <div class="flex items-center justify-center">
                                <svg class="w-5 h-5 transition-transform duration-300" 
                                     :class="active === '{{ $menu['name'] }}' ? 'scale-110' : 'scale-100'"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}"></path>
                                </svg>
                            </div>

                            <div class="overflow-hidden flex items-center transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)]"
                                 :style="active === '{{ $menu['name'] }}' 
                                    ? 'max-width: 120px; opacity: 1; margin-left: 8px;' 
                                    : 'max-width: 0px; opacity: 0; margin-left: 0px;'">
                                <span class="text-sm font-semibold whitespace-nowrap">{{ $menu['name'] }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-1 ml-auto">
                
                <div @mouseleave="active = current">
                    <a href="#join" 
                       @mouseenter="active = 'Join Us'" 
                       class="hidden lg:flex relative group items-center justify-center h-10 px-4 rounded-full transition-all duration-300"
                       :class="active === 'Join Us' ? 'bg-[#05D9E7]/10 text-[#05D9E7]' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5'">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            <span class="overflow-hidden whitespace-nowrap transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)]"
                                  :style="active === 'Join Us' ? 'max-width: 100px; opacity: 1; margin-left: 8px;' : 'max-width: 0; opacity: 0; margin-left: 0;'">
                                Join Us
                            </span>
                        </div>
                    </a>
                </div>

                <div class="hidden lg:block h-4 w-px bg-gray-300 dark:bg-white/20 mx-1"></div>

                @auth
                    <a href="{{ route('dashboard') }}" class="hidden md:block text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-[#05D9E7] transition-colors px-3">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-[#05D9E7] transition-colors px-3">Login</a>
                @endauth

                <!-- <button x-on:click="$store.theme.toggle()" class="ml-1 w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-white/10 transition-colors focus:outline-none">
                    <svg x-show="$store.theme.theme === 'light'" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <svg x-show="$store.theme.theme === 'dark'" style="display: none;" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                </button> -->

                <button 
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden ml-1 w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-white/10 text-gray-500 dark:text-gray-400 focus:outline-none"
                >
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                    <svg x-show="mobileMenuOpen" style="display: none;" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>

        <div 
            x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
            class="lg:hidden w-full mt-2 bg-white/90 dark:bg-[#1C1515]/95 backdrop-blur-xl border border-white/10 rounded-3xl overflow-hidden shadow-2xl p-2"
            style="display: none;"
        >
            <div class="flex flex-col gap-1">
                @foreach($menus as $menu)
                    <a href="{{ $menu['href'] }}" @click="mobileMenuOpen = false; current = '{{ $menu['name'] }}'; active = '{{ $menu['name'] }}'" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#05D9E7]/10 text-gray-600 dark:text-gray-300 hover:text-[#05D9E7] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}"></path></svg>
                        <span class="font-medium">{{ $menu['name'] }}</span>
                    </a>
                @endforeach
                
                <div class="h-px bg-gray-200 dark:bg-white/10 my-1 mx-2"></div>
                
                <a href="#join" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#05D9E7]/10 text-gray-600 dark:text-gray-300 hover:text-[#05D9E7] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    <span class="font-medium">Join Us</span>
                </a>
            </div>
        </div>

    </nav>

<!-- SECTION 1: HERO -->
<section 
    x-data="{ 
        mouse: { x: 0, y: 0 },
        init() {
            window.addEventListener('mousemove', (e) => {
                this.mouse.x = (e.clientX / window.innerWidth) - 0.5;
                this.mouse.y = (e.clientY / window.innerHeight) - 0.5;
            });
        }
    }"
    class="relative min-h-screen w-full bg-[#0a0a0a] overflow-hidden flex items-center justify-center pt-24 pb-12 lg:pt-28 lg:pb-0"
>
    <style>
        /* Putaran sangat lambat (2 menit per putaran) */
        @keyframes spin-very-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-very-slow {
            animation: spin-very-slow 120s linear infinite;
        }
    </style>

   
    <div class="absolute inset-0 pointer-events-none">
        
        <div class="absolute inset-0 z-10 bg-gradient-to-t from-[#0a0a0a] via-[#0a0a0a]/80 to-transparent"></div>

        <div 
            class="absolute inset-0 w-full h-full opacity-40"
            style="perspective: 1200px; transform: perspective(1200px) rotateX(15deg); transform-origin: center bottom;"
        >
            <div class="absolute inset-0 animate-spin-very-slow">
                <div class="absolute top-1/2 left-1/2 w-[800px] h-[800px] md:w-[1200px] md:h-[1200px] -translate-x-1/2 -translate-y-1/2 rotate-[279deg]">
                    
                    <img 
                        src="{{ asset('images/hero/ring-outer.png') }}" 
                        onerror="this.style.display='none'"
                        class="w-full h-full object-contain opacity-30" 
                        alt="RIT Divisions Ring"
                    >
                </div>
            </div>
        </div>
    </div>

    <div class="absolute inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[400px] h-[400px] bg-[#05D9E7]/10 rounded-full mix-blend-screen filter blur-[80px] animate-pulse"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[500px] h-[500px] bg-blue-900/20 rounded-full mix-blend-screen filter blur-[100px]"></div>
    </div>

    <div class="relative z-20 max-w-7xl mx-auto px-6 w-full flex flex-col md:flex-row items-center justify-center gap-10 lg:gap-32">
        
        <div 
            class="relative w-full max-w-[240px] md:max-w-xs lg:max-w-sm shrink-0 flex items-center justify-center group order-1"
            :style="`transform: perspective(1000px) rotateY(${mouse.x * 10}deg) rotateX(${mouse.y * -10}deg); transition: transform 0.1s ease-out;`"
        >
            <div class="absolute inset-[-10%] rounded-full border border-dashed border-[#05D9E7]/20 animate-[spin_20s_linear_infinite]"></div>
            <div class="absolute inset-[-5%] rounded-full border border-gray-200 dark:border-white/5 animate-[spin_15s_linear_infinite_reverse]"></div>
            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-[#05D9E7] to-blue-600 blur-[50px] opacity-20 animate-pulse"></div>

            <div class="relative h-90 w-66 md:h-90 md:w-82 lg:h-90 lg:w-90 rounded-full border border-white/20 shadow-2xl flex items-center justify-center overflow-hidden bg-white/10 dark:bg-black/20 backdrop-blur-md">
                <img 
                    src="{{ asset('images/logo/rit-logo.png') }}" 
                    alt="RIT Logo" 
                    class="w-[87%] h-[87%] object-contain drop-shadow-[0_20px_50px_rgba(5,217,231,0.3)] transition-transform duration-700 hover:scale-110"
                >
            </div>

            <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 whitespace-nowrap">
                <div class="flex items-center gap-2 text-[10px] md:text-xs uppercase tracking-widest text-gray-500 dark:text-zinc-500 bg-white/80 dark:bg-zinc-950/80 px-3 py-1.5 rounded-full border border-gray-200 dark:border-white/5 backdrop-blur shadow-lg">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#05D9E7] animate-pulse"></span>
                    System Active
                </div>
            </div>
        </div>

        <div class="w-full text-center md:text-left flex flex-col order-2 mt-6 md:mt-0">
            <h2 class="text-[#05D9E7] font-bold tracking-[0.2em] uppercase text-[10px] md:text-xs mb-3 animate-[fadeIn_1s_ease-out]">
                Welcome to RIT
            </h2>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight mb-6 text-white leading-[1.1]">
                Republic of <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#05D9E7] to-blue-600 dark:to-white">
                    Information Technology
                </span>
            </h1>

            <div class="max-w-lg mx-auto md:mx-0 mb-8 space-y-4">
                <p class="text-gray-300 text-sm md:text-base leading-relaxed font-medium">
                    Ruang eksplorasi bagi mahasiswa Fakultas Komunikasi dan Informasi Universitas Garut untuk mewujudkan ide menjadi sebuah aksi melalui teknologi.
                </p>
                <p class="text-gray-400 text-sm md:text-sm leading-relaxed">
                    Melalui komunitas suportif yang mengedepankan eksperimen, pengembangan, dan penerapan teknologi.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full justify-center md:justify-start">
                <a href="#divisions" class="group relative px-6 py-3 rounded-full bg-[#05D9E7] text-[#1C1515] font-bold overflow-hidden shadow-lg shadow-cyan-500/30 transition-all hover:scale-105">
                    <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                    <span class="relative flex items-center gap-2 text-sm">
                        Explore RIT
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </span>
                </a>
                
                <a href="#join" class="px-6 py-3 rounded-full border border-white/20 text-white font-semibold hover:bg-white/5 transition-all hover:scale-105 text-sm">
                    Join Us
                </a>
            </div>
        </div>
    </div>
</section>

    <!-- SECTION 2: VALUE SNAPSHOT -->
<section class="py-24 bg-white dark:bg-[#0a0a0a] border-t border-gray-100 dark:border-white/5 relative overflow-hidden">
    
    <style>
        /* Utility 3D */
        .perspective-1000 { perspective: 1000px; }
        .transform-style-3d { transform-style: preserve-3d; }
        .backface-hidden { backface-visibility: hidden; -webkit-backface-visibility: hidden; }
        .rotate-y-180 { transform: rotateY(180deg); }
        
        /* Efek Kilatan (Shine) - Bergerak saat Hover */
        .rit-shine {
            position: relative;
            overflow: hidden;
        }
        .rit-shine::after {
            content: '';
            position: absolute;
            top: 0;
            left: -150%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                to right,
                transparent 0%,
                rgba(255, 255, 255, 0.1) 50%,
                transparent 100%
            );
            transform: skewX(-25deg);
            transition: left 0.7s ease-in-out;
            pointer-events: none;
        }
        .group:hover .rit-shine::after {
            left: 150%;
        }
    </style>

    <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150 mix-blend-overlay pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        
        <div class="flex flex-col md:flex-row items-baseline justify-center gap-4 mb-16 text-center md:text-left">
            <span class="text-[#05D9E7] font-bold tracking-widest text-xs uppercase">
                OUR CORE VALUES
            </span>
            <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white uppercase tracking-[0.2em] leading-none">
                THE RIT WAY
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div x-data="glitchCard()" class="group perspective-1000 cursor-pointer h-[320px]" @click="flip()">
                <div class="relative w-full h-full transition-all duration-700 transform-style-3d rounded-2xl"
                     :class="isFlipped ? 'rotate-y-180' : 'hover:scale-[1.02]'">
                    
                    <div class="absolute inset-0 w-full h-full backface-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#05D9E7]/50 to-blue-600/30 rounded-2xl p-[1px]">
                            <div class="rit-shine w-full h-full bg-white dark:bg-[#121212] rounded-2xl overflow-hidden relative">
                                <div class="absolute inset-0 opacity-10 dark:opacity-20 pointer-events-none">
                                    <canvas x-ref="canvas" class="w-full h-full block"></canvas>
                                </div>
                                <div class="absolute inset-0 bg-[radial-gradient(circle,transparent_40%,#ffffff_100%)] dark:bg-[radial-gradient(circle,transparent_40%,#121212_100%)] pointer-events-none"></div>
                                
                                <div class="absolute inset-0 flex flex-col items-center justify-center p-6 z-10">
                                    <div class="w-16 h-16 mb-4 rounded-full bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center shadow-[0_0_15px_rgba(5,217,231,0.2)]">
                                        <svg class="w-8 h-8 text-[#05D9E7]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-black tracking-widest text-gray-900 dark:text-white uppercase">CONNECT</h3>
                                    <div class="mt-2 h-0.5 w-8 bg-[#05D9E7]"></div>
                                    
                                    <div class="absolute bottom-4 right-4 text-gray-400 opacity-50 text-xs flex items-center gap-1 animate-pulse">
                                        <span>Click to flip</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute inset-0 w-full h-full backface-hidden rotate-y-180">
                        <div class="absolute inset-0 bg-gradient-to-bl from-[#05D9E7] to-blue-600 rounded-2xl p-[1px]">
                            <div class="rit-shine w-full h-full bg-gray-50 dark:bg-[#0a0a0a] rounded-2xl overflow-hidden flex flex-col items-center justify-center p-6 text-center relative">
                                
                                <div class="absolute top-0 right-0 w-32 h-32 bg-[#05D9E7]/10 rounded-bl-full blur-2xl"></div>

                                <h4 class="text-lg font-bold mb-6 text-[#05D9E7] tracking-widest uppercase border-b border-[#05D9E7]/30 pb-1">
                                    CONNECT
                                </h4>
                                
                                <div class="space-y-2 z-10">
                                    <p class="text-xl md:text-2xl text-gray-800 dark:text-white font-bold leading-tight">
                                        Jalin Ikatan.
                                    </p>
                                    <p class="text-base text-gray-500 dark:text-gray-400 font-mono">
                                        Temukan Arah.
                                    </p>
                                </div>

                                <div class="absolute bottom-4 right-4 text-gray-500 hover:text-[#05D9E7] transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div x-data="glitchCard()" class="group perspective-1000 cursor-pointer h-[320px]" @click="flip()">
                <div class="relative w-full h-full transition-all duration-700 transform-style-3d rounded-2xl"
                     :class="isFlipped ? 'rotate-y-180' : 'hover:scale-[1.02]'">
                    
                    <div class="absolute inset-0 w-full h-full backface-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/50 to-cyan-500/30 rounded-2xl p-[1px]">
                            <div class="rit-shine w-full h-full bg-white dark:bg-[#121212] rounded-2xl overflow-hidden relative">
                                <div class="absolute inset-0 opacity-10 dark:opacity-20 pointer-events-none">
                                    <canvas x-ref="canvas" class="w-full h-full block"></canvas>
                                </div>
                                <div class="absolute inset-0 bg-[radial-gradient(circle,transparent_40%,#ffffff_100%)] dark:bg-[radial-gradient(circle,transparent_40%,#121212_100%)] pointer-events-none"></div>
                                
                                <div class="absolute inset-0 flex flex-col items-center justify-center p-6 z-10">
                                    <div class="w-16 h-16 mb-4 rounded-full bg-blue-500/10 border border-blue-500/20 flex items-center justify-center shadow-[0_0_15px_rgba(37,99,235,0.2)]">
                                        <svg class="w-8 h-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-black tracking-widest text-gray-900 dark:text-white uppercase">CREATE</h3>
                                    <div class="mt-2 h-0.5 w-8 bg-blue-500"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute inset-0 w-full h-full backface-hidden rotate-y-180">
                        <div class="absolute inset-0 bg-gradient-to-bl from-blue-500 to-cyan-500 rounded-2xl p-[1px]">
                            <div class="rit-shine w-full h-full bg-gray-50 dark:bg-[#0a0a0a] rounded-2xl overflow-hidden flex flex-col items-center justify-center p-6 text-center relative">
                                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-bl-full blur-2xl"></div>
                                
                                <h4 class="text-lg font-bold mb-6 text-blue-500 tracking-widest uppercase border-b border-blue-500/30 pb-1">
                                    CREATE
                                </h4>
                                
                                <div class="space-y-2 z-10">
                                    <p class="text-xl md:text-2xl text-gray-800 dark:text-white font-bold leading-tight">
                                        Wujudkan Karya.
                                    </p>
                                    <p class="text-base text-gray-500 dark:text-gray-400 font-mono">
                                        Beri Makna.
                                    </p>
                                </div>
                                <div class="absolute bottom-4 right-4 text-gray-500 hover:text-blue-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div x-data="glitchCard()" class="group perspective-1000 cursor-pointer h-[320px]" @click="flip()">
                <div class="relative w-full h-full transition-all duration-700 transform-style-3d rounded-2xl"
                     :class="isFlipped ? 'rotate-y-180' : 'hover:scale-[1.02]'">
                    
                    <div class="absolute inset-0 w-full h-full backface-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-gray-400/50 to-white/30 rounded-2xl p-[1px]">
                            <div class="rit-shine w-full h-full bg-white dark:bg-[#121212] rounded-2xl overflow-hidden relative">
                                <div class="absolute inset-0 opacity-10 dark:opacity-20 pointer-events-none">
                                    <canvas x-ref="canvas" class="w-full h-full block"></canvas>
                                </div>
                                <div class="absolute inset-0 bg-[radial-gradient(circle,transparent_40%,#ffffff_100%)] dark:bg-[radial-gradient(circle,transparent_40%,#121212_100%)] pointer-events-none"></div>
                                
                                <div class="absolute inset-0 flex flex-col items-center justify-center p-6 z-10">
                                    <div class="w-16 h-16 mb-4 rounded-full bg-gray-500/10 border border-gray-500/20 flex items-center justify-center shadow-[0_0_15px_rgba(255,255,255,0.1)]">
                                        <svg class="w-8 h-8 text-gray-500 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-black tracking-widest text-gray-900 dark:text-white uppercase">COMPETE</h3>
                                    <div class="mt-2 h-0.5 w-8 bg-gray-400"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute inset-0 w-full h-full backface-hidden rotate-y-180">
                        <div class="absolute inset-0 bg-gradient-to-bl from-gray-400 to-gray-600 rounded-2xl p-[1px]">
                            <div class="rit-shine w-full h-full bg-gray-50 dark:bg-[#0a0a0a] rounded-2xl overflow-hidden flex flex-col items-center justify-center p-6 text-center relative">
                                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-full blur-2xl"></div>
                                
                                <h4 class="text-lg font-bold mb-6 text-gray-400 tracking-widest uppercase border-b border-gray-500/30 pb-1">
                                    COMPETE
                                </h4>
                                
                                <div class="space-y-2 z-10">
                                    <p class="text-xl md:text-2xl text-gray-800 dark:text-white font-bold leading-tight">
                                        Tantang Diri.
                                    </p>
                                    <p class="text-base text-gray-500 dark:text-gray-400 font-mono">
                                        Terus Bertumbuh.
                                    </p>
                                </div>
                                <div class="absolute bottom-4 right-4 text-gray-500 hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('glitchCard', () => ({
                isFlipped: false,
                canvas: null,
                ctx: null,
                letters: [],
                grid: { cols: 0, rows: 0 },
                charWidth: 10,
                charHeight: 20,
                animationId: null,
                themeColors: ['#05D9E7', '#2563EB', '#9ca3af', '#ffffff'], 

                init() {
                    this.$nextTick(() => {
                        this.canvas = this.$refs.canvas;
                        if(this.canvas) {
                            this.ctx = this.canvas.getContext('2d');
                            if (document.documentElement.classList.contains('dark')) {
                                this.themeColors = ['#049ca6', '#1a46a8', '#4b5563', '#888888'];
                            }
                            this.resize();
                            this.animate();
                            window.addEventListener('resize', () => this.resize());
                        }
                    });
                },

                resize() {
                    if (!this.canvas) return;
                    const rect = this.canvas.parentElement.getBoundingClientRect();
                    this.canvas.width = rect.width;
                    this.canvas.height = rect.height;
                    this.grid.cols = Math.ceil(rect.width / this.charWidth);
                    this.grid.rows = Math.ceil(rect.height / this.charHeight);
                    this.initLetters();
                },

                initLetters() {
                    this.letters = Array.from({ length: this.grid.cols * this.grid.rows }, () => ({
                        char: this.randomChar(),
                        color: this.randomColor(),
                    }));
                },

                draw() {
                    if (!this.ctx) return;
                    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                    this.ctx.font = '16px monospace';
                    this.ctx.textBaseline = 'top';
                    
                    this.letters.forEach((l, i) => {
                        const x = (i % this.grid.cols) * this.charWidth;
                        const y = Math.floor(i / this.grid.cols) * this.charHeight;
                        this.ctx.fillStyle = l.color;
                        this.ctx.fillText(l.char, x, y);
                    });
                },

                update() {
                    const count = Math.max(1, Math.floor(this.letters.length * 0.05));
                    for(let i=0; i<count; i++) {
                        const idx = Math.floor(Math.random() * this.letters.length);
                        if(this.letters[idx]) {
                            this.letters[idx].char = this.randomChar();
                            this.letters[idx].color = this.randomColor();
                        }
                    }
                },

                animate() {
                    setTimeout(() => {
                        if (!this.isFlipped) { 
                            this.update();
                            this.draw();
                        }
                        this.animationId = requestAnimationFrame(() => this.animate());
                    }, 50); 
                },

                randomChar() {
                    const chars = '01'; 
                    return chars[Math.floor(Math.random() * chars.length)];
                },

                randomColor() {
                    return this.themeColors[Math.floor(Math.random() * this.themeColors.length)];
                },

                flip() {
                    this.isFlipped = !this.isFlipped;
                }
            }));
        });
    </script>
</section>

<!-- SECTION 3: ABOUT RIT -->
<section 
    id="about" 
    x-data="{ 
        hovered: null,
        mouse: { x: 0, y: 0 },
        core: { x: 0, y: 0 },
        
        init() {
            window.addEventListener('mousemove', (e) => {
                // Global Parallax
                this.mouse.x = (e.clientX / window.innerWidth) - 0.5;
                this.mouse.y = (e.clientY / window.innerHeight) - 0.5;
                
                // Core Tilt Logic (Lebih responsif)
                const coreRect = this.$refs.coreArea.getBoundingClientRect();
                const coreX = (e.clientX - coreRect.left - coreRect.width / 2) / 20;
                const coreY = (e.clientY - coreRect.top - coreRect.height / 2) / 20;
                this.core.x = coreY * -1; // Invert axis for natural feel
                this.core.y = coreX;
            });
        }
    }"
    class="relative py-12 md:py-20 bg-[#0a0a0a] overflow-hidden border-t border-white/5 -mt-10 md:-mt-20 z-20"
>
    <style>
        .rit-3d-scene { perspective: 1000px; }
        .rit-preserve-3d { transform-style: preserve-3d; }
        
        @keyframes spin-axis-1 { 0% { transform: rotateX(0deg) rotateY(0deg); } 100% { transform: rotateX(360deg) rotateY(180deg); } }
        @keyframes spin-axis-2 { 0% { transform: rotateX(0deg) rotateZ(0deg); } 100% { transform: rotateX(-360deg) rotateZ(180deg); } }
        @keyframes spin-axis-3 { 0% { transform: rotateY(0deg) rotateZ(0deg); } 100% { transform: rotateY(360deg) rotateZ(-360deg); } }
        @keyframes pulse-glow { 0%, 100% { opacity: 0.5; transform: scale(1); } 50% { opacity: 1; transform: scale(1.1); } }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }

        .animate-core-1 { animation: spin-axis-1 15s linear infinite; }
        .animate-core-2 { animation: spin-axis-2 12s linear infinite; }
        .animate-core-3 { animation: spin-axis-3 10s linear infinite; }
        .animate-pulse-core { animation: pulse-glow 3s ease-in-out infinite; }
        .animate-float { animation: float 6s ease-in-out infinite; }
    </style>

    <div class="absolute inset-0 overflow-hidden pointer-events-none flex items-center justify-center select-none z-0">
        <h1 
            class="text-[25vw] font-black text-white/[0.02] leading-none tracking-tighter transition-transform duration-100 ease-out"
            :style="`transform: translate(${mouse.x * -40}px, ${mouse.y * -40}px)`"
        >
            RIT
        </h1>
        <div 
            class="absolute w-[600px] h-[600px] bg-[#05D9E7] rounded-full mix-blend-screen filter blur-[180px] opacity-10 transition-transform duration-500 ease-out"
            :style="`transform: translate(${mouse.x * 80}px, ${mouse.y * 80}px)`"
        ></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            
            <div class="flex flex-col h-full" x-ref="coreArea">
                
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-[1px] w-12 bg-[#05D9E7]"></div>
                        <h2 class="text-sm font-mono font-bold tracking-[0.3em] text-[#05D9E7] uppercase">About RIT</h2>
                    </div>
                    <h3 class="text-4xl md:text-6xl font-black text-white leading-[0.9] tracking-tight">
                        WHAT <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-600">DEFINE RIT?</span>
                    </h3>
                </div>

                <div class="relative group cursor-default inline-block mb-10">
                    <div class="absolute -inset-2 bg-[#05D9E7]/5 rounded-lg blur opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <p class="relative text-lg md:text-xl text-gray-400 font-serif italic border-l-2 border-[#05D9E7] pl-6 py-2">
                        "Apa yang menjadikan seseorang sebagai Republic of Information Technology?"
                    </p>
                </div>

                <div class="relative w-full h-[400px] flex items-center justify-center animate-float">
                    
                    <div 
                        class="rit-3d-scene w-64 h-64 relative"
                        :style="`transform: rotateX(${core.x}deg) rotateY(${core.y}deg); transition: transform 0.1s ease-out;`"
                    >
                        <div class="w-full h-full relative rit-preserve-3d flex items-center justify-center">
                            
                            <div class="absolute w-64 h-64 border-[1px] border-dashed border-[#05D9E7]/40 rounded-full animate-core-1 shadow-[0_0_30px_rgba(5,217,231,0.1)]"></div>
                            
                            <div class="absolute w-48 h-48 border-[2px] border-blue-500/60 rounded-full animate-core-2 shadow-[0_0_20px_rgba(37,99,235,0.2)]">
                                <div class="absolute top-0 left-1/2 w-2 h-2 bg-blue-400 rounded-full -translate-x-1/2 -translate-y-1/2 box-shadow-glow"></div>
                                <div class="absolute bottom-0 left-1/2 w-2 h-2 bg-blue-400 rounded-full -translate-x-1/2 translate-y-1/2"></div>
                            </div>

                            <div class="absolute w-32 h-32 border-[4px] border-l-purple-500 border-t-transparent border-r-white border-b-transparent rounded-full animate-core-3"></div>

                            <div class="absolute w-16 h-16 bg-gradient-to-br from-[#05D9E7] to-blue-600 rounded-full animate-pulse-core shadow-[0_0_50px_rgba(5,217,231,0.6)] flex items-center justify-center overflow-hidden">
                                <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-50 mix-blend-overlay"></div>
                                <span class="text-black font-black text-xs tracking-tighter z-10">RIT</span>
                            </div>

                            <div class="absolute w-full h-full animate-spin-slow-reverse opacity-30">
                                <div class="absolute top-0 left-1/2 w-[1px] h-10 bg-gradient-to-b from-transparent to-[#05D9E7]"></div>
                                <div class="absolute bottom-0 left-1/2 w-[1px] h-10 bg-gradient-to-t from-transparent to-[#05D9E7]"></div>
                                <div class="absolute left-0 top-1/2 h-[1px] w-10 bg-gradient-to-r from-transparent to-[#05D9E7]"></div>
                                <div class="absolute right-0 top-1/2 h-[1px] w-10 bg-gradient-to-l from-transparent to-[#05D9E7]"></div>
                            </div>

                        </div>
                    </div>

                    <div class="absolute bottom-10 w-40 h-4 bg-[#05D9E7] blur-[40px] opacity-30 rounded-full animate-pulse"></div>
                    
                    <div class="absolute bottom-0 text-[10px] font-mono text-gray-500 tracking-[0.3em] uppercase">
                        System Online
                    </div>
                </div>

            </div>

            <div class="flex flex-col justify-center gap-2 w-full lg:pl-10 mt-12 lg:mt-32">

                <div @mouseenter="hovered = 1" @mouseleave="hovered = null" class="relative w-full group cursor-pointer">
                    <div class="absolute left-0 top-0 bottom-0 w-[2px] bg-[#05D9E7] scale-y-0 group-hover:scale-y-100 transition-transform duration-300 origin-top"></div>
                    <div class="relative p-6 md:p-8 border-b border-white/10 transition-all duration-500 bg-transparent group-hover:bg-white/[0.02]"
                         :class="hovered !== null && hovered !== 1 ? 'opacity-30 blur-[1px]' : 'opacity-100'">
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <span class="font-mono text-xs text-gray-500 group-hover:text-[#05D9E7] transition-colors">/ 01 -- IDENTITY</span>
                            </div>
                            <div>
                                <h4 class="text-2xl md:text-3xl font-bold text-white mb-2 group-hover:translate-x-2 transition-transform duration-300">
                                    Place for the <span class="text-[#05D9E7]">Explorer</span>
                                </h4>
                                <p class="text-gray-400 text-sm md:text-base leading-relaxed max-w-xl group-hover:text-gray-200 transition-colors">
                                    RIT didirikan untuk menjawab kebutuhan akan tempat untuk bertumbuh dan berkembang dalam bidang teknologi.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div @mouseenter="hovered = 2" @mouseleave="hovered = null" class="relative w-full group cursor-pointer">
                    <div class="absolute left-0 top-0 bottom-0 w-[2px] bg-blue-500 scale-y-0 group-hover:scale-y-100 transition-transform duration-300 origin-top"></div>
                    <div class="relative p-6 md:p-8 border-b border-white/10 transition-all duration-500 bg-transparent group-hover:bg-white/[0.02]"
                         :class="hovered !== null && hovered !== 2 ? 'opacity-30 blur-[1px]' : 'opacity-100'">
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <span class="font-mono text-xs text-gray-500 group-hover:text-blue-500 transition-colors">/ 02 -- ECOSYSTEM</span>
                            </div>
                            <div>
                                <h4 class="text-2xl md:text-3xl font-bold text-white mb-2 group-hover:translate-x-2 transition-transform duration-300">
                                    Supportive <span class="text-blue-500">System</span>
                                </h4>
                                <p class="text-gray-400 text-sm md:text-base leading-relaxed max-w-xl group-hover:text-gray-200 transition-colors">
                                    Kami mewujudkan sistem suportif, yaitu tempat teknologi dan interaksi melebur menjadi satu.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div @mouseenter="hovered = 3" @mouseleave="hovered = null" class="relative w-full group cursor-pointer">
                    <div class="absolute left-0 top-0 bottom-0 w-[2px] bg-purple-500 scale-y-0 group-hover:scale-y-100 transition-transform duration-300 origin-top"></div>
                    <div class="relative p-6 md:p-8 border-b border-white/10 transition-all duration-500 bg-transparent group-hover:bg-white/[0.02]"
                         :class="hovered !== null && hovered !== 3 ? 'opacity-30 blur-[1px]' : 'opacity-100'">
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <span class="font-mono text-xs text-gray-500 group-hover:text-purple-500 transition-colors">/ 03 -- IMPACT</span>
                            </div>
                            <div>
                                <h4 class="text-2xl md:text-3xl font-bold text-white mb-2 group-hover:translate-x-2 transition-transform duration-300">
                                    Meaningful <span class="text-purple-500">Contribution</span>
                                </h4>
                                <p class="text-gray-400 text-sm md:text-base leading-relaxed max-w-xl group-hover:text-gray-200 transition-colors">
                                    Setiap kontribusi sangat berarti untuk kami, tempat ini dibuat dari semangat kita untuk kita semua.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- SECTION 4: JOURNEY MODEL -->
<section 
    id="journey" 
    class="py-20 bg-[#0a0a0a] relative overflow-hidden"
    x-data="roadmapSystem()"
>
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff05_1px,transparent_1px),linear-gradient(to_bottom,#ffffff05_1px,transparent_1px)] bg-[size:40px_40px]"></div>

    <div class="max-w-7xl mx-auto px-4 relative z-10 h-full">
        
        <div class="text-center mb-12">
            <h2 class="text-sm font-mono font-bold tracking-[0.3em] text-[#05D9E7] uppercase mb-2">The System</h2>
            <h3 class="text-3xl md:text-4xl font-black text-white">
                CHOOSE YOUR <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#05D9E7] to-blue-500">PATH</span>
            </h3>
        </div>

        <div class="relative w-full overflow-x-auto overflow-y-visible pb-20 custom-scrollbar">
            <div class="relative min-w-[1150px] h-[700px] mx-auto">
                
                <svg class="absolute inset-0 w-full h-full pointer-events-none z-0">
                    <defs>
                        <marker id="arrow-gray" markerWidth="10" markerHeight="10" refX="9" refY="3" orient="auto" markerUnits="strokeWidth">
                            <path d="M0,0 L0,6 L9,3 z" fill="#555" />
                        </marker>
                        <marker id="arrow-black" markerWidth="10" markerHeight="10" refX="9" refY="3" orient="auto" markerUnits="strokeWidth">
                            <path d="M0,0 L0,6 L9,3 z" fill="#222" />
                        </marker>
                    </defs>

                    <path d="M 242 350 H 315" fill="none" stroke="#555" stroke-width="2" stroke-dasharray="8 4" marker-end="url(#arrow-gray)" />

                    <path d="M 512 350 H 560" fill="none" stroke="#555" stroke-width="2" stroke-dasharray="8 4" />

                    <path d="M 560 350 V 105 H 595" fill="none" stroke="#555" stroke-width="2" stroke-dasharray="8 4" marker-end="url(#arrow-gray)" />

                    <path d="M 560 350 V 480 H 595" fill="none" stroke="#555" stroke-width="2" stroke-dasharray="8 4" marker-end="url(#arrow-gray)" />


                    <path d="M 856 105 H 920 V 320" fill="none" stroke="#222" stroke-width="3" />

                    <path d="M 882 480 H 920 V 320" fill="none" stroke="#222" stroke-width="3" />

                    <path d="M 920 320 H 945" fill="none" stroke="#222" stroke-width="3" marker-end="url(#arrow-black)" />

                </svg>

                <div class="absolute top-[315px] left-[50px] z-10">
                    <button @click="openCard('member')" class="w-48 h-16 bg-black border-2 border-[#05D9E7] text-white font-bold tracking-wider hover:bg-[#05D9E7] hover:text-black transition-all shadow-[0_0_20px_rgba(5,217,231,0.2)] flex flex-col items-center justify-center">
                        MEMBER
                        <span class="text-[10px] font-mono font-normal opacity-70">(Join WA/Discord)</span>
                    </button>
                </div>

                <div class="absolute top-[315px] left-[320px] z-10">
                    <button @click="openCard('apprentice')" class="w-48 h-16 bg-black border-2 border-red-500 text-white font-bold tracking-wider hover:bg-red-500 hover:text-black transition-all shadow-[0_0_20px_rgba(239,68,68,0.2)] flex flex-col items-center justify-center">
                        APPRENTICE
                        <span class="text-[10px] font-mono font-normal opacity-70">(Basic Training)</span>
                    </button>
                </div>

                <div class="absolute top-[65px] left-[600px] z-10">
                    <button @click="openCard('specialist')" class="w-64 h-20 bg-black border-2 border-white text-white font-bold text-lg tracking-wider hover:bg-white hover:text-black transition-all shadow-lg flex flex-col items-center justify-center group">
                        SPECIALIST
                        <span class="text-xs font-mono font-normal opacity-70 group-hover:opacity-100">(Fokus Divisi)</span>
                    </button>
                </div>

                <div class="absolute top-[280px] left-[600px] w-[280px] h-[400px] border-2 border-purple-500 bg-[#0a0a0a]/50 backdrop-blur-sm p-4 flex flex-col gap-6 items-center justify-center z-0 rounded-xl">
                    <div class="absolute -top-4 bg-[#0a0a0a] px-2 text-purple-500 font-bold tracking-widest uppercase">Explorer</div>
                    
                    <button @click="openCard('explorer')" class="w-full py-3 bg-black border border-purple-500/50 hover:border-purple-500 hover:bg-purple-500/20 text-white text-sm transition-all rounded">
                        Selesaikan Papan Misi
                    </button>
                    <button @click="openCard('explorer')" class="w-full py-3 bg-black border border-purple-500/50 hover:border-purple-500 hover:bg-purple-500/20 text-white text-sm transition-all rounded">
                        Aktif Diskusi Hub
                    </button>
                    <button @click="openCard('explorer')" class="w-full py-3 bg-black border border-purple-500/50 hover:border-purple-500 hover:bg-purple-500/20 text-white text-sm transition-all rounded">
                        Konsisten Self-Learning
                    </button>
                </div>

                <div class="absolute top-[285px] left-[950px] z-10">
                    <button @click="openCard('developer')" class="relative w-48 h-24 bg-[#05D9E7] text-black font-black text-xl tracking-widest hover:scale-105 transition-transform shadow-[0_0_40px_rgba(5,217,231,0.4)] clip-hexagon flex flex-col items-center justify-center">
                        DEVELOPER
                        <span class="text-[10px] font-mono font-bold mt-1 opacity-70">(Ready for Action)</span>
                    </button>
                </div>

            </div>
        </div>

        <div 
            x-show="isOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-10 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-10 scale-95"
            @click.away="isOpen = false"
            class="fixed bottom-6 right-6 md:bottom-10 md:right-10 w-[90vw] md:w-[450px] max-h-[80vh] bg-[#161616]/95 border border-white/10 backdrop-blur-xl rounded-2xl shadow-2xl z-50 overflow-y-auto custom-scrollbar"
            style="display: none;"
        >
            <div class="sticky top-0 bg-[#161616]/95 backdrop-blur-md border-b border-white/5 p-6 flex justify-between items-start z-10">
                <div>
                    <span class="text-xs font-mono text-[#05D9E7] uppercase tracking-widest" x-text="activeData.tag"></span>
                    <h3 class="text-2xl font-black text-white mt-1" x-text="activeData.title"></h3>
                </div>
                <button @click="isOpen = false" class="text-gray-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div class="p-6 space-y-6">
                <p class="text-gray-300 text-sm leading-relaxed" x-html="activeData.desc"></p>

                <template x-if="activeData.features">
                    <div>
                        <h4 class="text-xs font-bold text-white uppercase border-b border-white/10 pb-2 mb-3">Key Features</h4>
                        <ul class="space-y-3">
                            <template x-for="feature in activeData.features">
                                <li class="flex items-start gap-3 bg-white/5 p-3 rounded-lg">
                                    <div class="mt-0.5 text-[#05D9E7]">✦</div>
                                    <div>
                                        <strong class="block text-sm text-white" x-text="feature.title"></strong>
                                        <span class="block text-xs text-gray-400 mt-0.5" x-text="feature.text"></span>
                                    </div>
                                </li>
                            </template>
                        </ul>
                    </div>
                </template>

                <template x-if="activeData.schedule">
                    <div>
                        <h4 class="text-xs font-bold text-white uppercase border-b border-white/10 pb-2 mb-3">Schedule & Availability</h4>
                        <div class="bg-black/50 rounded-lg p-4 space-y-3">
                            <template x-for="item in activeData.schedule">
                                <div class="flex justify-between items-start text-xs border-b border-white/5 last:border-0 pb-2 last:pb-0">
                                    <div class="font-bold text-white w-1/3" x-text="item.name"></div>
                                    <div class="text-gray-400 w-2/3 text-right">
                                        <div x-text="item.time"></div>
                                        <div class="text-[#05D9E7]" x-text="item.loc"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>

    </div>
</section>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('roadmapSystem', () => ({
            isOpen: false,
            activeData: {},
            
            // DATABASE KONTEN
            db: {
                'member': {
                    tag: '[ ENTRY ]',
                    title: 'MEMBER',
                    desc: '<strong>Mulai Langkahmu.</strong> Ikuti komunitas kami di WhatsApp dan Discord.<br><br>Atau ikuti kumpulan rutin dan kegiatan-kegiatan yang kami adakan.',
                    features: [
                        { title: 'Community Access', text: 'Akses grup umum dan info event.' },
                        { title: 'Networking', text: 'Kenalan dengan sesama mahasiswa yang punya minat yang sama.' }
                    ]
                },
                'apprentice': {
                    tag: '[ BASIC TRAINING ]',
                    title: 'APPRENTICE',
                    desc: 'Belum siap memilih jalur Specialist atau Explorer? Kamu wajib mengikuti <strong>Basic Training</strong> dari RIT.<br><br>Tujuannya? Agar kamu punya bekal skill untuk berani memilih jalur 1 atau 2.',
                    schedule: [
                        { name: 'Basic Training', time: 'Sesuai jadwal penerimaan', loc: 'Kampus FKOMINFO' }
                    ]
                },
                'specialist': {
                    tag: '[ GRIND ]',
                    title: 'SPECIALIST',
                    desc: '<strong>Pilih Jalanmu.</strong> Masuk ke Divisi resmi (WebDev, GameDev, IoT, Cysec) dan ikuti keseruannya.<br><br>Fokus perdalam bidangmu bareng mentor dan tim divisi.',
                    features: [
                        { title: 'Kumpulan Divisi', text: 'Belajar spesifik sesuai kurikulum.' },
                        { title: 'Konsultasi', text: 'Sesi tanya jawab mentor.' },
                        { title: 'Kumpulan Wajib', text: 'Kegiatan seluruh member 2-4 minggu sekali.' }
                    ],
                    schedule: [
                        { name: 'Web Dev', time: 'Selasa, 13.00-17.00', loc: 'Gedung D Lt.3' },
                        { name: 'Game Dev', time: 'Sabtu, 13.00-17.00', loc: 'Gedung D Lt.3' },
                        { name: 'IoT', time: 'Selasa, 13.00-17.00', loc: 'Gedung D Lt.3' },
                        { name: 'Cyber Sec', time: 'Selasa, 13.00-17.00', loc: 'Gedung D Lt.3' }
                    ]
                },
                'explorer': {
                    tag: '[ GRIND ]',
                    title: 'EXPLORER',
                    desc: 'Tidak masuk divisi? Tidak masalah. Syaratnya tetap aktif dengan cara: <br>1. Ambil & selesaikan Guild Quest.<br>2. Share progress di komunitas.<br>3. Hidupkan diskusi di Community Hub.',
                    features: [
                        { title: 'RIT Guild Quest', text: 'Papan Misi untuk asah skill & portofolio.' },
                        { title: 'CLR (Resources)', text: 'Akses sumber belajar terkurasi.' },
                        { title: 'Community Hub', text: 'Forum diskusi aktif.' }
                    ]
                },
                'developer': {
                    tag: '[ ARISE ]',
                    title: 'DEVELOPER',
                    desc: '<strong>Capai Tujuanmu.</strong> Hasil akhir dari keaktifanmu adalah karya. Karya tersebut dapat berupa proyek tim, portofolio pribadi, atau kontribusi memajukan organisasi.',
                    features: [
                        { title: 'Project Showcase', text: 'Pameran karya di event RIT.' },
                        { title: 'Ready for Action', text: 'Siap kompetisi atau freelance.' }
                    ]
                }
            },

            openCard(key) {
                this.activeData = this.db[key];
                this.isOpen = true;
            }
        }));
    });
</script>

<style>
    /* Utility Class for Hexagon Shape */
    .clip-hexagon {
        clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%);
    }
    
    /* Scrollbar Styling */
    .custom-scrollbar::-webkit-scrollbar {
        height: 8px;
        width: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #161616; 
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #333; 
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #05D9E7; 
    }
</style>


<!-- SECTION 5: COMMUNITY & DIVISIONS -->
<section 
    id="divisions" 
    class="relative w-full min-h-[90vh] flex flex-col justify-center bg-[#0a0a0a] overflow-hidden border-t border-white/5 py-12"
    x-data="divisionRail()"
    @keydown.right.window="next()"
    @keydown.left.window="prev()"
>
    <style>
        .perspective-1000 { perspective: 1000px; }
        .transform-style-3d { transform-style: preserve-3d; }
        
        /* Efek Kilatan Logo (Shine) */
        .logo-shine { position: relative; overflow: hidden; }
        .logo-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(to right, transparent 0%, rgba(255,255,255,0.6) 50%, transparent 100%);
            transform: rotate(30deg);
            animation: shine-pass 2s infinite cubic-bezier(0.4, 0.0, 0.2, 1);
            opacity: 0; /* Default mati */
            transition: opacity 0.3s;
        }
        
        /* Shine nyala saat Active atau Hover */
        .group:hover .logo-shine::after, 
        .active-card .logo-shine::after {
            opacity: 1;
        }

        @keyframes shine-pass { from { transform: translateX(-100%) rotate(30deg); } to { transform: translateX(100%) rotate(30deg); } }

        /* Floating Bubble Animation */
        @keyframes float-bubble { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-8px); } }
        .animate-float-bubble { animation: float-bubble 3s ease-in-out infinite; }
    </style>

    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,#05D9E708_0%,transparent_60%)]"></div>
        <template x-for="(item, index) in items" :key="index">
            <div class="absolute inset-0 transition-opacity duration-700 ease-out"
                 :class="active === index ? 'opacity-30' : 'opacity-0'">
                <img :src="item.img" class="w-full h-full object-cover blur-[120px] scale-125 grayscale" alt="">
            </div>
        </template>
    </div>

    <div class="max-w-7xl w-full mx-auto px-6 relative z-10 flex flex-col h-full">
        
        <div class="text-center mb-16">
            <h2 class="text-sm font-mono font-bold tracking-[0.3em] text-[#05D9E7] uppercase mb-3">Community & Divisions</h2>
            <h3 class="text-4xl md:text-6xl font-black text-white">
                FIND YOUR <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#05D9E7] to-blue-500">SPACE</span>
            </h3>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center h-full">
            
            <div class="lg:col-span-7 h-[450px] flex items-center justify-center perspective-1000 relative order-2 lg:order-1">
                
                <div class="relative w-full h-full flex items-center justify-center transform-style-3d">
                    <template x-for="(item, index) in items" :key="index">
                        
                        <div 
                            @click="setActive(index)"
                            class="absolute w-[280px] h-[380px] transition-all duration-500 ease-[cubic-bezier(0.23,1,0.32,1)] cursor-pointer transform-style-3d group"
                            :class="active === index ? 'z-20 active-card' : 'z-10 hover:brightness-110'"
                            :style="getCardStyle(index)"
                        >
                            <div class="absolute inset-0 rounded-3xl border border-white/10 bg-[#121212] shadow-2xl transition-all duration-300"
                                 :class="active === index ? 'border-[#05D9E7]/50 shadow-[0_0_60px_rgba(5,217,231,0.1)]' : ''">
                            </div>

                            <div class="absolute inset-0 flex flex-col items-center justify-center p-6 z-10">
                                
                                <div x-show="active === index"
                                     x-transition:enter="transition ease-out duration-500 delay-100"
                                     x-transition:enter-start="opacity-0 translate-y-4 scale-90"
                                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                     class="absolute -top-14 -right-12 z-30 animate-float-bubble pointer-events-none w-52 text-left">
                                    <div class="relative inline-block bg-[#1C1515] border border-[#05D9E7] px-5 py-3 rounded-xl shadow-[0_0_20px_rgba(5,217,231,0.2)] rounded-bl-none">
                                        <p class="text-xs font-bold text-white leading-tight">
                                            <span class="text-[#05D9E7]">>_</span> <span x-text="item.thought"></span>
                                        </p>
                                        <svg class="absolute -bottom-3 -left-3 w-5 h-5 text-[#05D9E7] rotate-90" fill="currentColor" viewBox="0 0 100 100"><polygon points="0,0 100,0 100,100"/></svg>
                                    </div>
                                </div>

                                <div class="logo-shine w-28 h-28 mb-6 rounded-full flex items-center justify-center transition-transform duration-500 border border-white/5 bg-[#1a1a1a]"
                                     :class="active === index ? 'scale-110 border-[#05D9E7]/30' : 'grayscale group-hover:grayscale-0'">
                                    <img :src="item.img" class="w-16 h-16 object-contain relative z-10" alt="">
                                </div>
                                
                                <h4 class="text-xl font-bold mb-3 transition-colors duration-300 text-center"
                                    :class="active === index ? 'text-white' : 'text-gray-500 group-hover:text-gray-300'"
                                    x-text="item.title"></h4>
                                
                                <div class="h-1.5 w-12 rounded-full transition-colors duration-300"
                                     :class="active === index ? 'bg-[#05D9E7]' : 'bg-gray-800'"></div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="lg:col-span-5 flex flex-col justify-center items-start order-1 lg:order-2 space-y-10 pl-4">
                
                <div class="min-h-[200px] flex flex-col justify-center">
                    <div x-show="true" class="transition-all duration-300">
                        
                        <div class="inline-flex items-center gap-3 mb-6 bg-[#05D9E7]/10 text-[#05D9E7] px-5 py-2 rounded-full border border-[#05D9E7]/20">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#05D9E7] animate-pulse"></span>
                            <span class="text-sm font-mono font-bold tracking-[0.15em]" x-text="items[active].meta"></span>
                        </div>
                        
                        <h4 class="text-4xl font-bold text-white mb-4 leading-tight" x-text="items[active].title"></h4>
                        <p class="text-gray-400 text-lg leading-relaxed font-medium" x-text="items[active].desc"></p>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2 bg-[#161616] p-1.5 rounded-full border border-white/10 shadow-lg">
                        <button @click="prev()" class="p-3 rounded-full hover:bg-white/10 text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                        </button>
                        <span class="w-16 text-center text-sm font-mono text-gray-500 font-bold">
                            <span x-text="active + 1"></span> / <span x-text="items.length"></span>
                        </span>
                        <button @click="next()" class="p-3 rounded-full hover:bg-white/10 text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </button>
                    </div>

                    <a href="#join" class="group flex items-center gap-3 rounded-full bg-[#05D9E7] px-8 py-4 text-sm font-black text-[#1C1515] hover:scale-105 transition-transform shadow-[0_0_30px_rgba(5,217,231,0.3)]">
                        EXPLORE DIVISION
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('divisionRail', () => ({
            active: 0,
            items: [
                {
                    title: 'Web Development',
                    desc: 'Fokus pada perancangan, pembangunan, dan pemeliharaan website serta aplikasi berbasis web, mencakup UI, programming, dan database.',
                    img: "{{ asset('images/logo/RIT WebDev Biru.png') }}",
                    meta: 'IT COMMUNITY',
                    thought: 'Gass kita ngoding bareng!'
                },
                {
                    title: 'Game Development',
                    desc: 'Mempelajari pengembangan game dari konsep hingga rilis, termasuk game mechanics, level design, dan strategi untuk membangun interaksi pemain yang kuat.',
                    img: "{{ asset('images/logo/RIT GameDev Biru.png') }}",
                    meta: 'IT COMMUNITY',
                    thought: 'Ciptakan dunia imajinasimu!'
                },
                {
                    title: 'Internet of Things',
                    desc: 'Eksplorasi perangkat cerdas dengan sensor dan konektivitas internet untuk membangun sistem otomatis berbasis data.',
                    img: "{{ asset('images/logo/RIT IoT Biru.png') }}",
                    meta: 'IT COMMUNITY',
                    thought: 'Connect everything smart.'
                },
                {
                    title: 'Cyber Security',
                    desc: 'Mempelajari strategi perlindungan sistem, jaringan, dan aplikasi dari ancaman siber.',
                    img: "{{ asset('images/logo/RIT Cysec Biru.png') }}",
                    meta: 'IT COMMUNITY',
                    thought: 'Secure the future.'
                }
            ],

            next() { this.active = (this.active + 1) % this.items.length; },
            prev() { this.active = (this.active - 1 + this.items.length) % this.items.length; },
            setActive(index) { this.active = index; },

            getCardStyle(index) {
                const center = this.active;
                const total = this.items.length;
                let offset = index - center;
                if (offset > total / 2) offset -= total;
                if (offset < -total / 2) offset += total;

                // Config Jarak & Rotasi
                const xSpacing = 300; 
                const zDepth = 300;
                const rotAngle = 30;
                
                const x = offset * xSpacing;
                const z = -Math.abs(offset) * zDepth;
                const rotateY = offset * -rotAngle;
                const scale = index === center ? 1 : 0.85;
                const opacity = index === center ? 1 : 0.3;
                const blur = index === center ? 0 : 4;
                const zIndex = 10 - Math.abs(offset);

                return `
                    transform: translateX(${x}px) translateZ(${z}px) rotateY(${rotateY}deg) scale(${scale});
                    opacity: ${opacity};
                    z-index: ${zIndex};
                    filter: blur(${blur}px);
                    pointer-events: ${index === center ? 'auto' : 'none'};
                `;
            }
        }));
    });
</script>

<!-- GAME COMMUNITY -->
<section 
    id="game-community" 
    class="relative w-full min-h-[85vh] flex flex-col justify-center bg-[#0a0a0a] overflow-hidden border-t border-white/5 py-16"
>
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-[radial-gradient(circle,#05D9E708_0%,transparent_70%)]"></div>
        <div class="absolute inset-0 opacity-20">
            <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=2670&auto=format&fit=crop" 
                 class="w-full h-full object-cover blur-[100px] scale-110 grayscale" alt="">
        </div>
    </div>

    <div class="max-w-7xl w-full mx-auto px-6 relative z-10 flex flex-col h-full justify-center">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            
            <div class="lg:col-span-5 flex flex-col justify-center items-start order-2 lg:order-1 space-y-8 lg:pl-12">
                
                <div>
                    <h2 class="inline-flex items-center gap-3 mb-6 bg-[#05D9E7]/10 text-[#05D9E7] px-5 py-2 rounded-full border border-[#05D9E7]/20 font-bold uppercase tracking-wider">
                        <span class="w-3 h-3 rounded-full bg-[#05D9E7]"></span>
                        Game Community
                    </h2>
                    <h3 class="text-4xl md:text-5xl font-black text-white leading-tight">
                        UNLEASH YOUR <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#05D9E7] to-blue-500">PASSION</span>
                    </h3>
                </div>

                <p class="text-gray-400 text-lg leading-relaxed font-medium">
                    Wadah bagi gaming enthusiast untuk menyalurkan passion, mengeksplorasi dunia game, dan membangun jejaring komunitas.
                </p>

                <a href="#join" class="group flex items-center gap-3 rounded-full bg-[#05D9E7] px-8 py-4 text-sm font-black text-[#1C1515] hover:scale-105 transition-transform shadow-[0_0_30px_rgba(5,217,231,0.3)]">
                    JOIN SQUAD
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>

            </div>

            <div class="lg:col-span-7 flex items-center justify-center perspective-1000 relative order-1 lg:order-2">
                
                <div class="relative w-[320px] h-[450px] transition-all duration-500 ease-out transform-style-3d group hover:rotate-y-6 hover:rotate-x-6 cursor-pointer">
                    
                    <div class="absolute inset-0 rounded-3xl border border-[#05D9E7]/30 bg-[#121212] shadow-[0_0_60px_rgba(5,217,231,0.1)] overflow-hidden group-hover:shadow-[0_0_80px_rgba(5,217,231,0.2)] transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#05D9E7]/10 to-transparent"></div>
                    </div>

                    <div class="absolute inset-0 flex flex-col items-center justify-center p-8 z-10 text-center">
                        
                        <div class="absolute -top-8 -left-10 z-30 animate-float-bubble w-48 text-right">
                            <div class="relative inline-block bg-[#1C1515] border border-[#05D9E7] px-5 py-3 rounded-xl shadow-[0_0_20px_rgba(5,217,231,0.2)] rounded-br-none">
                                <p class="text-xs font-bold text-white leading-tight">
                                    Level up your passion! <span class="text-[#05D9E7]">_&lt;</span>
                                </p>
                                <svg class="absolute -bottom-3 -right-3 w-5 h-5 text-[#05D9E7]" fill="currentColor" viewBox="0 0 100 100"><polygon points="100,0 0,0 0,100"/></svg>
                            </div>
                        </div>

                        <div class="w-32 h-32 mb-8 rounded-full flex items-center justify-center border border-[#05D9E7]/30 bg-[#1a1a1a] shadow-[0_0_30px_rgba(5,217,231,0.15)] group-hover:scale-110 transition-transform duration-500">
                            <svg class="w-16 h-16 text-[#05D9E7]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                        
                        <h4 class="text-2xl font-bold text-white mb-4">Gaming Enthusiast</h4>
                        
                        <p class="text-sm text-gray-400 leading-relaxed">
                            Divisi tempat berkumpulnya para antusias game yang ingin mendalami hobi ini secara serius. Fokus kegiatannya untuk menyalurkan passion bermain, mengeksplorasi berbagai aspek dunia game, serta berjejaring aktif dengan komunitas gamer yang lebih luas.
                        </p>
                        
                        <div class="mt-6 h-1.5 w-16 rounded-full bg-[#05D9E7]"></div>
                    </div>
                </div>

            </div>

        </div>

        <div class="mt-24 pt-12 border-t border-white/5 text-center">
            <h4 class="text-2xl md:text-3xl font-bold text-white italic mb-4 tracking-tight">
                Semua bahasan teknologi ada disini!
            </h4>
            <p class="text-gray-500 text-sm md:text-base max-w-2xl mx-auto leading-relaxed">
                Eksplorasi tidak terbatas pada divisi.
                Jika kebutuhan dan minat berkembang, <span class="text-[#05D9E7] font-bold">RIT</span> dapat membuka divisi baru sesuai kebutuhan :)
            </p>
        </div>

    </div>
</section>


<!-- SECTION 6: ACTIVITY & RECAP -->
<section 
    id="gallery" 
    class="relative py-24 bg-[#0a0a0a] overflow-hidden border-t border-white/5"
    x-data="{ activeHover: false }"
>
    <style>
        /* Container Miring (Scale diperbesar agar memenuhi layar) */
        .tilted-gallery {
            transform: rotate(-6deg) scale(1.3); 
            transform-origin: center;
            will-change: transform;
        }

        /* Keyframes Scroll */
        @keyframes scroll-up {
            0% { transform: translateY(0%); }
            100% { transform: translateY(-50%); }
        }
        @keyframes scroll-down {
            0% { transform: translateY(-50%); }
            100% { transform: translateY(0%); }
        }

        /* TURBO SPEED ANIMATIONS (15s - 25s) */
        .animate-scroll-up { animation: scroll-up 20s linear infinite; }
        .animate-scroll-down { animation: scroll-down 25s linear infinite; }
        .animate-scroll-fast { animation: scroll-up 15s linear infinite; }
        .animate-scroll-slow { animation: scroll-down 30s linear infinite; }

        /* Pause on Hover */
        .group-hover-paused:hover .animate-scroll-up,
        .group-hover-paused:hover .animate-scroll-down,
        .group-hover-paused:hover .animate-scroll-fast,
        .group-hover-paused:hover .animate-scroll-slow {
            animation-play-state: paused;
        }
    </style>

    <div class="relative z-20 max-w-7xl mx-auto px-6 mb-16 text-center">
        <h2 class="text-xs font-mono font-bold tracking-[0.3em] text-[#05D9E7] uppercase mb-3">Our Memories</h2>
        <h3 class="text-4xl md:text-6xl font-black text-white leading-tight">
            MOMENTS IN <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#05D9E7] to-blue-600">MOTION</span>
        </h3>
        <p class="text-gray-400 mt-6 max-w-xl mx-auto text-lg">
            Setiap bingkai menyimpan cerita. Jejak langkah kolaborasi, tawa, dan inovasi yang membangun RIT hingga hari ini.
        </p>
    </div>

    <div 
        class="relative w-full h-[800px] md:h-[900px] flex justify-center overflow-hidden group-hover-paused"
        @mouseenter="activeHover = true" 
        @mouseleave="activeHover = false"
    >
        <div class="absolute inset-0 z-10 pointer-events-none bg-gradient-to-b from-[#0a0a0a] via-transparent to-[#0a0a0a] h-full"></div>

        <div class="tilted-gallery flex gap-4 md:gap-6 min-w-[150%] -mt-32 justify-center">
            
            {{-- DATA & FUNGSI RENDER (PHP INLINE) --}}
            @php
                // 1. Data Distribusi Foto (5 Kolom)
                $col1 = [
                    ['file' => 'L doc 1.jpg', 'type' => 'L'], ['file' => 'P doc 1.jpg', 'type' => 'P'],
                    ['file' => 'L doc 2.jpg', 'type' => 'L'], ['file' => 'L doc 3.jpg', 'type' => 'L']
                ];
                $col2 = [
                    ['file' => 'P doc 2.jpg', 'type' => 'P'], ['file' => 'L doc 4.jpg', 'type' => 'L'],
                    ['file' => 'L doc 5.jpg', 'type' => 'L'], ['file' => 'L doc 6.jpg', 'type' => 'L']
                ];
                $col3 = [
                    ['file' => 'P doc 3.jpg', 'type' => 'P'], ['file' => 'L doc 7.jpg', 'type' => 'L'],
                    ['file' => 'L doc 8.jpg', 'type' => 'L'], ['file' => 'P doc 4.jpg', 'type' => 'P']
                ];
                $col4 = [
                    ['file' => 'L doc 9.jpg', 'type' => 'L'], ['file' => 'L doc 10.jpg', 'type' => 'L'],
                    ['file' => 'L doc 11.jpg', 'type' => 'L'], ['file' => 'P doc 5.jpg', 'type' => 'P']
                ];
                $col5 = [
                    ['file' => 'L doc 12.jpg', 'type' => 'L'], ['file' => 'L doc 13.jpg', 'type' => 'L'],
                    ['file' => 'P doc 6.jpg', 'type' => 'P'], ['file' => 'L doc 14.jpg', 'type' => 'L']
                ];

                // 2. Fungsi Generator HTML (Agar tidak perlu file component terpisah)
                if (!function_exists('renderGalleryCard')) {
                    function renderGalleryCard($item) {
                        $src = asset('images/documentation/' . $item['file']);
                        // Tentukan aspect ratio class manual karena kita di dalam string PHP
                        $aspectStyle = $item['type'] == 'L' ? 'aspect-ratio: 16/10;' : 'aspect-ratio: 9/14;';
                        
                        return '
                        <div class="relative group/card cursor-pointer transition-all duration-500 ease-out hover:z-30 hover:scale-105 hover:shadow-[0_0_30px_rgba(5,217,231,0.3)]">
                            <div class="overflow-hidden rounded-xl border border-white/10 shadow-lg bg-[#161616]" style="'.$aspectStyle.'">
                                <img src="'.$src.'" class="w-full h-full object-cover transform transition-transform duration-700 group-hover/card:scale-110 grayscale group-hover/card:grayscale-0 brightness-75 group-hover/card:brightness-110" loading="lazy" alt="RIT Doc">
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5 rounded-xl pointer-events-none">
                                <div class="transform translate-y-4 group-hover/card:translate-y-0 transition-transform duration-300">
                                    <div class="h-1 w-8 bg-[#05D9E7] mb-2 rounded-full"></div>
                                    <span class="text-white text-xs font-mono font-bold tracking-widest uppercase">RIT ARCHIVE</span>
                                </div>
                            </div>
                        </div>';
                    }
                }
            @endphp

            {{-- RENDER KOLOM (Looping 2x untuk Infinite Scroll Seamless) --}}

            <div class="flex flex-col gap-6 w-[240px] md:w-[300px] animate-scroll-fast shrink-0">
                @foreach($col1 as $item) {!! renderGalleryCard($item) !!} @endforeach
                @foreach($col1 as $item) {!! renderGalleryCard($item) !!} @endforeach
            </div>

            <div class="flex flex-col gap-6 w-[240px] md:w-[300px] animate-scroll-down shrink-0 pt-32">
                @foreach($col2 as $item) {!! renderGalleryCard($item) !!} @endforeach
                @foreach($col2 as $item) {!! renderGalleryCard($item) !!} @endforeach
            </div>

            <div class="flex flex-col gap-6 w-[240px] md:w-[300px] animate-scroll-up shrink-0">
                @foreach($col3 as $item) {!! renderGalleryCard($item) !!} @endforeach
                @foreach($col3 as $item) {!! renderGalleryCard($item) !!} @endforeach
            </div>

            <div class="flex flex-col gap-6 w-[240px] md:w-[300px] animate-scroll-slow shrink-0 pt-10">
                @foreach($col4 as $item) {!! renderGalleryCard($item) !!} @endforeach
                @foreach($col4 as $item) {!! renderGalleryCard($item) !!} @endforeach
            </div>

            <div class="flex flex-col gap-6 w-[240px] md:w-[300px] animate-scroll-fast shrink-0">
                @foreach($col5 as $item) {!! renderGalleryCard($item) !!} @endforeach
                @foreach($col5 as $item) {!! renderGalleryCard($item) !!} @endforeach
            </div>

        </div>
    </div>

    <div class="relative z-20 text-center -mt-32">
        <div class="inline-flex flex-col items-center gap-4 bg-[#0a0a0a]/80 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl">
            <p class="text-white text-lg font-bold">Ingin menjadi bagian dari cerita kami?</p>
            <a href="#join" class="group relative px-8 py-3 bg-white text-black font-black uppercase tracking-wider rounded-full hover:bg-[#05D9E7] transition-all duration-300">
                <span class="relative z-10">Buat Ceritamu Disini</span>
                <div class="absolute inset-0 bg-[#05D9E7] blur-lg opacity-0 group-hover:opacity-50 transition-opacity duration-300 rounded-full"></div>
            </a>
        </div>
    </div>

</section>

<!-- SECTION 7: PROJECT SHOWCASE -->
<section 
    id="projects" 
    class="relative w-full h-screen min-h-[600px] flex items-center bg-[#0a0a0a] overflow-hidden border-t border-white/5"
    x-data="projectSlider()"
    @keydown.right.window="next()"
    @keydown.left.window="prev()"
    @keydown.escape.window="closeModal()"
>
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-[#05D9E7]/5 blur-[120px] rounded-full"></div>
    </div>

    <div class="max-w-7xl w-full mx-auto px-6 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <div class="relative w-full flex flex-col items-center justify-center lg:pr-10">
                
                <div class="relative w-full max-w-[400px]">
                    
                    <button 
                        @click="prev()"
                        class="absolute top-1/2 -left-4 md:-left-16 -translate-y-1/2 z-30 p-3 rounded-full border border-white/10 bg-[#161616]/80 backdrop-blur text-gray-400 hover:text-white hover:border-[#05D9E7] transition-all group shadow-xl"
                    >
                        <svg class="w-6 h-6 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    </button>

                    <div class="relative w-full h-[480px] overflow-hidden rounded-2xl">
                        <template x-for="(card, index) in cards" :key="card.id">
                            <div 
                                class="absolute top-0 left-0 w-full h-full transition-all duration-500 ease-in-out"
                                :style="getSlideStyle(index)"
                            >
                                <div class="flex flex-col h-full w-full bg-[#161616] border border-white/10 rounded-2xl shadow-2xl overflow-hidden group">
                                    
                                    <div class="relative h-[220px] w-full border-b border-white/5 bg-[#121212] flex items-center justify-center p-10">
                                        <img 
                                            :src="card.img" 
                                            class="h-full w-full object-contain transition-transform duration-700 group-hover:scale-110 drop-shadow-[0_0_15px_rgba(255,255,255,0.1)]" 
                                            alt="Project Logo"
                                        >
                                        <div class="absolute top-4 right-4 bg-[#05D9E7]/10 border border-[#05D9E7]/20 px-3 py-1 rounded-full">
                                            <span class="text-[10px] font-bold text-[#05D9E7] tracking-wider" x-text="card.category"></span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col p-6 gap-4 flex-1">
                                        <div>
                                            <h4 class="text-xl font-bold text-white truncate mb-2" x-text="card.title"></h4>
                                            <p class="text-sm text-gray-400 line-clamp-3 leading-relaxed" x-text="card.short_desc"></p>
                                        </div>

                                        <div class="flex items-center justify-between pt-4 border-t border-white/5 mt-auto">
                                            <span class="text-xs text-gray-600 font-mono">RIT Project</span>
                                            <button 
                                                @click="openModal(card)"
                                                class="flex items-center gap-2 text-white hover:text-[#05D9E7] transition-colors group/btn"
                                            >
                                                <span class="text-xs font-bold uppercase tracking-wider">Detail</span>
                                                <div class="bg-white/10 p-1.5 rounded-full group-hover/btn:bg-[#05D9E7] group-hover/btn:text-black transition-all">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <button 
                        @click="next()"
                        class="absolute top-1/2 -right-4 md:-right-16 -translate-y-1/2 z-30 p-3 rounded-full border border-white/10 bg-[#161616]/80 backdrop-blur text-gray-400 hover:text-white hover:border-[#05D9E7] transition-all group shadow-xl"
                    >
                        <svg class="w-6 h-6 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>

                </div>

                <div class="flex gap-2 mt-6">
                    <template x-for="(card, index) in cards" :key="index">
                        <button 
                            @click="activeIndex = index"
                            class="h-1.5 rounded-full transition-all duration-300 cursor-pointer" 
                            :class="index === activeIndex ? 'w-8 bg-[#05D9E7]' : 'w-2 bg-gray-700 hover:bg-gray-500'"
                        ></button>
                    </template>
                </div>

            </div>

            <div class="flex flex-col justify-center items-start space-y-8 relative z-10">
                
                <div>
                    <h2 class="text-xs font-mono font-bold tracking-[0.3em] text-[#05D9E7] uppercase mb-4">Our Creations</h2>
                    <h3 class="text-5xl md:text-7xl font-black text-white leading-none mb-6">
                        PROJECT <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#05D9E7] to-blue-600">SHOWCASE</span>
                    </h3>
                    <p class="text-gray-400 text-lg leading-relaxed max-w-lg">
                        Kami menghadirkan karya-karya pada bagian dunia teknologi mulai dari aplikasi web, video game, dan perangkat IoT yang solutif.
                    </p>
                </div>

                <div class="w-full max-w-md bg-gradient-to-r from-[#161616] to-transparent border-l-4 border-[#05D9E7] p-6 rounded-r-xl">
                    <p class="text-gray-300 text-sm leading-relaxed mb-3">
                        Berbagai project lainnya sedang dalam proses pengerjaan, yuk jadi bagian di dalamnya!
                    </p>
                    <a href="#join" class="inline-flex items-center text-[#05D9E7] font-bold text-sm hover:translate-x-2 transition-transform">
                        Gabung Sekarang 
                        <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                </div>

            </div>

        </div>
    </div>

    <div 
        x-show="isModalOpen"
        style="display: none;"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-8"
    >
        <div 
            x-show="isModalOpen"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 backdrop-blur-none"
            x-transition:enter-end="opacity-100 backdrop-blur-md"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 backdrop-blur-md"
            x-transition:leave-end="opacity-0 backdrop-blur-none"
            class="absolute inset-0 bg-black/80"
            @click="closeModal()"
        ></div>

        <div 
            x-show="isModalOpen"
            x-transition:enter="transition cubic-bezier(0.34, 1.56, 0.64, 1) duration-500"
            x-transition:enter-start="opacity-0 scale-90 translate-y-12"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 translate-y-12"
            class="relative w-full max-w-4xl bg-[#121212] border border-white/10 rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.5)] overflow-hidden flex flex-col md:flex-row max-h-[85vh]"
        >
            <button @click="closeModal()" class="absolute top-4 right-4 z-50 p-2 bg-black/50 rounded-full text-white hover:bg-red-500 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>

            <div class="w-full md:w-5/12 h-64 md:h-auto relative bg-[#0a0a0a] flex items-center justify-center p-12">
                <img :src="modalData.img" class="w-full h-full object-contain drop-shadow-2xl" alt="Detail">
                <div class="absolute inset-0 bg-gradient-to-t from-[#121212] via-transparent to-transparent md:bg-gradient-to-r opacity-50"></div>
            </div>

            <div class="w-full md:w-7/12 p-8 md:p-10 overflow-y-auto custom-scrollbar bg-[#161616]">
                <div class="flex items-center gap-3 mb-6">
                    <span class="px-3 py-1 bg-[#05D9E7]/10 border border-[#05D9E7]/20 rounded text-[#05D9E7] text-xs font-bold tracking-widest" x-text="modalData.category"></span>
                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <h3 class="text-3xl md:text-4xl font-black text-white mb-6 leading-tight" x-text="modalData.title"></h3>
                
                <div class="space-y-5 text-gray-400 text-sm md:text-base leading-relaxed">
                    <p x-text="modalData.desc_long"></p>
                    <p>[detail ASAP here]</p>
                </div>
                
                <div class="mt-10">
                     <a :href="modalData.link" class="group inline-flex items-center justify-center w-full py-4 bg-white text-black font-black rounded-xl hover:bg-[#05D9E7] transition-all transform hover:-translate-y-1 shadow-lg">
                        ACCESS PROJECT
                        <svg class="w-4 h-4 ml-2 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('projectSlider', () => ({
            activeIndex: 0,
            isModalOpen: false,
            modalData: { title: '', category: '', img: '', short_desc: '', desc_long: '', link: '#' },

            cards: [
                {
                    id: 1,
                    title: 'Web App Manajemen Organisasi',
                    category: 'WEB DEVELOPMENT',
                    short_desc: 'Platform terintegrasi untuk mengelola administrasi dan kegiatan organisasi, hingga manajemen project secara real-time.',
                    desc_long: 'Web App ini dirancang khusus untuk RIT guna mempermudah administrasi (Keuangan, Inventaris & Surat). Fitur mencakup manajemen anggota database, tracking uang kas otomatis, dan Manajemen Project yang memastikan seluruh tim keep on track.',
                    img: "{{ asset('images/logo/RIT WebDev Biru.png') }}",
                    link: '/login'
                },
                {
                    id: 2,
                    title: 'Internet of Things',
                    category: 'INTERNET OF THINGS',
                    short_desc: 'Platform terintegrasi untuk mengelola administrasi dan kegiatan organisasi, hingga manajemen project secara real-time.',
                    desc_long: 'Web App ini dirancang khusus untuk RIT guna mempermudah administrasi (Keuangan, Inventaris & Surat). Fitur mencakup manajemen anggota database, tracking uang kas otomatis, dan Manajemen Project yang memastikan seluruh tim keep on track.',
                    img: "{{ asset('images/logo/RIT IoT Biru.png') }}",
                    link: '/login'
                },
                {
                    id: 3,
                    title: 'Game',
                    category: 'GAME DEVELOPMENT',
                    short_desc: 'Platform terintegrasi untuk mengelola administrasi dan kegiatan organisasi, hingga manajemen project secara real-time.',
                    desc_long: 'Web App ini dirancang khusus untuk RIT guna mempermudah administrasi (Keuangan, Inventaris & Surat). Fitur mencakup manajemen anggota database, tracking uang kas otomatis, dan Manajemen Project yang memastikan seluruh tim keep on track.',
                    img: "{{ asset('images/logo/RIT GameDev Biru.png') }}",
                    link: '/login'
                }
            ],

            next() {
                this.activeIndex = (this.activeIndex + 1) % this.cards.length;
            },
            prev() {
                this.activeIndex = (this.activeIndex - 1 + this.cards.length) % this.cards.length;
            },

            // LOGIC SLIDER HORIZONTAL
            getSlideStyle(index) {
                // Menghitung posisi relatif
                // Active = 0, Previous = -100%, Next = 100%
                
                let diff = index - this.activeIndex;
                
                // Logic agar tombol prev/next selalu menampilkan kartu terdekat secara visual (Looping 3 items)
                if (diff === -2) diff = 1; // Kartu pertama pindah ke kanan kartu terakhir
                if (diff === 2) diff = -1; // Kartu terakhir pindah ke kiri kartu pertama

                if (diff === 0) {
                    return 'transform: translateX(0) scale(1); opacity: 1; z-index: 20;';
                } else if (diff < 0) {
                    return 'transform: translateX(-110%) scale(0.9); opacity: 0; z-index: 10; pointer-events: none;';
                } else {
                    return 'transform: translateX(110%) scale(0.9); opacity: 0; z-index: 10; pointer-events: none;';
                }
            },

            openModal(item) {
                this.modalData = item;
                this.isModalOpen = true;
                document.body.style.overflow = 'hidden';
            },
            closeModal() {
                this.isModalOpen = false;
                document.body.style.overflow = '';
            }
        }));
    });
</script>

<!-- SECTION 8: JOIN US -->
<section 
    id="join" 
    class="relative w-full min-h-screen flex flex-col items-center justify-center bg-[#0a0a0a] overflow-hidden"
    x-data="joinFormLogicFinalV7()"
>
    <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none select-none">
        <div class="absolute inset-0 bg-[#0a0a0a]"></div>
        
        <div class="absolute bottom-0 left-0 right-0 h-[80vh]"
             style="background: radial-gradient(ellipse at bottom center, rgba(5, 217, 231, 0.6) 0%, rgba(37, 99, 235, 0.3) 40%, transparent 70%); z-index: 0;">
        </div>

        <div class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-[65%] z-0 opacity-40 pointer-events-none mix-blend-screen animate-logo-shine">
            <img src="{{ asset('images/logo/Black Logo.png') }}" 
                 alt="RIT Left Logo" 
                 class="w-[300px] md:w-[500px] h-auto object-contain logo-glow-effect transform scale-x-[-1]"> 
        </div>

        <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-[65%] z-0 opacity-40 pointer-events-none mix-blend-screen animate-logo-shine">
            <img src="{{ asset('images/logo/Black Logo.png') }}" 
                 alt="RIT Right Logo" 
                 class="w-[300px] md:w-[500px] h-auto object-contain logo-glow-effect">
        </div>
        
        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-b from-transparent to-[#0a0a0a] z-10"></div>
    </div>

    <style>
        .logo-glow-effect {
            filter: drop-shadow(0 0 5px #05D9E7) drop-shadow(0 0 20px #2563eb);
        }
        .animate-logo-shine {
            animation: logoShineAnim 6s ease-in-out infinite alternate;
        }
        @keyframes logoShineAnim {
            0% { opacity: 0.3; filter: drop-shadow(0 0 5px #05D9E7) drop-shadow(0 0 15px #2563eb) brightness(1); }
            100% { opacity: 0.6; filter: drop-shadow(0 0 15px #05D9E7) drop-shadow(0 0 40px #05D9E7) brightness(1.4) hue-rotate(15deg); }
        }
    </style>

    <div class="relative z-20 w-full max-w-4xl px-4 flex flex-col items-center mt-10">
        
        <div class="mb-6 inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-white/10 bg-white/5 backdrop-blur-md shadow-[0_0_20px_rgba(5,217,231,0.2)]">
            <span class="relative flex h-2 w-2">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#05D9E7] opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2 w-2 bg-[#05D9E7]"></span>
            </span>
            <span class="text-xs font-medium text-gray-300">Open Recruitment 2026</span>
        </div>

        <h1 class="text-5xl md:text-7xl font-black text-center text-white leading-tight mb-2 drop-shadow-lg">
            READY TO <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#05D9E7] via-white to-[#05D9E7] animate-gradient-x">START YOUR JOURNEY?</span>
        </h1>
        
        <p class="text-[#05D9E7] font-bold text-xl md:text-2xl tracking-widest uppercase mb-12 text-center animate-pulse drop-shadow-[0_0_10px_rgba(5,217,231,0.5)]">
            VENTURE IT WITH US!
        </p>

        <div class="w-full max-w-[750px] relative group" @click.outside="closeAllDropdowns()">
            
            <div class="absolute -inset-0.5 bg-gradient-to-b from-[#05D9E7]/30 to-blue-600/30 rounded-3xl opacity-20 blur-md group-hover:opacity-50 transition duration-500 animate-gradient-x"></div>
            
            <div class="relative bg-[#161616]/80 backdrop-blur-xl rounded-3xl border border-white/10 shadow-2xl overflow-visible">
                
                <div class="relative px-6 pt-6 pb-2">
                    <textarea 
                        x-model="formData.name"
                        placeholder="Ketik Nama Lengkap Anda di sini..." 
                        class="w-full bg-transparent text-lg text-white placeholder-gray-400 border-none focus:ring-0 resize-none h-[60px] custom-scrollbar focus:outline-none"
                    ></textarea>
                </div>

                <div class="px-4 pb-4 pt-2 flex flex-col md:flex-row items-center justify-between gap-4 border-t border-white/5 mt-2">
                    
                    <div class="flex flex-wrap items-center gap-2 w-full md:w-auto relative">
                        
                        <div class="relative">
                            <button 
                                @click="toggleDropdown('prodi')"
                                type="button"
                                class="flex items-center gap-2 px-3 py-2 rounded-lg border text-xs font-bold transition-all"
                                :class="formData.prodi ? 'bg-[#05D9E7]/20 border-[#05D9E7] text-[#05D9E7]' : 'bg-[#1a1a1a] border-white/10 text-gray-400 hover:text-white hover:bg-white/5'"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                <span class="max-w-[120px] truncate" x-text="formData.prodi || 'Pilih Prodi'"></span>
                                <svg class="w-3 h-3 transition-transform duration-200" :class="activeDropdown === 'prodi' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>

                            <div x-show="activeDropdown === 'prodi'" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="absolute bottom-full left-0 mb-2 w-72 bg-[#1a1a1a] border border-white/10 rounded-xl shadow-2xl z-50 p-1 max-h-60 overflow-y-auto custom-scrollbar ring-1 ring-white/5"
                                 style="display: none;">
                                <template x-for="p in options.prodi">
                                    <button type="button" @click="selectOption('prodi', p)" class="w-full text-left px-3 py-2.5 text-xs text-gray-300 hover:bg-[#05D9E7]/10 hover:text-[#05D9E7] rounded-lg transition-colors truncate" x-text="p"></button>
                                </template>
                            </div>
                        </div>

                        <div class="relative">
                            <button 
                                @click="toggleDropdown('semester')"
                                type="button"
                                class="flex items-center gap-2 px-3 py-2 rounded-lg border text-xs font-bold transition-all"
                                :class="formData.semester ? 'bg-[#05D9E7]/20 border-[#05D9E7] text-[#05D9E7]' : 'bg-[#1a1a1a] border-white/10 text-gray-400 hover:text-white hover:bg-white/5'"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span x-text="formData.semester ? 'Sem ' + formData.semester : 'Semester'"></span>
                                <svg class="w-3 h-3 transition-transform duration-200" :class="activeDropdown === 'semester' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>

                            <div x-show="activeDropdown === 'semester'" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="absolute bottom-full left-0 mb-2 w-32 bg-[#1a1a1a] border border-white/10 rounded-xl shadow-2xl z-50 p-1 max-h-48 overflow-y-auto custom-scrollbar ring-1 ring-white/5"
                                 style="display: none;">
                                <template x-for="s in options.semester">
                                    <button type="button" @click="selectOption('semester', s)" class="w-full text-left px-3 py-2.5 text-xs text-gray-300 hover:bg-[#05D9E7]/10 hover:text-[#05D9E7] rounded-lg transition-colors" x-text="'Semester ' + s"></button>
                                </template>
                            </div>
                        </div>

                        <div class="relative">
                            <button 
                                @click="toggleDropdown('divisi')"
                                type="button"
                                class="flex items-center gap-2 px-3 py-2 rounded-lg border text-xs font-bold transition-all"
                                :class="formData.divisi ? 'bg-[#05D9E7]/20 border-[#05D9E7] text-[#05D9E7]' : 'bg-[#1a1a1a] border-white/10 text-gray-400 hover:text-white hover:bg-white/5'"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                <span class="max-w-[120px] truncate" x-text="formData.divisi || 'Minat Divisi'"></span>
                                <svg class="w-3 h-3 transition-transform duration-200" :class="activeDropdown === 'divisi' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>

                            <div x-show="activeDropdown === 'divisi'" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="absolute bottom-full left-0 mb-2 w-56 bg-[#1a1a1a] border border-white/10 rounded-xl shadow-2xl z-50 p-1 max-h-60 overflow-y-auto custom-scrollbar ring-1 ring-white/5"
                                 style="display: none;">
                                <template x-for="d in options.divisi">
                                    <button type="button" @click="selectOption('divisi', d)" class="w-full text-left px-3 py-2.5 text-xs text-gray-300 hover:bg-[#05D9E7]/10 hover:text-[#05D9E7] rounded-lg transition-colors truncate" x-text="d"></button>
                                </template>
                            </div>
                        </div>

                    </div>

                    <button 
                        @click="submitForm()"
                        :disabled="!isFormValid"
                        class="flex items-center gap-2 px-8 py-3 rounded-full text-sm font-black bg-[#05D9E7] text-black hover:bg-white transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-700 disabled:text-gray-500 shadow-[0_0_30px_rgba(5,217,231,0.4)] hover:shadow-[0_0_50px_rgba(5,217,231,0.6)] active:scale-95 w-full md:w-auto justify-center relative overflow-hidden group/btn"
                    >
                        <span class="relative z-10">JOIN SQUAD</span>
                        <svg class="w-4 h-4 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 12h14" /></svg>
                        <div class="absolute inset-0 bg-white opacity-0 group-hover/btn:opacity-20 transition-opacity"></div>
                    </button>

                </div>

            </div>

            <div class="mt-8 flex flex-wrap justify-center gap-8 text-xs font-mono text-gray-400">
                <span class="flex items-center gap-2 cursor-default hover:text-[#05D9E7] transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> 
                    Official RIT Community
                </span>
                <span class="flex items-center gap-2 cursor-default hover:text-[#05D9E7] transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg> 
                    Secure Registration
                </span>
            </div>

        </div>

    </div>
</section>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('joinFormLogicFinalV7', () => ({
            activeDropdown: null,
            formData: {
                name: '',
                prodi: '',
                semester: '',
                divisi: ''
            },
            options: {
                prodi: [
                    'Rekayasa Perangkat Lunak (RPL)', 
                    'Rekayasa Sistem Komputer (RSK)', 
                    'Teknologi Informasi (TI)', 
                    'Ilmu Komunikasi'
                ],
                semester: ['1', '2', '3', '4', '5', '6', '7', '8'],
                divisi: [
                    'General (Umum)', 
                    'Web Development', 
                    'Game Development', 
                    'Cyber Security', 
                    'Internet of Things', 
                    'Game Community'
                ]
            },

            get isFormValid() {
                return this.formData.name.trim() !== '' && 
                       this.formData.prodi !== '' && 
                       this.formData.semester !== '' && 
                       this.formData.divisi !== '';
            },

            toggleDropdown(name) {
                if (this.activeDropdown === name) {
                    this.activeDropdown = null;
                } else {
                    this.activeDropdown = name;
                }
            },

            closeAllDropdowns() {
                this.activeDropdown = null;
            },

            selectOption(field, value) {
                this.formData[field] = value;
                this.activeDropdown = null;
            },

            submitForm() {
                if (!this.isFormValid) return;

                const text = `Halo Admin RIT! %0A%0ASaya tertarik untuk bergabung.%0A%0A *DATA DIRI*%0ANama: ${this.formData.name}%0AProdi: ${this.formData.prodi}%0ASemester: ${this.formData.semester}%0AMinat Divisi: ${this.formData.divisi}%0A%0AMohon informasinya lebih lanjut. Terima kasih! `;
                
                // NOMOR WHATSAPP ATMIN
                const phoneNumber = '6285198731330'; 
                window.open(`https://wa.me/${phoneNumber}?text=${text}`, '_blank');
            }
        }));
    });
</script>

<style>
    .animate-gradient-x {
        background-size: 200% 200%;
        animation: gradient-x 5s ease infinite;
    }
    @keyframes gradient-x {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #05D9E7; }
    
    .z-50 { z-index: 50; }
</style>

<!-- SECTION 9: CONTACT & TEAM -->
<section 
    id="canal" 
    class="relative w-full py-20 bg-[#0a0a0a] overflow-hidden border-t border-white/5"
    x-data="orbitalCanalFix()"
>
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute top-1/2 right-0 -translate-y-1/2 w-[600px] h-[600px] bg-[#05D9E7]/5 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-blue-600/5 blur-[100px] rounded-full"></div>
    </div>

    <div class="max-w-7xl w-full mx-auto px-6 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <div class="flex flex-col justify-center items-start text-left order-2 lg:order-1 lg:pl-24">
                
                <div class="mb-6 inline-flex items-center gap-2 px-3 py-1 rounded-full border border-[#05D9E7]/30 bg-[#05D9E7]/10">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#05D9E7] opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-[#05D9E7]"></span>
                    </span>
                    <span class="text-[10px] font-bold text-[#05D9E7] tracking-widest uppercase">Connect With Us</span>
                </div>

                <h2 class="text-5xl md:text-7xl font-black text-white leading-none mb-6">
                    JOIN OUR <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#05D9E7] to-blue-600">CANAL</span>
                </h2>
                
                <p class="text-gray-400 text-lg leading-relaxed max-w-lg mb-8">
                    Jangan ketinggalan informasi terbaru. Terhubunglah dengan RIT melalui berbagai platform media sosial kami. Diskusi, event, dan kolaborasi ada di sini.
                </p>

                <a href="#join" class="group flex items-center gap-2 text-white font-bold hover:text-[#05D9E7] transition-colors">
                    <span class="border-b border-[#05D9E7] pb-0.5">Gabung Komunitas</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>

            <div class="relative flex items-center justify-center h-[500px] order-1 lg:order-2 perspective-1000">
                
                <div class="relative w-[280px] h-[280px] md:w-[400px] md:h-[400px] flex items-center justify-center group">
                    
                    <div class="absolute z-20 w-24 h-24 rounded-full bg-[#0a0a0a] border border-[#05D9E7]/30 shadow-[0_0_60px_rgba(5,217,231,0.15)] flex items-center justify-center animate-pulse-slow">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#161616] to-black flex items-center justify-center border border-white/5">
                            <span class="text-2xl font-black text-[#05D9E7] tracking-tighter">RIT</span>
                        </div>
                        <div class="absolute inset-0 rounded-full border border-[#05D9E7]/20 animate-ping-slow"></div>
                    </div>

                    <div class="absolute inset-0 rounded-full border border-white/10 shadow-[0_0_20px_rgba(255,255,255,0.02)]"></div> 
                    <div class="absolute inset-[20%] rounded-full border border-white/5 border-dashed animate-spin-slow-reverse opacity-30"></div> 

                    <div class="absolute w-full h-full animate-orbit group-hover:paused">
                        
                        <template x-for="(item, index) in socials" :key="index">
                            <a 
                                :href="item.url" 
                                target="_blank"
                                class="absolute w-12 h-12 md:w-14 md:h-14 rounded-full bg-[#161616] border border-white/20 hover:border-[#05D9E7] hover:bg-[#05D9E7] hover:text-black hover:scale-110 hover:shadow-[0_0_30px_rgba(5,217,231,0.6)] text-gray-400 transition-all duration-300 flex items-center justify-center cursor-pointer z-30 group/icon"
                                :style="getPositionStyle(index, socials.length)"
                            >
                                <div class="relative flex flex-col items-center animate-orbit-reverse group-hover:paused">
                                    
                                    <div class="absolute bottom-full mb-2 opacity-0 group-hover/icon:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap z-40">
                                        <div class="bg-white text-black text-[10px] font-bold px-2 py-1 rounded shadow-lg relative">
                                            <span x-text="item.name"></span>
                                            <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-white"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="w-5 h-5 md:w-6 md:h-6" x-html="item.icon"></div>

                                </div>
                            </a>
                        </template>

                    </div>

                </div>

            </div>

        </div>
    </div>
</section>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('orbitalCanalFix', () => ({
            socials: [
                {
                    name: 'WhatsApp',
                    url: 'https://chat.whatsapp.com/By2q5fyT55oK2GCxuxEFFp',
                    icon: `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>`
                },
                {
                    name: 'Instagram',
                    url: 'https://www.instagram.com/republic_it',
                    icon: `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>`
                },
                {
                    name: 'Discord',
                    url: 'https://discord.com/invite/uvvy7atRT8',
                    icon: `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.317 4.3698a19.7913 19.7913 0 00-4.8851-1.5152.0741.0741 0 00-.0785.0371c-.211.3753-.4447.8648-.6083 1.2495-1.8447-.2762-3.68-.2762-5.4868 0-.1636-.3933-.4058-.8742-.6177-1.2495a.077.077 0 00-.0785-.037 19.7363 19.7363 0 00-4.8852 1.515.0699.0699 0 00-.0321.0277C.5334 9.0458-.319 13.5799.0992 18.0578a.0824.0824 0 00.0312.0561c2.0528 1.5076 4.0413 2.4228 5.9929 3.0294a.0777.0777 0 00.0842-.0276c.4616-.6304.8731-1.2952 1.226-1.9942a.076.076 0 00-.0416-.1057c-.6528-.2476-1.2743-.5495-1.8722-.8923a.077.077 0 01-.0076-.1277c.1258-.0943.2517-.1923.3718-.2914a.0743.0743 0 01.0776-.0105c3.9278 1.7933 8.18 1.7933 12.0614 0a.0739.0739 0 01.0785.0095c.1202.099.246.1981.3728.2924a.077.077 0 01-.0066.1276 12.2986 12.2986 0 01-1.873.8914.0766.0766 0 00-.0407.1067c.3604.698.7719 1.3628 1.225 1.9932a.076.076 0 00.0842.0286c1.961-.6067 3.9495-1.5219 6.0023-3.0294a.077.077 0 00.0313-.0552c.5004-5.177-.8382-9.6739-3.5485-13.6604a.061.061 0 00-.0312-.0286zM8.02 15.3312c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9555-2.4189 2.157-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.946 2.419-2.1568 2.419zm7.9748 0c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9554-2.4189 2.1569-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.946 2.419-2.1568 2.419z"/></svg>`
                },
                {
                    name: 'YouTube',
                    url: 'https://www.youtube.com/@republic_it',
                    icon: `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>`
                },
                {
                    name: 'GitHub',
                    url: 'https://github.com/RIT-Base',
                    icon: `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>`
                }
            ],

            getPositionStyle(index, total) {
                // Radius = 50% container
                const radius = 50; 
                const angle = (index * 360) / total; 
                const angleRad = (angle - 90) * (Math.PI / 180);
                
                const left = 50 + (radius * Math.cos(angleRad));
                const top = 50 + (radius * Math.sin(angleRad));

                // Margin adjustment for icon center alignment
                // Icons are approx 3.5rem - 4rem. Half is ~1.75rem or 2rem.
                return `left: ${left}%; top: ${top}%; margin-left: -1.75rem; margin-top: -1.75rem;`;
            }
        }))
    })
</script>

<style>
    /* 1. ANIMASI ORBIT (DIPERLAMBAT 60s) */
    @keyframes orbit {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-orbit {
        animation: orbit 60s linear infinite;
    }

    /* 2. ANIMASI COUNTER-ORBIT (DIPERLAMBAT 60s) */
    @keyframes orbit-reverse {
        from { transform: rotate(360deg); }
        to { transform: rotate(0deg); }
    }
    .animate-orbit-reverse {
        animation: orbit-reverse 60s linear infinite;
    }

    /* Helper Animations */
    .animate-spin-slow-reverse {
        animation: spin-reverse 40s linear infinite;
    }
    @keyframes spin-reverse {
        from { transform: rotate(360deg); }
        to { transform: rotate(0deg); }
    }

    .animate-pulse-slow {
        animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    .animate-ping-slow {
        animation: ping 3s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    /* Pause Animation on Hover */
    .group:hover .group-hover\:paused,
    .group-hover\:paused:hover {
        animation-play-state: paused;
    }
    
    .perspective-1000 {
        perspective: 1000px;
    }
</style>

<!-- SECTION 10 : Team -->
<section 
    id="team" 
    class="relative w-full py-16 bg-[#0a0a0a] overflow-hidden border-t border-white/5"
    x-data="teamData()"
>
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[1000px] h-[300px] bg-[#05D9E7]/5 blur-[120px] rounded-full"></div>
    </div>

    <div class="max-w-7xl w-full mx-auto px-6 relative z-10 flex flex-col items-center">
        
        <div class="text-center mb-12">
            <h2 class="text-xs font-mono font-bold tracking-[0.3em] text-[#05D9E7] uppercase mb-2">Behind The Scene</h2>
            <h3 class="text-4xl md:text-6xl font-black text-white leading-tight mb-4">
                THE <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#05D9E7] to-blue-600">CREATORS</span>
            </h3>
            <p class="text-gray-400 text-sm md:text-base font-medium">
                Mereka, dibalik adanya website ini:
            </p>
        </div>

        <div class="flex flex-wrap justify-center gap-4 w-full">
            
            <template x-for="(member, index) in members" :key="index">
                <div 
                    @mouseenter="active = index"
                    @mouseleave="active = null"
                    class="relative overflow-hidden rounded-[50px] transition-all duration-500 ease-[cubic-bezier(0.25,1,0.5,1)] group cursor-default border border-white/10"
                    :class="active === index ? 'w-[340px] bg-[#161616] shadow-[0_0_30px_rgba(5,217,231,0.15)] border-[#05D9E7]/50' : 'w-20 md:w-24 bg-transparent border-transparent grayscale hover:grayscale-0'"
                    style="height: 96px;" 
                >
                    <div class="absolute inset-0 flex items-center p-2">
                        
                        <div class="relative w-16 h-16 md:w-20 md:h-20 shrink-0 rounded-full overflow-hidden border-2 transition-all duration-300 z-10 bg-[#1a1a1a]"
                             :class="active === index ? 'border-[#05D9E7] scale-100' : 'border-white/20 scale-95'">
                            <img :src="member.avatar" :alt="member.name" class="w-full h-full object-cover">
                        </div>

                        <div 
                            class="flex flex-col justify-center pl-4 pr-2 min-w-[220px] transition-all duration-500 delay-100"
                            :class="active === index ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-10 pointer-events-none'"
                        >
                            <h4 class="text-white font-bold text-lg leading-none truncate" x-text="member.name"></h4>
                            <p class="text-[#05D9E7] text-xs font-mono mt-1 mb-3 truncate" x-text="member.role"></p>
                            
                            <a :href="member.link" target="_blank" class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-white transition-colors group/btn w-fit">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-tr from-yellow-500 via-red-500 to-purple-600 flex items-center justify-center text-white group-hover/btn:scale-110 transition-transform">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </div>
                                <span class="border-b border-transparent group-hover/btn:border-gray-400 transition-all">Follow Instagram</span>
                            </a>
                        </div>

                    </div>
                </div>
            </template>

        </div>

    </div>
</section>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('teamData', () => ({
            active: null,
            members: [
                {
                    name: 'Fauzan Faiz Alghifari',
                    role: 'All Role',
                    link: 'https://www.instagram.com/fauzanfaizalghifari/',
                    avatar: "{{ asset('images/avatar/avatar 1.png') }}"
                },
                {
                    name: 'Ahmad Basir',
                    role: 'All In',
                    link: 'https://www.instagram.com/_ahmdbsir/',
                    avatar: "{{ asset('images/avatar/avatar 3.png') }}"
                },
                {
                    name: 'Rizki Fadilah',
                    role: 'All Out',
                    link: 'https://www.instagram.com/republic_it/',
                    avatar: "{{ asset('images/avatar/avatar 2.png') }}"
                },
                {
                    name: 'Ayunda Nasywa',
                    role: 'All-lamak~',
                    link: 'https://www.instagram.com/ayundaansw/',
                    avatar: "{{ asset('images/avatar/avatar 4.png') }}"
                }
            ]
        }));
    });
</script>


<!-- SECTION 11: FOOTER -->
<footer class="relative w-full bg-[#0a0a0a] overflow-hidden border-t border-white/5 pt-16 pb-8">

    <div class="max-w-7xl w-full mx-auto px-6 relative z-10">
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-16">
            
            <div class="md:col-span-5 space-y-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo/rit-logo.png') }}" alt="RIT Logo" class="w-10 h-10 object-contain drop-shadow-[0_0_10px_rgba(5,217,231,0.5)]">
                    
                    <div>
                        <h3 class="text-2xl font-black text-white leading-none">RIT</h3>
                        <p class="text-[#05D9E7] text-[10px] font-bold tracking-widest uppercase">Republic of Information Technology</p>
                    </div>
                </div>
                
                <div class="space-y-4 text-gray-400 text-sm leading-relaxed border-l-2 border-white/10 pl-4">
                    <p>
                        <span class="text-white font-bold">Fakultas Komunikasi dan Informasi</span><br>
                        Universitas Garut
                    </p>
                    <p>
                        Jl. Prof K.H. Cecep Syarifudin d/h Jl. Raya Samarang No.52A<br>
                        Garut, Jawa Barat, 44151
                    </p>
                </div>
            </div>

            <div class="hidden md:block md:col-span-2"></div>

            <div class="md:col-span-2 space-y-6">
                <h4 class="text-white font-bold text-xs uppercase tracking-wider border-b border-[#05D9E7] pb-2 w-fit">Quick Links</h4>
                <ul class="space-y-3">
                    <li><a href="#home" class="text-gray-400 hover:text-[#05D9E7] text-sm transition-colors flex items-center gap-2 group"><span class="w-1 h-1 bg-[#05D9E7] rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span> Home</a></li>
                    <li><a href="#divisions" class="text-gray-400 hover:text-[#05D9E7] text-sm transition-colors flex items-center gap-2 group"><span class="w-1 h-1 bg-[#05D9E7] rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span> Community</a></li>
                    <li><a href="#gallery" class="text-gray-400 hover:text-[#05D9E7] text-sm transition-colors flex items-center gap-2 group"><span class="w-1 h-1 bg-[#05D9E7] rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span> Activities</a></li>
                    <li><a href="/login" class="text-gray-400 hover:text-[#05D9E7] text-sm transition-colors flex items-center gap-2 group"><span class="w-1 h-1 bg-[#05D9E7] rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span> Log In</a></li>
                </ul>
            </div>

            <div class="md:col-span-3 space-y-6">
                <h4 class="text-white font-bold text-xs uppercase tracking-wider border-b border-[#05D9E7] pb-2 w-fit">Connect With Us</h4>
                <div class="flex flex-wrap gap-3">
                    <a href="https://chat.whatsapp.com/By2q5fyT55oK2GCxuxEFFp" target="_blank" class="w-9 h-9 rounded-lg bg-[#161616] border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:border-[#05D9E7] hover:bg-[#05D9E7] transition-all group">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </a>
                    <a href="https://www.instagram.com/republic_it" target="_blank" class="w-9 h-9 rounded-lg bg-[#161616] border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:border-[#05D9E7] hover:bg-[#05D9E7] transition-all group">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="https://www.youtube.com/@republic_it" target="_blank" class="w-9 h-9 rounded-lg bg-[#161616] border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:border-[#05D9E7] hover:bg-[#05D9E7] transition-all group">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    <a href="https://github.com/RIT-Base" target="_blank" class="w-9 h-9 rounded-lg bg-[#161616] border border-white/10 flex items-center justify-center text-gray-400 hover:text-white hover:border-[#05D9E7] hover:bg-[#05D9E7] transition-all group">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    </a>
                </div>
            </div>

        </div>

    </div>

    <div class="relative z-10 w-full border-t border-white/5 pt-6 text-center px-6">
        <p class="text-xs text-gray-600">
            2026 © Wengdep | Part of RIT - Republic of Information Technology. All rights reserved.
        </p>
    </div>

</footer>
@endsection
