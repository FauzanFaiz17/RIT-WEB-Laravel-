<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manajemen Organisasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 dark:bg-gray-900">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div
            class="w-full max-w-[400px] rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900 sm:p-8">

            {{-- Header --}}
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Selamat Datang</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Masuk untuk mengelola organisasi</p>
            </div>

            {{-- Form Login --}}
            <form action="{{ url('/login') }}" method="POST">
                @csrf

                <div class="space-y-5">
                    {{-- Input Email --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Email</label>
                        <div class="relative">
                            <input type="email" name="email" placeholder="email@contoh.com" required
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">

                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                                <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2.5 5.83331C2.5 5.15888 2.5 4.82166 2.6231 4.56158C2.75333 4.28639 2.96495 4.06734 3.2307 3.92955C3.48191 3.79932 3.81608 3.79932 4.48443 3.79932H15.5156C16.1839 3.79932 16.5181 3.79932 16.7693 3.92955C17.035 4.06734 17.2467 4.28639 17.3769 4.56158C17.5 4.82166 17.5 5.15888 17.5 5.83331V14.1666C17.5 14.8411 17.5 15.1783 17.3769 15.4384C17.2467 15.7136 17.035 15.9326 16.7693 16.0704C16.5181 16.2006 16.1839 16.2006 15.5156 16.2006H4.48443C3.81608 16.2006 3.48191 16.2006 3.2307 16.0704C2.96495 15.9326 2.75333 15.7136 2.6231 15.4384C2.5 15.1783 2.5 14.8411 2.5 14.1666V5.83331Z"
                                        stroke="" stroke-width="1.5" />
                                    <path
                                        d="M2.5 5.83331C3.39763 6.68532 5.76017 8.75239 8.65349 10.3721C9.28114 10.7235 9.59496 10.8992 10 10.8992C10.405 10.8992 10.7189 10.7235 11.3465 10.3721C14.2398 8.75239 16.6024 6.68532 17.5 5.83331"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    {{-- Input Password --}}
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Password</label>
                        <div class="relative">
                            <input type="password" name="password" placeholder="********" required
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">

                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                                <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M14.1667 8.33333V5.83333C14.1667 3.53215 12.3012 1.66666 10 1.66666C7.69885 1.66666 5.83337 3.53215 5.83337 5.83333V8.33333C4.22238 8.33333 3.33337 8.33333 2.72169 8.94502C2.11001 9.5567 2.11001 10.4457 2.11001 12.2237L2.11001 12.7763C2.11001 14.5543 2.11001 15.4433 2.72169 16.055C3.33337 16.6667 4.22238 16.6667 5.83337 16.6667H14.1667C15.7777 16.6667 16.6667 16.6667 17.2784 16.055C17.8901 15.4433 17.8901 14.5543 17.8901 12.7763L17.8901 12.2237C17.8901 10.4457 17.8901 9.5567 17.2784 8.94502C16.6667 8.33333 15.7777 8.33333 14.1667 8.33333ZM12.5 5.83333C12.5 4.45262 11.3807 3.33333 10 3.33333C8.61933 3.33333 7.50004 4.45262 7.50004 5.83333V8.33333H12.5V5.83333ZM10 10.8333C9.30968 10.8333 8.75004 11.393 8.75004 12.0833C8.75004 12.7737 9.30968 13.3333 10 13.3333C10.6904 13.3333 11.25 12.7737 11.25 12.0833C11.25 11.393 10.6904 10.8333 10 10.8333Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    {{-- Error Message --}}
                    @if ($errors->any())
                        <div class="rounded-lg bg-red-50 p-3 text-sm text-red-600 dark:bg-red-500/10 dark:text-red-500">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="flex w-full justify-center rounded-lg bg-brand-500 p-3 font-medium text-white transition hover:bg-brand-600">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
