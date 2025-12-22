<div class="relative" x-data="{
    dropdownOpen: false,
    toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen;
    },
    closeDropdown() {
        this.dropdownOpen = false;
    }
}" @click.away="closeDropdown()">

    {{-- CEK APAKAH USER SUDAH LOGIN --}}
    @auth
        <button
            class="flex items-center text-gray-700 dark:text-gray-400"
            @click.prevent="toggleDropdown()"
            type="button"
        >
            <span class="mr-3 overflow-hidden rounded-full h-11 w-11 border border-gray-200 dark:border-gray-700">
                <img src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random' }}" 
                     alt="User" 
                     class="h-full w-full object-cover"/>
            </span>

            <span class="block mr-1 font-medium text-theme-sm">
                {{ Auth::user()->name }}
            </span>

            <svg class="w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180': dropdownOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <div
            x-show="dropdownOpen"
            class="absolute right-0 mt-[17px] flex w-[260px] flex-col rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark z-50"
            style="display: none;"
        >
            <div class="px-2 py-2">
                <span class="block font-medium text-gray-700 text-theme-sm dark:text-gray-400">
                    {{ Auth::user()->name }}
                </span>
                <span class="mt-0.5 block text-theme-xs text-gray-500 dark:text-gray-400 truncate">
                    {{ Auth::user()->email }}
                </span>
            </div>

            <ul class="flex flex-col gap-1 pt-4 pb-3 border-b border-gray-200 dark:border-gray-800">
                <li>
                    <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-3 py-2 font-medium text-gray-700 rounded-lg group text-theme-sm hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                        Edit profile
                    </a>
                </li>
            </ul>

            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center w-full gap-3 px-3 py-2 mt-3 font-medium text-gray-700 rounded-lg group text-theme-sm hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                    Sign out
                </a>
            </form>
        </div>

    @else
        <a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600">
            <span>Masuk</span>
        </a>
    @endauth

</div>