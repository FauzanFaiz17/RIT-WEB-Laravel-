<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota Baru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 flex min-h-screen items-center justify-center p-4">

    {{-- Card Container --}}
    <div class="w-full max-w-[500px] rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900 sm:p-8">
        
        {{-- Header --}}
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Registrasi Anggota</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                Bergabunglah dengan komunitas kami
            </p>
        </div>

        {{-- Form --}}
        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                
                {{-- 1. NAMA LENGKAP --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama Lengkap</label>
                    <div class="relative">
                        <input type="text" name="name" placeholder="Nama Mahasiswa" value="{{ old('name') }}" required
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            {{-- Icon User --}}
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2.5C11.3807 2.5 12.5 3.61929 12.5 5C12.5 6.38071 11.3807 7.5 10 7.5C8.61929 7.5 7.5 6.38071 7.5 5C7.5 3.61929 8.61929 2.5 10 2.5ZM5.83333 5C5.83333 2.69881 7.69881 0.833333 10 0.833333C12.3012 0.833333 14.1667 2.69881 14.1667 5C14.1667 7.30119 12.3012 9.16667 10 9.16667C7.69881 9.16667 5.83333 7.30119 5.83333 5Z"/><path d="M3.33333 13.3333C3.33333 11.4924 4.82572 10 6.66667 10H13.3333C15.1743 10 16.6667 11.4924 16.6667 13.3333C16.6667 13.7936 16.2936 14.1667 15.8333 14.1667C15.3731 14.1667 15 13.7936 15 13.3333C15 12.4129 14.2538 11.6667 13.3333 11.6667H6.66667C5.74619 11.6667 5 12.4129 5 13.3333C5 13.7936 4.6269 14.1667 4.16667 14.1667C3.70643 14.1667 3.33333 13.7936 3.33333 13.3333Z"/></svg>
                        </span>
                    </div>
                </div>

                {{-- 2. EMAIL --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Email Kampus / Pribadi</label>
                    <div class="relative">
                        <input type="email" name="email" placeholder="email@contoh.com" value="{{ old('email') }}" required
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            {{-- Icon Mail --}}
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 5.83331C2.5 5.15888 2.5 4.82166 2.6231 4.56158C2.75333 4.28639 2.96495 4.06734 3.2307 3.92955C3.48191 3.79932 3.81608 3.79932 4.48443 3.79932H15.5156C16.1839 3.79932 16.5181 3.79932 16.7693 3.92955C17.035 4.06734 17.2467 4.28639 17.3769 4.56158C17.5 4.82166 17.5 5.15888 17.5 5.83331V14.1666C17.5 14.8411 17.5 15.1783 17.3769 15.4384C17.2467 15.7136 17.035 15.9326 16.7693 16.0704C16.5181 16.2006 16.1839 16.2006 15.5156 16.2006H4.48443C3.81608 16.2006 3.48191 16.2006 3.2307 16.0704C2.96495 15.9326 2.75333 15.7136 2.6231 15.4384C2.5 15.1783 2.5 14.8411 2.5 14.1666V5.83331Z" stroke="" stroke-width="1.5"/><path d="M2.5 5.83331C3.39763 6.68532 5.76017 8.75239 8.65349 10.3721C9.28114 10.7235 9.59496 10.8992 10 10.8992C10.405 10.8992 10.7189 10.7235 11.3465 10.3721C14.2398 8.75239 16.6024 6.68532 17.5 5.83331" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                    </div>
                </div>

                {{-- 3. NPM --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">NPM</label>
                    <div class="relative">
                        <input type="text" name="npm" placeholder="Contoh: 202343500123" value="{{ old('npm') }}" required
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            {{-- Icon ID Card --}}
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M4 4C2.89543 4 2 4.89543 2 6V14C2 15.1046 2.89543 16 4 16H16C17.1046 16 18 15.1046 18 14V6C18 4.89543 17.1046 4 16 4H4ZM4 5.5H16C16.2761 5.5 16.5 5.72386 16.5 6V14C16.5 14.2761 16.2761 14.5 16 14.5H4C3.72386 14.5 3.5 14.2761 3.5 14V6C3.5 5.72386 3.72386 5.5 4 5.5ZM6 7C6.55228 7 7 7.44772 7 8V10C7 10.5523 6.55228 11 6 11C5.44772 11 5 10.5523 5 10V8C5 7.44772 5.44772 7 6 7ZM9 7.5C8.72386 7.5 8.5 7.72386 8.5 8C8.5 8.27614 8.72386 8.5 9 8.5H14C14.2761 8.5 14.5 8.27614 14.5 8C14.5 7.72386 14.2761 7.5 14 7.5H9ZM8.5 10C8.5 9.72386 8.72386 9.5 9 9.5H14C14.2761 9.5 14.5 9.72386 14.5 10C14.5 10.2761 14.2761 10.5 14 10.5H9C8.72386 10.5 8.5 10.2761 8.5 10Z"/></svg>
                        </span>
                    </div>
                </div>

                {{-- 4. NO HP --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">No. Handphone (WA)</label>
                    <div class="relative">
                        <input type="text" name="no_hp" placeholder="0812xxxxxxxx" value="{{ old('no_hp') }}" required
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            {{-- Icon Phone --}}
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.55025 3.02941C5.10931 3.47035 4.90802 3.82958 4.79373 4.24021C4.65997 4.7208 4.67396 5.25337 4.90999 6.27546C5.39726 8.38573 6.64998 10.6875 8.78672 12.8242C10.9235 14.961 13.2252 16.2137 15.3355 16.701C16.3576 16.937 16.8901 16.951 17.3707 16.8172C17.7814 16.7029 18.1406 16.5016 18.5815 16.0607L18.7779 15.8643C19.074 15.5681 19.074 15.088 18.7779 14.7918L16.2082 12.2222C15.912 11.926 15.4318 11.926 15.1357 12.2222L14.5936 12.7642C14.4759 12.8819 14.3093 12.9375 14.1466 12.8986C13.8821 12.8354 13.3592 12.7001 12.593 12.2319C11.8335 11.7678 11.0269 11.0991 10.1876 10.2598C9.34825 9.42045 8.67958 8.61389 8.21542 7.85437C7.74722 7.2882 7.61191 6.76532 7.54874 6.5008C7.5098 6.33808 7.56543 6.17148 7.68316 6.05375L8.22513 5.51178C8.52134 5.21557 8.52134 4.73542 8.22513 4.43921L5.65546 1.86954C5.35925 1.57333 4.8791 1.57333 4.58289 1.86954L4.38645 2.06598L5.55025 3.02941ZM4.38645 2.06598L5.55025 3.02941L4.38645 2.06598Z" /></svg>
                        </span>
                    </div>
                </div>

                {{-- 5. PASSWORD --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Password</label>
                    <div class="relative">
                        <input type="password" name="password" placeholder="Minimal 8 karakter" required
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            {{-- Icon Lock --}}
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.1667 8.33333V5.83333C14.1667 3.53215 12.3012 1.66666 10 1.66666C7.69885 1.66666 5.83337 3.53215 5.83337 5.83333V8.33333C4.22238 8.33333 3.33337 8.33333 2.72169 8.94502C2.11001 9.5567 2.11001 10.4457 2.11001 12.2237L2.11001 12.7763C2.11001 14.5543 2.11001 15.4433 2.72169 16.055C3.33337 16.6667 4.22238 16.6667 5.83337 16.6667H14.1667C15.7777 16.6667 16.6667 16.6667 17.2784 16.055C17.8901 15.4433 17.8901 14.5543 17.8901 12.7763L17.8901 12.2237C17.8901 10.4457 17.8901 9.5567 17.2784 8.94502C16.6667 8.33333 15.7777 8.33333 14.1667 8.33333ZM12.5 5.83333C12.5 4.45262 11.3807 3.33333 10 3.33333C8.61933 3.33333 7.50004 4.45262 7.50004 5.83333V8.33333H12.5V5.83333ZM10 10.8333C9.30968 10.8333 8.75004 11.393 8.75004 12.0833C8.75004 12.7737 9.30968 13.3333 10 13.3333C10.6904 13.3333 11.25 12.7737 11.25 12.0833C11.25 11.393 10.6904 10.8333 10 10.8333Z" fill="currentColor"/></svg>
                        </span>
                    </div>
                </div>

                {{-- 6. KONFIRMASI PASSWORD --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Konfirmasi Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" placeholder="Ulangi password" required
                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                            {{-- Icon Lock --}}
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.1667 8.33333V5.83333C14.1667 3.53215 12.3012 1.66666 10 1.66666C7.69885 1.66666 5.83337 3.53215 5.83337 5.83333V8.33333C4.22238 8.33333 3.33337 8.33333 2.72169 8.94502C2.11001 9.5567 2.11001 10.4457 2.11001 12.2237L2.11001 12.7763C2.11001 14.5543 2.11001 15.4433 2.72169 16.055C3.33337 16.6667 4.22238 16.6667 5.83337 16.6667H14.1667C15.7777 16.6667 16.6667 16.6667 17.2784 16.055C17.8901 15.4433 17.8901 14.5543 17.8901 12.7763L17.8901 12.2237C17.8901 10.4457 17.8901 9.5567 17.2784 8.94502C16.6667 8.33333 15.7777 8.33333 14.1667 8.33333ZM12.5 5.83333C12.5 4.45262 11.3807 3.33333 10 3.33333C8.61933 3.33333 7.50004 4.45262 7.50004 5.83333V8.33333H12.5V5.83333ZM10 10.8333C9.30968 10.8333 8.75004 11.393 8.75004 12.0833C8.75004 12.7737 9.30968 13.3333 10 13.3333C10.6904 13.3333 11.25 12.7737 11.25 12.0833C11.25 11.393 10.6904 10.8333 10 10.8333Z" fill="currentColor"/></svg>
                        </span>
                    </div>
                </div>

                {{-- Alert Error --}}
                @if($errors->any())
                    <div class="rounded-lg bg-red-50 p-3 text-sm text-red-600 dark:bg-red-500/10 dark:text-red-500">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Tombol Daftar --}}
                <button type="submit" class="flex w-full justify-center rounded-lg bg-brand-500 p-3 font-medium text-white transition hover:bg-brand-600">
                    Daftar Sekarang
                </button>

                {{-- Link Login --}}
                <div class="text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-brand-500 hover:text-brand-600 font-medium">
                            Masuk disini
                        </a>
                    </p>
                </div>
            </div>
        </form>
    </div>

</body>
</html>