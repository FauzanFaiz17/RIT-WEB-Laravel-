<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    {{-- SECTION: META & TITLE --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Anggota | RIT Organization</title>

    {{-- SECTION: ASSETS & STYLES --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom scrollbar untuk sisi form agar lebih estetik */
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #3C50E0;
            border-radius: 10px;
        }
    </style>

    {{-- SECTION: SCRIPTS (Slider Logic) --}}
    <script>
        function setupSlider() {
            return {
                activeSlide: 0,
                timer: null,
                slides: [{
                        img: "{{ asset('images/login_register/rit_1.JPG') }}",
                        title: 'Bergabung Bersama Kami.',
                        desc: 'Jadilah bagian dari perubahan dan inovasi di RIT Organization.'
                    },
                    {
                        img: "{{ asset('images/login_register/rit_2.jpg') }}",
                        title: 'Kembangkan Potensi.',
                        desc: 'Wadah yang tepat untuk mengasah skill dan memperluas jaringan Anda.'
                    },
                    {
                        img: "{{ asset('images/login_register/rit_3.jpg') }}",
                        title: 'Akses Penuh.',
                        desc: 'Dapatkan akses ke berbagai kegiatan dan fasilitas organisasi.'
                    },
                    {
                        img: "{{ asset('images/login_register/rit_4.JPG') }}",
                        title: 'Komunitas Solid.',
                        desc: 'Bangun relasi yang kuat antar anggota dalam lingkungan yang positif.'
                    }
                ],
                init() {
                    this.startAutoSlide();
                },
                startAutoSlide() {
                    this.timer = setInterval(() => {
                        this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1;
                    }, 5000);
                },
                stopAutoSlide() {
                    clearInterval(this.timer);
                },
                goToSlide(index) {
                    this.stopAutoSlide();
                    this.activeSlide = index;
                    this.startAutoSlide();
                }
            }
        }
    </script>

    {{-- SECTION: EXTERNAL LIBRARIES & THEME --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="h-full bg-white text-gray-900 antialiased dark:bg-gray-900 dark:text-white overflow-hidden">

    {{-- PARENT CONTAINER: h-screen mengunci tampilan agar slider tidak ikut ter-scroll --}}
    <div class="flex h-screen overflow-hidden">

        {{-- ==========================================================================
             LEFT SIDE: REGISTRATION FORM SECTION (SCROLLABLE)
             ========================================================================== --}}
        <div
            class="flex flex-1 flex-col overflow-y-auto custom-scrollbar justify-start px-4 pt-0 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white dark:bg-gray-900 w-full lg:w-[45%]">
            <div class="mx-auto w-full max-w-sm lg:w-96 py-10">

                {{-- TOMBOL KEMBALI (ROUTE LANDING DISINI) --}}
                <div class="mb-10">
                    <a href="#"
                        class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 dark:bg-white/10 dark:text-gray-400 dark:hover:bg-white/20 transition-all shadow-sm">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 18l-6-6 6-6" />
                        </svg>
                    </a>
                </div>
                {{-- SUB-SECTION: LOGO & HEADER --}}
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="{{ asset('images/logo/rit-dark-logo.svg') }}" alt="Logo RIT" class="h-12 w-auto">
                    </div>
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Registrasi Anggota
                    </h2>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Lengkapi data diri Anda untuk bergabung.
                    </p>
                </div>

                {{-- SUB-SECTION: FORM FIELDS --}}
                <div class="mt-6">
                    <form action="{{ route('register') }}" method="POST" class="space-y-4">
                        @csrf

                        {{-- Name Input --}}
                        <div>
                            <label for="name"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Nama
                                Lengkap</label>
                            <div class="relative mt-2">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required
                                    placeholder="Nama Mahasiswa"
                                    class="block w-full rounded-xl border-0 bg-gray-50 py-3 pl-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-[#3C50E0] sm:text-sm sm:leading-6 dark:bg-gray-800 dark:ring-gray-700 dark:text-white dark:focus:bg-gray-800 transition-all duration-200">
                            </div>
                        </div>

                        {{-- Email Input --}}
                        <div>
                            <label for="email"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Email
                                Kampus/Pribadi</label>
                            <div class="relative mt-2">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                                        <path
                                            d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                                    </svg>
                                </div>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                    placeholder="email@contoh.com"
                                    class="block w-full rounded-xl border-0 bg-gray-50 py-3 pl-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-[#3C50E0] sm:text-sm sm:leading-6 dark:bg-gray-800 dark:ring-gray-700 dark:text-white dark:focus:bg-gray-800 transition-all duration-200">
                            </div>
                        </div>

                        {{-- NPM Input --}}
                        <div>
                            <label for="npm"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">NPM</label>
                            <div class="relative mt-2">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M4 4C2.89543 4 2 4.89543 2 6V14C2 15.1046 2.89543 16 4 16H16C17.1046 16 18 15.1046 18 14V6C18 4.89543 17.1046 4 16 4H4ZM4 5.5H16C16.2761 5.5 16.5 5.72386 16.5 6V14C16.5 14.2761 16.2761 14.5 16 14.5H4C3.72386 14.5 3.5 14.2761 3.5 14V6C3.5 5.72386 3.72386 5.5 4 5.5ZM6 7C6.55228 7 7 7.44772 7 8V10C7 10.5523 6.55228 11 6 11C5.44772 11 5 10.5523 5 10V8C5 7.44772 5.44772 7 6 7ZM9 7.5C8.72386 7.5 8.5 7.72386 8.5 8C8.5 8.27614 8.72386 8.5 9 8.5H14C14.2761 8.5 14.5 8.27614 14.5 8C14.5 7.72386 14.2761 7.5 14 7.5H9ZM8.5 10C8.5 9.72386 8.72386 9.5 9 9.5H14C14.2761 9.5 14.5 9.72386 14.5 10C14.5 10.2761 14.2761 10.5 14 10.5H9C8.72386 10.5 8.5 10.2761 8.5 10Z" />
                                    </svg>
                                </div>
                                <input id="npm" name="npm" type="text" value="{{ old('npm') }}" required
                                    placeholder="Contoh: 20234359123"
                                    oninput="this.value = this.value.replace(/[^0-9]/g,'');"
                                    class="block w-full rounded-xl border-0 bg-gray-50 py-3 pl-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-[#3C50E0] sm:text-sm sm:leading-6 dark:bg-gray-800 dark:ring-gray-700 dark:text-white dark:focus:bg-gray-800 transition-all duration-200">
                            </div>
                        </div>

                        {{-- Phone Input --}}
                        <div>
                            <label for="no_hp"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">No.
                                Handphone (WA)</label>
                            <div class="relative mt-2">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M5.55025 3.02941C5.10931 3.47035 4.90802 3.82958 4.79373 4.24021C4.65997 4.7208 4.67396 5.25337 4.90999 6.27546C5.39726 8.38573 6.64998 10.6875 8.78672 12.8242C10.9235 14.961 13.2252 16.2137 15.3355 16.701C16.3576 16.937 16.8901 16.951 17.3707 16.8172C17.7814 16.7029 18.1406 16.5016 18.5815 16.0607L18.7779 15.8643C19.074 15.5681 19.074 15.088 18.7779 14.7918L16.2082 12.2222C15.912 11.926 15.4318 11.926 15.1357 12.2222L14.5936 12.7642C14.4759 12.8819 14.3093 12.9375 14.1466 12.8986C13.8821 12.8354 13.3592 12.7001 12.593 12.2319C11.8335 11.7678 11.0269 11.0991 10.1876 10.2598C9.34825 9.42045 8.67958 8.61389 8.21542 7.85437C7.74722 7.2882 7.61191 6.76532 7.54874 6.5008C7.5098 6.33808 7.56543 6.17148 7.68316 6.05375L8.22513 5.51178C8.52134 5.21557 8.52134 4.73542 8.22513 4.43921L5.65546 1.86954C5.35925 1.57333 4.8791 1.57333 4.58289 1.86954L4.38645 2.06598L5.55025 3.02941ZM4.38645 2.06598L5.55025 3.02941L4.38645 2.06598Z" />
                                    </svg>
                                </div>
                                <input id="no_hp" name="no_hp" type="text" value="{{ old('no_hp') }}"
                                    required placeholder="0812xxxxxxxx"
                                    oninput="this.value = this.value.replace(/[^0-9]/g,'');"
                                    class="block w-full rounded-xl border-0 bg-gray-50 py-3 pl-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-[#3C50E0] sm:text-sm sm:leading-6 dark:bg-gray-800 dark:ring-gray-700 dark:text-white dark:focus:bg-gray-800 transition-all duration-200">
                            </div>
                        </div>

                        {{-- Password Input with Visibility Toggle --}}
                        <div x-data="{ show: false }">
                            <label for="password"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Password</label>
                            <div class="relative mt-2">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input :type="show ? 'text' : 'password'" id="password" name="password" required
                                    placeholder="Minimal 8 karakter"
                                    class="block w-full rounded-xl border-0 bg-gray-50 py-3 pl-10 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-[#3C50E0] sm:text-sm sm:leading-6 dark:bg-gray-800 dark:ring-gray-700 dark:text-white dark:focus:bg-gray-800 transition-all duration-200">
                                <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none cursor-pointer">
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                    <svg x-show="show" style="display: none;" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Confirmation Password --}}
                        <div x-data="{ show: false }">
                            <label for="password_confirmation"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Konfirmasi
                                Password</label>
                            <div class="relative mt-2">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input :type="show ? 'text' : 'password'" id="password_confirmation"
                                    name="password_confirmation" required placeholder="Ulangi password"
                                    class="block w-full rounded-xl border-0 bg-gray-50 py-3 pl-10 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-[#3C50E0] sm:text-sm sm:leading-6 dark:bg-gray-800 dark:ring-gray-700 dark:text-white dark:focus:bg-gray-800 transition-all duration-200">
                                <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none cursor-pointer">
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                    <svg x-show="show" style="display: none;" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Validation Errors --}}
                        @if ($errors->any())
                            <div
                                class="rounded-lg bg-red-50 p-3 text-sm text-red-600 dark:bg-red-500/10 dark:text-red-500">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <button type="submit"
                                class="flex w-full justify-center rounded-xl bg-[#3C50E0] px-3 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-500/30 hover:bg-[#3243be] hover:shadow-blue-500/40 transition-all duration-200">
                                Daftar Sekarang
                            </button>
                        </div>
                    </form>

                    {{-- SUB-SECTION: LOGIN REDIRECT --}}
                    <p class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}"
                            class="font-semibold text-[#3C50E0] hover:text-blue-500 transition-colors">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>

        {{-- ==========================================================================
             RIGHT SIDE: HERO SLIDER SECTION (FIXED/STATIC)
             ========================================================================== --}}
        <div class="relative hidden w-0 flex-1 lg:block bg-gray-900 overflow-hidden h-full" x-data="setupSlider()"
            x-init="init()">

            {{-- Background Images Slides --}}
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="activeSlide === index" x-transition:enter="transition ease-out duration-1000"
                    x-transition:enter-start="opacity-0 transform scale-105"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-1000 absolute top-0 left-0 w-full h-full"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-105" class="absolute inset-0 h-full w-full">

                    <img :src="slide.img" class="h-full w-full object-cover opacity-60">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-[#3C50E0] via-gray-900/40 to-gray-900/20 mix-blend-multiply">
                    </div>
                </div>
            </template>

            {{-- Slider Content (Fixed Position) --}}
            <div class="absolute bottom-0 left-0 right-0 p-16 text-white z-10">
                <div class="relative min-h-[160px]">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="activeSlide === index"
                            x-transition:enter="transition ease-out duration-700 delay-100"
                            x-transition:enter-start="opacity-0 translate-y-8"
                            x-transition:enter-end="opacity-100 translate-y-0" class="absolute top-0 left-0 w-full">
                            <h2 class="text-5xl font-extrabold tracking-tight mb-4" x-text="slide.title"></h2>
                            <p class="text-lg font-light text-blue-100 max-w-md" x-text="slide.desc"></p>
                        </div>
                    </template>
                </div>

                {{-- Pagination Indicators --}}
                <div class="flex gap-2 mt-4">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="goToSlide(index)"
                            class="h-1.5 rounded-full transition-all duration-500 ease-in-out cursor-pointer hover:bg-white"
                            :class="activeSlide === index ? 'w-12 bg-white' : 'w-2 bg-white/30'">
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
