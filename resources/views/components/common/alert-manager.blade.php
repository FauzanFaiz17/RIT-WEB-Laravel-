<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition.duration.500ms>
    {{-- 1. SUCCESS ALERT --}}
    @if (session('success'))
        <div class="mb-6">
            <x-ui.alert 
                variant="success" 
                title="Berhasil!" 
                :message="session('success')" 
            />
        </div>
    @endif

    {{-- 2. ERROR ALERT (Dari Controller manual) --}}
    @if (session('error'))
        <div class="mb-6">
            <x-ui.alert 
                variant="error" 
                title="Terjadi Kesalahan" 
                :message="session('error')" 
            />
        </div>
    @endif

    {{-- 3. WARNING ALERT --}}
    @if (session('warning'))
        <div class="mb-6">
            <x-ui.alert 
                variant="warning" 
                title="Peringatan" 
                :message="session('warning')" 
            />
        </div>
    @endif

    {{-- 4. VALIDATION ERROR (Otomatis dari Laravel Validate) --}}
    @if ($errors->any())
        <div class="mb-6">
            <x-ui.alert variant="error" title="Input Tidak Valid">
                {{-- Menggunakan Slot Content sesuai contoh template --}}
                <ul class="text-sm text-gray-500 dark:text-gray-400 list-disc list-inside space-y-1 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-ui.alert>
        </div>
    @endif
</div>