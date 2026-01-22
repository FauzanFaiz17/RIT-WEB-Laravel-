<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | RIT Organization</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        function setupSlider() {
            return {
                activeSlide: 0,
                timer: null,
                slides: [{
                        // Perhatikan: Gunakan kutip satu (') di dalam asset()
                        img: "{{ asset('images/login_register/rit_1.JPG') }}",
                        title: 'Sinergi & Efisiensi.',
                        desc: 'Sistem informasi manajemen terpadu untuk kemudahan administrasi organisasi Anda.'
                    },
                    {
                        img: "{{ asset('images/login_register/rit_2.jpg') }}",
                        title: 'Kolaborasi Tim.',
                        desc: 'Tingkatkan produktivitas anggota dengan penjadwalan kegiatan yang terstruktur.'
                    },
                    {
                        img: "{{ asset('images/login_register/rit_3.jpg') }}",
                        title: 'Data Terpusat.',
                        desc: 'Akses data anggota dan laporan kegiatan kapan saja, di mana saja dengan aman.'
                    },
                    {
                        img: "{{ asset('images/login_register/rit_4.JPG') }}",
                        title: 'Monitoring Realtime.',
                        desc: 'Pantau perkembangan organisasi secara langsung melalui dashboard interaktif.'
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

<body class="h-full bg-white text-gray-900 antialiased dark:bg-gray-900 dark:text-white">

    <div class="flex min-h-screen">

        <div
            class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white dark:bg-gray-900 w-full lg:w-[45%]">
            <div class="mx-auto w-full max-w-sm lg:w-96">

                <div class="mb-10 ">
                    <div class="flex items-center  gap-3 mb-8">
                        <img src="{{ asset('images/logo/rit-dark-logo.svg') }}" alt="Logo RIT" class="h-12 w-auto">
                    </div>

                    <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Selamat Datang
                    </h2>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                         Gunakan akunmu untuk bisa masuk kedalam aplikasi .
                    </p>
                </div>

                <div class="mt-6">
                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="email"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Email</label>
                            <div class="relative mt-2">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                                        <path
                                            d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                                    </svg>
                                </div>
                                <input id="email" name="email" type="email" autocomplete="email" required
                                    placeholder="nama@email.com"
                                    class="block w-full rounded-xl border-0 bg-gray-50 py-3.5 pl-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-[#3C50E0] sm:text-sm sm:leading-6 dark:bg-gray-800 dark:ring-gray-700 dark:text-white dark:focus:bg-gray-800 transition-all duration-200">
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

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
                                    placeholder="••••••••"
                                    class="block w-full rounded-xl border-0 bg-gray-50 py-3.5 pl-10 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-[#3C50E0] sm:text-sm sm:leading-6 dark:bg-gray-800 dark:ring-gray-700 dark:text-white dark:focus:bg-gray-800 transition-all duration-200">
                                <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none cursor-pointer">
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
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

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember-me" name="remember" type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-[#3C50E0] focus:ring-[#3C50E0] dark:bg-gray-800 dark:border-gray-600">
                                <label for="remember-me"
                                    class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Ingat saya</label>
                            </div>
                            <div class="text-sm">
                                <a href="#"
                                    class="font-medium text-[#3C50E0] hover:text-blue-500 transition-colors">Lupa
                                    password?</a>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="flex w-full justify-center rounded-xl bg-[#3C50E0] px-3 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-500/30 hover:bg-[#3243be] hover:shadow-blue-500/40 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#3C50E0] transition-all duration-200">
                                Masuk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="relative hidden w-0 flex-1 lg:block bg-gray-900 overflow-hidden" x-data="setupSlider()"
            x-init="init()">

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

            <div class="absolute bottom-0 left-0 right-0 p-16 text-white z-10">
                <div class="relative min-h-[160px]">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="activeSlide === index"
                            x-transition:enter="transition ease-out duration-700 delay-100"
                            x-transition:enter-start="opacity-0 translate-y-8"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-300 absolute top-0 left-0 w-full"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-8">
                            <h2 class="text-5xl font-extrabold tracking-tight mb-4" x-text="slide.title"></h2>
                            <p class="text-lg font-light text-blue-100 max-w-md" x-text="slide.desc"></p>
                        </div>
                    </template>
                </div>

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
