@if (
    session('success') ||
    session('error') ||
    session('warning') ||
    $errors->any()
)
<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 4000)"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-3"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-3"
    class="fixed top-5 right-5 z-[9999] w-full max-w-md space-y-3"
>

    {{-- 1. SUCCESS ALERT --}}
    @if (session('success'))
        <x-ui.alert
            variant="success"
            title="Berhasil!"
            :message="session('success')"
        />
    @endif

    {{-- 2. ERROR ALERT --}}
    @if (session('error'))
        <x-ui.alert
            variant="error"
            title="Terjadi Kesalahan"
            :message="session('error')"
        />
    @endif

    {{-- 3. WARNING ALERT --}}
    @if (session('warning'))
        <x-ui.alert
            variant="warning"
            title="Peringatan"
            :message="session('warning')"
        />
    @endif

    {{-- 4. VALIDATION ERROR --}}
    @if ($errors->any())
        <x-ui.alert variant="error" title="Gagal Menyimpan Data">
            <ul class="text-sm list-disc list-inside space-y-1 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-ui.alert>
    @endif

</div>
@endif
