@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        Manajemen User
    </h2>
    <nav>
        <ol class="flex items-center gap-2">
            <li><a class="font-medium" href="#">Dashboard /</a></li>
            <li class="font-medium text-primary">Komunitas</li>
        </ol>
    </nav>
</div>

{{-- TABEL KOMUNITAS --}}
<div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
    <div class="py-6 px-4 md:px-6 xl:px-7.5">
        <h4 class="text-xl font-semibold text-black dark:text-white">
            Daftar Komunitas
        </h4>
    </div>

    <div class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
        <div class="col-span-3 flex items-center">
            <p class="font-medium">Nama Komunitas</p>
        </div>
        <div class="col-span-2 hidden items-center sm:flex">
            <p class="font-medium">Kategori</p>
        </div>
        <div class="col-span-2 flex items-center">
            <p class="font-medium">Status</p>
        </div>
        <div class="col-span-1 flex items-center">
            <p class="font-medium">Aksi</p>
        </div>
    </div>

    {{-- LOOPING DATA KOMUNITAS --}}
    @foreach($communities as $comm)
    <div class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5 hover:bg-gray-50 dark:hover:bg-meta-4">
        
        {{-- KOLOM 1: NAMA & ICON --}}
        <div class="col-span-3 flex items-center">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
             
                {{-- Placeholder Icon (Kotak Gambar) --}}
                <div class="h-12.5 w-15 rounded-md bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-sm font-bold text-gray-500">
                    {{ substr($comm->community, 0, 1) }} 
                </div>
                <p class="text-sm text-black dark:text-white font-medium">
             
                    {{ $comm->community }}
                </p>
            </div>
        </div>

        {{-- KOLOM 2: KATEGORI --}}
        <div class="col-span-2 hidden items-center sm:flex">
            <p class="text-sm text-black dark:text-white">
                @if(strtolower($comm->community) == 'game')
                    Entertainment / Hobi
                @else
                    Teknologi / Edukasi
                @endif
            </p>
        </div>

        {{-- KOLOM 3: STATUS (Label Hijau) --}}
        <div class="col-span-2 flex items-center">
            <p class="inline-flex rounded-full bg-success bg-opacity-10 py-1 px-3 text-sm font-medium text-success">
                Active
            </p>
        </div>

        {{-- KOLOM 4: TOMBOL AKSI --}}
        <div class="col-span-1 flex items-center">
            @if(strtolower($comm->community) == 'game')
                
            
            {{-- Tombol Lihat untuk GAME --}}
                <a href="{{ route('member.list', ['name' => $comm->community]) }}" class="hover:text-primary">
                    <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.17812 8.99981 3.17812C14.5686 3.17812 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM8.99981 13.6969C13.4154 13.6969 15.8342 9.87187 16.3123 8.99999C15.8342 8.12812 13.4154 4.30312 8.99981 4.30312C4.58418 4.30312 2.16543 8.12812 1.6873 8.99999C2.16543 9.87187 4.58418 13.6969 8.99981 13.6969Z" fill=""/>
                        <circle cx="9" cy="9" r="2.5" fill=""/>
                    </svg>
                </a>
            @else

                {{-- Tombol Lihat untuk IT --}}
                <a href="{{ route('division.list', ['name' => $comm->community]) }}" class="hover:text-primary">
                    <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.17812 8.99981 3.17812C14.5686 3.17812 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM8.99981 13.6969C13.4154 13.6969 15.8342 9.87187 16.3123 8.99999C15.8342 8.12812 13.4154 4.30312 8.99981 4.30312C4.58418 4.30312 2.16543 8.12812 1.6873 8.99999C2.16543 9.87187 4.58418 13.6969 8.99981 13.6969Z" fill=""/>
                        <circle cx="9" cy="9" r="2.5" fill=""/>
                    </svg>
                </a>
            @endif
        </div>
    </div>
    @endforeach

</div>
@endsection