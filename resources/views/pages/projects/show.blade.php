@extends('layouts.app')

@section('content')
@php
use Carbon\Carbon;

$ROW_HEIGHT = 40;
$DAY_WIDTH  = 80;

/* ========= HELPERS ========= */
function taskDuration($task) {
    return $task->start_date && $task->end_date
        ? $task->start_date->diffInDays($task->end_date) + 1
        : '-';
}

$startDate = Carbon::parse(
    collect($rows)->pluck('data.start_date')->min()
)->startOfDay();
$endDate = Carbon::parse(
    collect($rows)->pluck('data.end_date')->max()
)->endOfDay();

$dates=[];
for($d=$startDate->copy();$d<=$endDate;$d->addDay()) $dates[]=$d->copy();

function taskColor($i){
    return ['bg-blue-500','bg-purple-500','bg-red-500','bg-yellow-500','bg-green-500'][$i%5];
}
@endphp

<style>
:root { --task-width: 360px; }

.task-meta { transition: opacity .15s ease; }
.hide-meta .task-meta { opacity:0; pointer-events:none; }
</style>





    
{{-- ================= PROJECT HEADER ================= --}}
<div class="col-span-12 xl:col-span-4 rounded-xl border border-gray-200 bg-white py-6 px-7.5 shadow-sm dark:border-gray-800 dark:bg-gray-900">

    {{-- LEFT : PROJECT INFO --}}
    <div class="space-y-1">
        <h1 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            {{ $project->name }}
        </h1>

        @if($project->description)
            <p class="text-sm text-gray-600 max-w-2xl">
                {{ $project->description }}
            </p>
        @endif

        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mt-2">
            {{-- OWNER --}}
            <div class="flex items-center gap-2">
                <span>Owner:</span>
                <span class="font-medium text-gray-700">
                    {{ $project->user->name }}
                </span>
            </div>

            {{-- STATUS --}}
            <span class="px-2 py-0.5 rounded text-white text-xs
                @if($project->status=='draft') bg-sky-500 text-white dark:text-white
                @elseif($project->status=='active') bg-green-500 text-white dark:text-white
                @elseif($project->status=='completed') bg-blue-500 text-white dark:text-white
                @else bg-gray-500 @endif">
                {{ strtoupper($project->status) }}
            </span>
        </div>
    </div>

    {{-- RIGHT : ACTION --}}
    <div class="flex gap-2 shrink-0">
        <a href="{{ route('projects.edit', $project->id) }}"
           class="inline-flex items-center gap-2 px-4 py-2 text-sm rounded bg-primary dark:text-gray-400">
            ✏️ Edit Project
        </a>
    </div>

</div>

<!-- tabs -->
 <div class="rounded-xl border border-gray-200 p-6 dark:border-gray-800" x-data="{ activeTab: 'ganchart' }">
<div class="border-b border-gray-200 dark:border-gray-800">
        <nav class="-mb-px flex space-x-2 overflow-x-auto [&amp;::-webkit-scrollbar-thumb]:rounded-full [&amp;::-webkit-scrollbar-thumb]:bg-gray-200 dark:[&amp;::-webkit-scrollbar-thumb]:bg-gray-600 dark:[&amp;::-webkit-scrollbar-track]:bg-transparent [&amp;::-webkit-scrollbar]:h-1.5">
                            <button class="inline-flex items-center gap-2 border-b-2 px-2.5 py-2 text-sm font-medium transition-colors duration-200 ease-in-out whitespace-nowrap text-blue-500 border-blue-500 dark:text-blue-400 dark:border-transparen" x-bind:class="activeTab === 'ganchart' ? 'text-blue-500 border-blue-500 dark:text-blue-400 dark:border-blue-400' : 'bg-transparent text-gray-500 border-transparent hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'" x-on:click="activeTab = 'ganchart'">
                    <svg class="size-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.83203 2.5835C3.58939 2.5835 2.58203 3.59085 2.58203 4.83349V7.25015C2.58203 8.49279 3.58939 9.50015 4.83203 9.50015H7.2487C8.49134 9.50015 9.4987 8.49279 9.4987 7.25015V4.8335C9.4987 3.59086 8.49134 2.5835 7.2487 2.5835H4.83203ZM4.08203 4.83349C4.08203 4.41928 4.41782 4.0835 4.83203 4.0835H7.2487C7.66291 4.0835 7.9987 4.41928 7.9987 4.8335V7.25015C7.9987 7.66436 7.66291 8.00015 7.2487 8.00015H4.83203C4.41782 8.00015 4.08203 7.66436 4.08203 7.25015V4.83349ZM4.83203 10.5002C3.58939 10.5002 2.58203 11.5075 2.58203 12.7502V15.1668C2.58203 16.4095 3.58939 17.4168 4.83203 17.4168H7.2487C8.49134 17.4168 9.4987 16.4095 9.4987 15.1668V12.7502C9.4987 11.5075 8.49134 10.5002 7.2487 10.5002H4.83203ZM4.08203 12.7502C4.08203 12.336 4.41782 12.0002 4.83203 12.0002H7.2487C7.66291 12.0002 7.9987 12.336 7.9987 12.7502V15.1668C7.9987 15.5811 7.66291 15.9168 7.2487 15.9168H4.83203C4.41782 15.9168 4.08203 15.5811 4.08203 15.1668V12.7502ZM10.4987 4.83349C10.4987 3.59085 11.5061 2.5835 12.7487 2.5835H15.1654C16.408 2.5835 17.4154 3.59086 17.4154 4.8335V7.25015C17.4154 8.49279 16.408 9.50015 15.1654 9.50015H12.7487C11.5061 9.50015 10.4987 8.49279 10.4987 7.25015V4.83349ZM12.7487 4.0835C12.3345 4.0835 11.9987 4.41928 11.9987 4.83349V7.25015C11.9987 7.66436 12.3345 8.00015 12.7487 8.00015H15.1654C15.5796 8.00015 15.9154 7.66436 15.9154 7.25015V4.8335C15.9154 4.41928 15.5796 4.0835 15.1654 4.0835H12.7487ZM12.7487 10.5002C11.5061 10.5002 10.4987 11.5075 10.4987 12.7502V15.1668C10.4987 16.4095 11.5061 17.4168 12.7487 17.4168H15.1654C16.408 17.4168 17.4154 16.4095 17.4154 15.1668V12.7502C17.4154 11.5075 16.408 10.5002 15.1654 10.5002H12.7487ZM11.9987 12.7502C11.9987 12.336 12.3345 12.0002 12.7487 12.0002H15.1654C15.5796 12.0002 15.9154 12.336 15.9154 12.7502V15.1668C15.9154 15.5811 15.5796 15.9168 15.1654 15.9168H12.7487C12.3345 15.9168 11.9987 15.5811 11.9987 15.1668V12.7502Z" fill="currentColor"></path>
                    </svg>
                    GantChart
                </button>
                            <button class="inline-flex items-center gap-2 border-b-2 px-2.5 py-2 text-sm font-medium transition-colors duration-200 ease-in-out whitespace-nowrap text-blue-500 border-blue-500 dark:text-blue-400 dark:border-transparen" x-bind:class="activeTab === 'kanban' ? 'text-blue-500 border-blue-500 dark:text-blue-400 dark:border-blue-400' : 'bg-transparent text-gray-500 border-transparent hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'" x-on:click="activeTab = 'kanban'">
                    <svg class="size-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7487 2.29248C10.7487 1.87827 10.4129 1.54248 9.9987 1.54248C9.58448 1.54248 9.2487 1.87827 9.2487 2.29248V2.83613C6.08132 3.20733 3.6237 5.9004 3.6237 9.16748V14.4591H3.33203C2.91782 14.4591 2.58203 14.7949 2.58203 15.2091C2.58203 15.6234 2.91782 15.9591 3.33203 15.9591H4.3737H15.6237H16.6654C17.0796 15.9591 17.4154 15.6234 17.4154 15.2091C17.4154 14.7949 17.0796 14.4591 16.6654 14.4591H16.3737V9.16748C16.3737 5.9004 13.9161 3.20733 10.7487 2.83613V2.29248ZM14.8737 14.4591V9.16748C14.8737 6.47509 12.6911 4.29248 9.9987 4.29248C7.30631 4.29248 5.1237 6.47509 5.1237 9.16748V14.4591H14.8737ZM7.9987 17.7085C7.9987 18.1228 8.33448 18.4585 8.7487 18.4585H11.2487C11.6629 18.4585 11.9987 18.1228 11.9987 17.7085C11.9987 17.2943 11.6629 16.9585 11.2487 16.9585H8.7487C8.33448 16.9585 7.9987 17.2943 7.9987 17.7085Z" fill="currentColor"></path>
                    </svg>
                    Kanban
                </button>
                            <button class="inline-flex items-center gap-2 border-b-2 px-2.5 py-2 text-sm font-medium transition-colors duration-200 ease-in-out whitespace-nowrap text-blue-500 border-blue-500 dark:text-blue-400 dark:border-transparen" x-bind:class="activeTab === 'analytics' ? 'text-blue-500 border-blue-500 dark:text-blue-400 dark:border-blue-400' : 'bg-transparent text-gray-500 border-transparent hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'" x-on:click="activeTab = 'analytics'">
                    <svg class="size-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.85954 4.0835C9.5834 4.0835 9.35954 4.30735 9.35954 4.5835V15.4161C9.35954 15.6922 9.5834 15.9161 9.85954 15.9161H10.1373C10.4135 15.9161 10.6373 15.6922 10.6373 15.4161V4.5835C10.6373 4.30735 10.4135 4.0835 10.1373 4.0835H9.85954ZM7.85954 4.5835C7.85954 3.47893 8.75497 2.5835 9.85954 2.5835H10.1373C11.2419 2.5835 12.1373 3.47893 12.1373 4.5835V15.4161C12.1373 16.5206 11.2419 17.4161 10.1373 17.4161H9.85954C8.75497 17.4161 7.85954 16.5206 7.85954 15.4161V4.5835ZM4.58203 8.9598C4.30589 8.9598 4.08203 9.18366 4.08203 9.4598V15.4168C4.08203 15.693 4.30589 15.9168 4.58203 15.9168H4.85981C5.13595 15.9168 5.35981 15.693 5.35981 15.4168V9.4598C5.35981 9.18366 5.13595 8.9598 4.85981 8.9598H4.58203ZM2.58203 9.4598C2.58203 8.35523 3.47746 7.4598 4.58203 7.4598H4.85981C5.96438 7.4598 6.85981 8.35523 6.85981 9.4598V15.4168C6.85981 16.5214 5.96438 17.4168 4.85981 17.4168H4.58203C3.47746 17.4168 2.58203 16.5214 2.58203 15.4168V9.4598ZM14.637 12.435C14.637 12.1589 14.8609 11.935 15.137 11.935H15.4148C15.691 11.935 15.9148 12.1589 15.9148 12.435V15.4168C15.9148 15.693 15.691 15.9168 15.4148 15.9168H15.137C14.8609 15.9168 14.637 15.693 14.637 15.4168V12.435ZM15.137 10.435C14.0325 10.435 13.137 11.3304 13.137 12.435V15.4168C13.137 16.5214 14.0325 17.4168 15.137 17.4168H15.4148C16.5194 17.4168 17.4148 16.5214 17.4148 15.4168V12.435C17.4148 11.3304 16.5194 10.435 15.4148 10.435H15.137Z" fill="currentColor"></path>
                    </svg>
                    Analytics
                </button>
                            <button class="inline-flex items-center gap-2 border-b-2 px-2.5 py-2 text-sm font-medium transition-colors duration-200 ease-in-out whitespace-nowrap text-blue-500 border-blue-500 dark:text-blue-400 dark:border-transparen" x-bind:class="activeTab === 'customers' ? 'text-blue-500 border-blue-500 dark:text-blue-400 dark:border-blue-400' : 'bg-transparent text-gray-500 border-transparent hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'" x-on:click="activeTab = 'customers'">
                    <svg class="size-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.33633 4.79297C6.39425 4.79297 5.63054 5.55668 5.63054 6.49876C5.63054 7.44084 6.39425 8.20454 7.33633 8.20454C8.27841 8.20454 9.04212 7.44084 9.04212 6.49876C9.04212 5.55668 8.27841 4.79297 7.33633 4.79297ZM4.13054 6.49876C4.13054 4.72825 5.56582 3.29297 7.33633 3.29297C9.10684 3.29297 10.5421 4.72825 10.5421 6.49876C10.5421 8.26926 9.10684 9.70454 7.33633 9.70454C5.56582 9.70454 4.13054 8.26926 4.13054 6.49876ZM4.24036 12.7602C3.61952 13.3265 3.28381 14.0575 3.10504 14.704C3.06902 14.8343 3.09994 14.9356 3.17904 15.0229C3.26864 15.1218 3.4319 15.2073 3.64159 15.2073H10.9411C11.1507 15.2073 11.314 15.1218 11.4036 15.0229C11.4827 14.9356 11.5136 14.8343 11.4776 14.704C11.2988 14.0575 10.9631 13.3265 10.3423 12.7602C9.73639 12.2075 8.7967 11.7541 7.29132 11.7541C5.78595 11.7541 4.84626 12.2075 4.24036 12.7602ZM3.22949 11.652C4.14157 10.82 5.4544 10.2541 7.29132 10.2541C9.12825 10.2541 10.4411 10.82 11.3532 11.652C12.2503 12.4703 12.698 13.4893 12.9234 14.3042C13.1054 14.9627 12.9158 15.5879 12.5152 16.03C12.1251 16.4605 11.5496 16.7073 10.9411 16.7073H3.64159C3.03301 16.7073 2.45751 16.4605 2.06745 16.03C1.66689 15.5879 1.47723 14.9627 1.65929 14.3042C1.88464 13.4893 2.33237 12.4703 3.22949 11.652ZM12.7529 9.70454C12.1654 9.70454 11.6148 9.54648 11.1412 9.27055C11.4358 8.86714 11.6676 8.4151 11.8226 7.92873C12.0902 8.10317 12.4097 8.20454 12.7529 8.20454C13.695 8.20454 14.4587 7.44084 14.4587 6.49876C14.4587 5.55668 13.695 4.79297 12.7529 4.79297C12.4097 4.79297 12.0901 4.89435 11.8226 5.0688C11.6676 4.58243 11.4357 4.13039 11.1412 3.72698C11.6147 3.45104 12.1654 3.29297 12.7529 3.29297C14.5235 3.29297 15.9587 4.72825 15.9587 6.49876C15.9587 8.26926 14.5235 9.70454 12.7529 9.70454ZM16.3577 16.7072H13.8902C14.1962 16.2705 14.4012 15.7579 14.4688 15.2072H16.3577C16.5674 15.2072 16.7307 15.1217 16.8203 15.0228C16.8994 14.9355 16.9303 14.8342 16.8943 14.704C16.7155 14.0574 16.3798 13.3264 15.759 12.7601C15.2556 12.301 14.5219 11.9104 13.425 11.7914C13.1434 11.3621 12.7952 10.9369 12.3641 10.5437C12.2642 10.4526 12.1611 10.3643 12.0548 10.2791C12.2648 10.2626 12.4824 10.2541 12.708 10.2541C14.5449 10.2541 15.8577 10.82 16.7698 11.6519C17.6669 12.4702 18.1147 13.4892 18.34 14.3042C18.5221 14.9626 18.3324 15.5879 17.9319 16.03C17.5418 16.4605 16.9663 16.7072 16.3577 16.7072Z" fill="currentColor"></path>
                    </svg>
                    Customers
                </button>
                    </nav>
    </div>


<div x-show="activeTab === 'ganchart'" style="display: none;">


<div id="gantt-wrapper"
     class="custom-scrollbar grid overflow-hidden  border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
     style="grid-template-columns: var(--task-width) 4px 1fr;">

{{-- ================= TASK PANEL ================= --}}
<div id="task-panel" class="   border border-gray-200 dark:border-gray-800 overflow-hidden">

    {{-- HEADER --}}
    <div class="h-[120px] px-4 flex items-center justify-between font-semibold border-b dark:border-gray-800">
        <span class="text-lg font-semibold text-gray-800 dark:text-white/90">Tasks</span>

        <button onclick="openAddTaskModal()" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
                    Add New Task
                    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.2502 4.99951C9.2502 4.5853 9.58599 4.24951 10.0002 4.24951C10.4144 4.24951 10.7502 4.5853 10.7502 4.99951V9.24971H15.0006C15.4148 9.24971 15.7506 9.5855 15.7506 9.99971C15.7506 10.4139 15.4148 10.7497 15.0006 10.7497H10.7502V15.0001C10.7502 15.4143 10.4144 15.7501 10.0002 15.7501C9.58599 15.7501 9.2502 15.4143 9.2502 15.0001V10.7497H5C4.58579 10.7497 4.25 10.4139 4.25 9.99971C4.25 9.5855 4.58579 9.24971 5 9.24971H9.2502V4.99951Z" fill=""></path>
                    </svg>
                </button>
    </div>


    {{-- ROWS --}}
    @foreach($rows as $row)
        @php $task = $row['data']; @endphp

        <div class="flex items-center gap-2 px-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-900"
            style="
            height: {{ $ROW_HEIGHT }}px;
            padding-left: {{ $row['level'] * 24 }}px;
         "
            onclick="openEditTaskModal(this)"
            data-id="{{ $task->id }}"
            data-parent-id="{{ $task->parent_id }}"
            data-title="{{ $task->title }}"
            data-description="{{ $task->description }}"
            data-start="{{ $task->start_date->format('Y-m-d') }}"
            data-end="{{ $task->end_date->format('Y-m-d') }}"
            data-progress="{{ $task->progress }}"
            data-status="{{ $task->status }}"
            data-users="{{ $task->users->pluck('id')->implode(',') }}">

            @if($row['level'] > 0)
                <span class="mr-1 text-gray-400">↳</span>
            @endif
            {{-- TITLE (PRIORITY) --}}
            <div class="flex-1 min-w-[120px] truncate text-sm dark:text-gray-100
                        {{ $row['level'] === 0 ? 'font-semibold' : '' }} "
                style="padding-left: {{ $row['level'] * 24 }}px">
                {{ $task->title }}
            </div>




            {{-- META (BOLEH HILANG) --}}
            <div class="flex items-center gap-2 shrink-0 task-meta">

                {{-- USERS --}}
                <div class="flex -space-x-2">
                    @foreach($task->users as $u)
                        <div class="w-5 h-5 rounded-full border-2 border-white overflow-hidden"
                             title="{{ $u->name }}">
                            <img src="{{ asset('storage/'.$u->foto_profil) }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>

                {{-- DURATION --}}
                <span class="text-xs text-gray-500">
                    {{ taskDuration($task) }} hari
                </span>

                {{-- STATUS --}}
                <span class="text-xs px-2 py-0.5 inline-flex items-center px-2.5 py-0.5 justify-center gap-1 rounded-full font-medium capitalize
                    @if($task->status=='todo') bg-blue-50 text-blue-500 dark:bg-blue-500/15 dark:text-blue-400
                    @elseif($task->status=='in_progress') bg-yellow-50 text-yellow-600 dark:bg-yellow-500/15 dark:text-orange-400
                    @else bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500 @endif">
                    {{ strtoupper($task->status) }}
                </span>

            </div>
        </div>
    @endforeach
</div>

{{-- RESIZER --}}
<div id="task-resizer"
     class="cursor-col-resize bg-gray-100 dark:bg-gray-900 hover:bg-primary"></div>

{{-- ================= GANTT ================= --}}
<div class="custom-scrollbar overflow-auto dark:text-gray-400">

<div style="min-width: {{ count($dates)*$DAY_WIDTH }}px">

    {{-- YEAR --}}
    <div class="grid h-[40px]"
         style="grid-template-columns: repeat({{ count($dates) }},{{ $DAY_WIDTH }}px)">
        @foreach(collect($dates)->groupBy(fn($d)=>$d->format('Y')) as $y=>$items)
            <div class="text-center font-semibold"
                 style="grid-column: span {{ count($items) }}">{{ $y }}</div>
        @endforeach
    </div>

    {{-- MONTH --}}
    <div class="grid h-[40px]"
         style="grid-template-columns: repeat({{ count($dates) }},{{ $DAY_WIDTH }}px)">
        @foreach(collect($dates)->groupBy(fn($d)=>$d->format('Y-m')) as $m=>$items)
            <div class="text-center text-sm"
                 style="grid-column: span {{ count($items) }}">
                {{ Carbon::parse($m)->translatedFormat('F') }}
            </div>
        @endforeach
    </div>

    {{-- DATE --}}
    <div class="grid h-[40px] text-xs"
         style="grid-template-columns: repeat({{ count($dates) }},{{ $DAY_WIDTH }}px)">
        @foreach($dates as $d)
            <div class="text-center">{{ $d->format('d') }}</div>
        @endforeach
    </div>

    {{-- BARS --}}
    @foreach($rows as $i=>$row)
        @php
            $t=$row['data'];
            $left=$startDate->diffInDays($t->start_date)*$DAY_WIDTH;
            $width=taskDuration($t)*$DAY_WIDTH;
        @endphp

        <div class="relative border dark:border-gray-800" style="height: {{ $ROW_HEIGHT }}px">
            <div class="absolute top-1/2 -translate-y-1/2 rounded cursor-pointer
            {{ taskColor($i) }} {{ $row['level']=='sub'?'opacity-50':'' }}"
                    onclick="openEditTaskModal(this)"
                    data-id="{{ $t->id }}"
                    data-title="{{ $t->title }}"
                    data-description="{{ $t->description }}"
                    data-start="{{ $t->start_date }}"
                    data-end="{{ $t->end_date }}"
                    data-status="{{ $t->status }}"
                    data-progress="{{ $t->progress }}"
                    data-parent="{{ $t->parent_id }}"
                    style="left:{{ $left }}px;width:{{ $width }}px;height:18px"
                    data-users="{{ $task->users->pluck('id')->implode(',') }}">
            </div>
        </div>
    @endforeach

</div>
</div>
</div>

</div>



<!-- kanban  -->

<script>
function formatTaskDate(dateString) {
    if (!dateString) return null;

    const date = new Date(dateString);
    const today = new Date();

    // reset jam
    today.setHours(0,0,0,0);
    date.setHours(0,0,0,0);

    const diffDays = Math.round((date - today) / (1000 * 60 * 60 * 24));

    if (diffDays === 0) return 'Today';
    if (diffDays === 1) return 'Tomorrow';
    if (diffDays === -1) return 'Yesterday';

    return date.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });
}
</script>



<div x-show="activeTab === 'kanban'" style="">
<div x-data="kanbanBoard()" @dragover.prevent="" class=" border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    
    
    
    <!-- Task header Start -->
    <div >
    <div class="flex flex-col items-center px-4 py-5 xl:px-6 xl:py-6" >
        <div class="flex flex-col w-full gap-5 sm:justify-between xl:flex-row xl:items-center">
            <!-- Task Group Buttons -->
            <div class="flex flex-wrap items-center gap-x-1 gap-y-2 rounded-lg bg-gray-100 p-0.5 dark:bg-gray-900">
                                    <button class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-md h group hover:text-gray-900 dark:hover:text-white text-gray-900 dark:text-gray-400" :class="selectedTaskGroup === 'All' ?
                            'text-gray-900 dark:text-white bg-white dark:bg-gray-800' :
                            'text-gray-500 dark:text-gray-400'" @click="selectedTaskGroup = 'All'">
                        All Tasks
                        <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium leading-normal group-hover:bg-brand-50 group-hover:text-brand-500 dark:group-hover:bg-brand-500/15 dark:group-hover:text-brand-400 bg-white dark:bg-white/[0.03]" :class="selectedTaskGroup === 'All' ?
                                'text-brand-500 dark:text-brand-400 bg-brand-50 dark:bg-brand-500/15' :
                                'bg-white dark:bg-white/[0.03]'" x-text="taskCount('All')">
                            
                        </span>
                    </button>
                                    <button class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-md h group hover:text-gray-900 dark:hover:text-white text-gray-500 dark:text-gray-400" :class="selectedTaskGroup === 'Todo' ?
                            'text-gray-900 dark:text-white bg-white dark:bg-gray-800' :
                            'text-gray-500 dark:text-gray-400'" @click="selectedTaskGroup = 'Todo'">
                        To do
                        <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium leading-normal group-hover:bg-brand-50 group-hover:text-brand-500 dark:group-hover:bg-brand-500/15 dark:group-hover:text-brand-400 bg-white dark:bg-white/[0.03]" :class="selectedTaskGroup === 'Todo' ?
                                'text-brand-500 dark:text-brand-400 bg-brand-50 dark:bg-brand-500/15' :
                                'bg-white dark:bg-white/[0.03]'" x-text="taskCount('Todo')">
                            
                        </span>
                    </button>
                                    <button class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-md h group hover:text-gray-900 dark:hover:text-white text-gray-500 dark:text-gray-400" :class="selectedTaskGroup === 'InProgress' ?
                            'text-gray-900 dark:text-white bg-white dark:bg-gray-800' :
                            'text-gray-500 dark:text-gray-400'" @click="selectedTaskGroup = 'InProgress'">
                        In Progress
                        <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium leading-normal group-hover:bg-brand-50 group-hover:text-brand-500 dark:group-hover:bg-brand-500/15 dark:group-hover:text-brand-400 bg-white dark:bg-white/[0.03]" :class="selectedTaskGroup === 'InProgress' ?
                                'text-brand-500 dark:text-brand-400 bg-brand-50 dark:bg-brand-500/15' :
                                'bg-white dark:bg-white/[0.03]'" x-text="taskCount('InProgress')">
                            
                        </span>
                    </button>
                                    <button class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-md h group hover:text-gray-900 dark:hover:text-white text-gray-500 dark:text-gray-400" :class="selectedTaskGroup === 'Done' ?
                            'text-gray-900 dark:text-white bg-white dark:bg-gray-800' :
                            'text-gray-500 dark:text-gray-400'" @click="selectedTaskGroup = 'Done'">
                        Done
                        <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium leading-normal group-hover:bg-brand-50 group-hover:text-brand-500 dark:group-hover:bg-brand-500/15 dark:group-hover:text-brand-400 bg-white dark:bg-white/[0.03]" :class="selectedTaskGroup === 'Done' ?
                                'text-brand-500 dark:text-brand-400 bg-brand-50 dark:bg-brand-500/15' :
                                'bg-white dark:bg-white/[0.03]'" x-text="taskCount('Done')">
                            
                        </span>
                    </button>
                            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-3 xl:justify-end">
                <!-- Filter & Sort Button -->
                <button class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-white/[0.03]">
                    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0826 4.0835C11.0769 4.0835 10.2617 4.89871 10.2617 5.90433C10.2617 6.90995 11.0769 7.72516 12.0826 7.72516C13.0882 7.72516 13.9034 6.90995 13.9034 5.90433C13.9034 4.89871 13.0882 4.0835 12.0826 4.0835ZM2.29004 6.65409H8.84671C9.18662 8.12703 10.5063 9.22516 12.0826 9.22516C13.6588 9.22516 14.9785 8.12703 15.3184 6.65409H17.7067C18.1209 6.65409 18.4567 6.31831 18.4567 5.90409C18.4567 5.48988 18.1209 5.15409 17.7067 5.15409H15.3183C14.9782 3.68139 13.6586 2.5835 12.0826 2.5835C10.5065 2.5835 9.18691 3.68139 8.84682 5.15409H2.29004C1.87583 5.15409 1.54004 5.48988 1.54004 5.90409C1.54004 6.31831 1.87583 6.65409 2.29004 6.65409ZM4.6816 13.3462H2.29085C1.87664 13.3462 1.54085 13.682 1.54085 14.0962C1.54085 14.5104 1.87664 14.8462 2.29085 14.8462H4.68172C5.02181 16.3189 6.34142 17.4168 7.91745 17.4168C9.49348 17.4168 10.8131 16.3189 11.1532 14.8462H17.7075C18.1217 14.8462 18.4575 14.5104 18.4575 14.0962C18.4575 13.682 18.1217 13.3462 17.7075 13.3462H11.1533C10.8134 11.8733 9.49366 10.7752 7.91745 10.7752C6.34124 10.7752 5.02151 11.8733 4.6816 13.3462ZM9.73828 14.096C9.73828 13.0904 8.92307 12.2752 7.91745 12.2752C6.91183 12.2752 6.09662 13.0904 6.09662 14.096C6.09662 15.1016 6.91183 15.9168 7.91745 15.9168C8.92307 15.9168 9.73828 15.1016 9.73828 14.096Z" fill=""></path>
                    </svg>
                    Filter &amp; Sort
                </button>

                <!-- Add New Task Button -->
                <button onclick="openAddTaskModal()" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
                    Add New Task
                    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.2502 4.99951C9.2502 4.5853 9.58599 4.24951 10.0002 4.24951C10.4144 4.24951 10.7502 4.5853 10.7502 4.99951V9.24971H15.0006C15.4148 9.24971 15.7506 9.5855 15.7506 9.99971C15.7506 10.4139 15.4148 10.7497 15.0006 10.7497H10.7502V15.0001C10.7502 15.4143 10.4144 15.7501 10.0002 15.7501C9.58599 15.7501 9.2502 15.4143 9.2502 15.0001V10.7497H5C4.58579 10.7497 4.25 10.4139 4.25 9.99971C4.25 9.5855 4.58579 9.24971 5 9.24971H9.2502V4.99951Z" fill=""></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>


    <div class="mt-7 grid grid-cols-1 border-t border-gray-200 sm:mt-0 sm:grid-cols-2 xl:grid-cols-3 dark:border-gray-800">

        <!-- Loop through swim lanes -->
        <template x-for="lane in lanes" :key="lane.id">
            <div x-show="isLaneVisible(lane.id)">
            <div :class="{ 'border-x border-gray-200 dark:border-gray-800': index === 1 }" class="swim-lane flex flex-col gap-5 p-4 xl:p-6" @dragover="handleDragOver($event, lane.id)" @drop="handleDrop($event, lane.id)">
                <div class="mb-1 flex items-center justify-between">
                    <h3 class="flex items-center gap-3 text-base font-medium text-gray-800 dark:text-white/90">
                        <span x-text="lane.name"></span>
                        <span :class="lane.badgeClass" class="text-theme-xs inline-flex rounded-full px-2 py-0.5 font-medium" x-text="lane.tasks.length">
                        </span>
                    </h3>

                    <div x-data="{ openDropDown: false }" class="relative">
                        <button @click="openDropDown = !openDropDown" class="text-gray-700 dark:text-gray-400">
                            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99902 10.2451C6.96552 10.2451 7.74902 11.0286 7.74902 11.9951V12.0051C7.74902 12.9716 6.96552 13.7551 5.99902 13.7551C5.03253 13.7551 4.24902 12.9716 4.24902 12.0051V11.9951C4.24902 11.0286 5.03253 10.2451 5.99902 10.2451ZM17.999 10.2451C18.9655 10.2451 19.749 11.0286 19.749 11.9951V12.0051C19.749 12.9716 18.9655 13.7551 17.999 13.7551C17.0325 13.7551 16.249 12.9716 16.249 12.0051V11.9951C16.249 11.0286 17.0325 10.2451 17.999 10.2451ZM13.749 11.9951C13.749 11.0286 12.9655 10.2451 11.999 10.2451C11.0325 10.2451 10.249 11.0286 10.249 11.9951V12.0051C10.249 12.9716 11.0325 13.7551 11.999 13.7551C12.9655 13.7551 13.749 12.9716 13.749 12.0051V11.9951Z" fill=""></path>
                            </svg>
                        </button>
                        <div x-show="openDropDown" @click.outside="openDropDown = false" x-transition="" class="shadow-theme-md dark:bg-gray-dark absolute top-full right-0 z-40 w-[140px] space-y-1 rounded-2xl border border-gray-200 bg-white p-2 dark:border-gray-800">
                            <button class="text-theme-xs flex w-full rounded-lg px-3 py-2 text-left font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                Edit
                            </button>
                            <button class="text-theme-xs flex w-full rounded-lg px-3 py-2 text-left font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                Delete
                            </button>
                            <button @click="clearLane(lane.id)" class="text-theme-xs flex w-full rounded-lg px-3 py-2 text-left font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                Clear All
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Task items loop -->
                <template x-for="task in lane.tasks" :key="task.id">
                    <div :class="task.isSubtask ? 'ml-4 border-l-2 pl-3 border-gray-300' : ''">
                    <div draggable="true" @dragstart="handleDragStart($event, task.id, lane.id)" @dragend="handleDragEnd($event)" class="task shadow-theme-sm rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/5 cursor-move transition-opacity" :class="{ 'opacity-100': draggingTaskId === task.id }">

                        <div class="flex items-start justify-between gap-6">
                            <div class="flex-1">
                                <h4 class="mb-5 text-base text-gray-800 dark:text-white/90" x-text="task.title">
                                </h4>

                                <!-- Description if exists -->
                                <template x-if="task.description">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4" x-text="task.description">
                                    </p>
                                </template>

                                <!-- Image if exists -->
                                <template x-if="task.image">
                                    <div class="my-4">
                                        <img :src="task.image" :alt="task.title" class="overflow-hidden rounded-xl border-[0.5px] border-gray-200 dark:border-gray-800">
                                    </div>
                                </template>

                                <div class="flex items-center gap-3">
                                    <!-- Date -->
                                    <template x-if="task.date">
                                        <span class="flex cursor-pointer items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                                            <svg class="fill-current" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.33329 1.0835C5.74751 1.0835 6.08329 1.41928 6.08329 1.8335V2.25016L9.91663 2.25016V1.8335C9.91663 1.41928 10.2524 1.0835 10.6666 1.0835C11.0808 1.0835 11.4166 1.41928 11.4166 1.8335V2.25016L12.3333 2.25016C13.2998 2.25016 14.0833 3.03366 14.0833 4.00016V6.00016L14.0833 12.6668C14.0833 13.6333 13.2998 14.4168 12.3333 14.4168L3.66663 14.4168C2.70013 14.4168 1.91663 13.6333 1.91663 12.6668L1.91663 6.00016L1.91663 4.00016C1.91663 3.03366 2.70013 2.25016 3.66663 2.25016L4.58329 2.25016V1.8335C4.58329 1.41928 4.91908 1.0835 5.33329 1.0835ZM5.33329 3.75016L3.66663 3.75016C3.52855 3.75016 3.41663 3.86209 3.41663 4.00016V5.25016L12.5833 5.25016V4.00016C12.5833 3.86209 12.4714 3.75016 12.3333 3.75016L10.6666 3.75016L5.33329 3.75016ZM12.5833 6.75016L3.41663 6.75016L3.41663 12.6668C3.41663 12.8049 3.52855 12.9168 3.66663 12.9168L12.3333 12.9168C12.4714 12.9168 12.5833 12.8049 12.5833 12.6668L12.5833 6.75016Z" fill=""></path>
                                            </svg>
                                            <span x-text="task.date"></span>
                                        </span>
                                    </template>

                                    <!-- Comments -->
                                    <template x-if="task.comments">
                                        <span class="flex cursor-pointer items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                                            <svg class="stroke-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9 15.6343C12.6244 15.6343 15.5625 12.6961 15.5625 9.07178C15.5625 5.44741 12.6244 2.50928 9 2.50928C5.37563 2.50928 2.4375 5.44741 2.4375 9.07178C2.4375 10.884 3.17203 12.5246 4.35961 13.7122L2.4375 15.6343H9Z" stroke="" stroke-width="1.5" stroke-linejoin="round"></path>
                                            </svg>
                                            <span x-text="task.comments"></span>
                                        </span>
                                    </template>

                                    <!-- Links -->
                                    <template x-if="task.links">
                                        <span class="flex cursor-pointer items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                                            <svg class="fill-current" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.88066 3.10905C8.54039 1.44932 11.2313 1.44933 12.8911 3.10906C14.5508 4.76878 14.5508 7.45973 12.8911 9.11946L12.0657 9.94479L11.0051 8.88413L11.8304 8.0588C12.9043 6.98486 12.9043 5.24366 11.8304 4.16972C10.7565 3.09577 9.01526 3.09577 7.94132 4.16971L7.11599 4.99504L6.05533 3.93438L6.88066 3.10905ZM8.88376 11.0055L9.94442 12.0661L9.11983 12.8907C7.4601 14.5504 4.76915 14.5504 3.10942 12.8907C1.44969 11.231 1.44969 8.54002 3.10942 6.88029L3.93401 6.0557L4.99467 7.11636L4.17008 7.94095C3.09614 9.01489 3.09614 10.7561 4.17008 11.83C5.24402 12.904 6.98522 12.904 8.05917 11.83L8.88376 11.0055ZM9.94458 7.11599C10.2375 6.8231 10.2375 6.34823 9.94458 6.05533C9.65169 5.76244 9.17682 5.76244 8.88392 6.05533L6.0555 8.88376C5.7626 9.17665 5.7626 9.65153 6.0555 9.94442C6.34839 10.2373 6.82326 10.2373 7.11616 9.94442L9.94458 7.11599Z" fill=""></path>
                                            </svg>
                                            <span x-text="task.links"></span>
                                        </span>
                                    </template>
                                </div>

                                <!-- Category Badge -->
                                <template x-if="task.category">
                                    <span :class="task.categoryClass" class="text-theme-xs mt-3 inline-flex rounded-full px-2 py-0.5 font-medium" x-text="task.category"></span>
                                </template>
                            </div>

                            <!-- User Avatar -->
                            <div class="flex -space-x-2" x-show="task.users.length">
                                <template x-for="(user, idx) in task.users" :key="user.avatar + idx">
                                    <div class="w-5 h-5 rounded-full border-2 border-white overflow-hidden"
                                        :title="user.name">
                                        <img :src="user.avatar"
                                            class="w-full h-full object-cover">
                                    </div>
                                </template>
                            </div>


                        </div>
                    </div>
                </template>
            </div>
            </div>
        </template>
    </div>
    </div>
    </div>

<script>
    window.KANBAN_DATA = {
        todo: @json($kanbanTasks['todo'] ?? []),
        in_progress: @json($kanbanTasks['in_progress'] ?? []),
        done: @json($kanbanTasks['done'] ?? []),
    };
</script>
<script>
function kanbanBoard() {
    return {
        /* =========================
         * FILTER STATE
         * ========================= */
        selectedTaskGroup: 'All',

        /* =========================
         * DATA
         * ========================= */
        draggingTaskId: null,
        draggedFromLaneId: null,

        lanes: [
            {
                id: 'todo',
                name: 'To Do',
                badgeClass: 'bg-gray-100 text-gray-700 dark:bg-white/[0.03] dark:text-white/80',
                tasks: (window.KANBAN_DATA.todo || []).map(t => ({
                    id: t.id,
                    isSubtask: t.parent_id !== null,
                    title: t.title,
                    description: t.description,
                    date: formatTaskDate(t.end_date),
                    users: (t.users || []).map(u => ({
                        name: u.name,
                        avatar: u.foto_profil
                            ? `/storage/${u.foto_profil}`
                            : '/images/default-avatar.png'
                    }))
                }))
            },
            {
                id: 'in_progress',
                name: 'In Progress',
                badgeClass: 'bg-warning-50 text-warning-700 dark:bg-warning-500/15',
                tasks: (window.KANBAN_DATA.in_progress || []).map(t => ({
                    id: t.id,
                    isSubtask: t.parent_id !== null,
                    title: t.title,
                    description: t.description,
                    date: formatTaskDate(t.end_date),
                    users: (t.users || []).map(u => ({
                        name: u.name,
                        avatar: u.foto_profil
                            ? `/storage/${u.foto_profil}`
                            : '/images/default-avatar.png'
                    }))
                }))
            },
            {
                id: 'done',
                name: 'Done',
                badgeClass: 'bg-success-50 text-success-700 dark:bg-success-500/15',
                tasks: (window.KANBAN_DATA.done || []).map(t => ({
                    id: t.id,
                    isSubtask: t.parent_id !== null,
                    title: t.title,
                    description: t.description,
                    date: formatTaskDate(t.end_date),
                    users: (t.users || []).map(u => ({
                        name: u.name,
                        avatar: u.foto_profil
                            ? `/storage/${u.foto_profil}`
                            : '/images/default-avatar.png'
                    }))
                }))
            }
        ],

        /* =========================
         * FILTER HELPERS
         * ========================= */
        taskCount(type) {
            if (type === 'All') {
                return this.lanes.reduce((sum, lane) => sum + lane.tasks.length, 0);
            }

            const map = {
                Todo: 'todo',
                InProgress: 'in_progress',
                Done: 'done'
            };

            const lane = this.lanes.find(l => l.id === map[type]);
            return lane ? lane.tasks.length : 0;
        },

        isLaneVisible(laneId) {
            if (this.selectedTaskGroup === 'All') return true;

            const map = {
                Todo: 'todo',
                InProgress: 'in_progress',
                Done: 'done'
            };

            return laneId === map[this.selectedTaskGroup];
        },

        /* =========================
         * DRAG & DROP
         * ========================= */
        handleDragStart(event, taskId, laneId) {
            this.draggingTaskId = taskId;
            this.draggedFromLaneId = laneId;
            event.target.classList.add('is-dragging');
        },

        handleDragEnd(event) {
            event.target.classList.remove('is-dragging');
            this.draggingTaskId = null;
            this.draggedFromLaneId = null;
        },

        handleDragOver(event, laneId) {
            event.preventDefault();
            if (!this.draggingTaskId) return;

            const fromLane = this.lanes.find(l => l.id === this.draggedFromLaneId);
            const toLane   = this.lanes.find(l => l.id === laneId);

            if (!fromLane || !toLane || fromLane === toLane) return;

            const index = fromLane.tasks.findIndex(t => t.id === this.draggingTaskId);
            if (index === -1) return;

            const task = fromLane.tasks.splice(index, 1)[0];
            toLane.tasks.push(task);
            this.draggedFromLaneId = laneId;
        },

        async handleDrop(event, laneId) {
            event.preventDefault();
            if (!this.draggingTaskId) return;

            try {
                await fetch(`/tasks/${this.draggingTaskId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ status: laneId })
                });
            } catch (e) {
                alert('Gagal menyimpan status task');
            }
        }
    }
}
</script>


</div>



        <div x-show="activeTab === 'analytics'" style="">
    <h3 class="mb-1 text-xl font-medium text-gray-800 dark:text-white/90">
        Analytics
    </h3>
    <p class="text-sm text-gray-500 dark:text-gray-400">
        Analytics ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
    </p>
</div>
        <div x-show="activeTab === 'customers'" style="">
    <h3 class="mb-1 text-xl font-medium text-gray-800 dark:text-white/90">
        Customers
    </h3>
    <p class="text-sm text-gray-500 dark:text-gray-400">
        Customers ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
    </p>
</div>


<!-- modal  -->
<x-ui.modal name="task-modal"
    class="w-full max-w-2xl p-0"
    :showCloseButton="false"
    x-on:open-modal.window="if ($event.detail === 'task-modal') open = true">

    <div class="relative rounded-2xl bg-white dark:bg-gray-900">

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-6 py-4 border-b dark:border-transparent">
            <h3 id="taskModalTitle"
                class="text-lg font-semibold text-gray-800 dark:text-white">
                Task
            </h3>

            <button @click="open = false"
                class="text-gray-400 hover:text-gray-600">
                ✕
            </button>
        </div>

        <form id="taskForm" method="POST">
            @csrf
            <input type="hidden" id="_method" name="_method" value="POST">
            <input type="hidden" id="parent_id" name="parent_id">
            <input type="hidden" id="task_id">

            {{-- SCROLLABLE BODY --}}
            <div class="custom-scrollbar max-h-[65vh] overflow-y-auto px-6 py-5 space-y-5">

                {{-- TITLE --}}
                <div>
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-400">Judul</label>
                    <input
                        id="title"
                        name="title"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm
                            text-gray-800 placeholder:text-gray-400
                            focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10
                            dark:border-gray-700 dark:bg-gray-900
                            dark:text-white/90 dark:placeholder:text-white/30
                            dark:focus:border-brand-800"
                    />
                </div>

                {{-- DATE --}}
                <div class="grid grid-cols-2 gap-4">
                    <x-ui.datepicker
                        id="start_date"
                        name="start_date"
                        label="Mulai"
                        placeholder="Pilih tanggal" />

                    <x-ui.datepicker
                        id="end_date"
                        name="end_date"
                        label="Selesai"
                        placeholder="Pilih tanggal" />
                </div>

                {{-- ASSIGN USER (PUNYA KAMU, TIDAK DIUBAH) --}}
                <div>
    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Assign User
    </label>

    <div
        x-data="{
            open: false,
            selected: [],
            options: @js($users->map(fn($u) => ['id' => $u->id, 'name' => $u->name])),
            setSelected(ids) {
            this.selected = ids;
        }
    }"
        @set-users.window="setSelected($event.detail)"
        class="relative"
        @click.away="open = false"
    >

        {{-- Hidden inputs untuk Laravel --}}
        <template x-for="id in selected" :key="id">
            <input type="hidden" name="users[]" :value="id">
        </template>

        {{-- Trigger --}}
        <div @click="open = !open"
            class="shadow-theme-xs flex min-h-11 cursor-pointer gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 dark:border-gray-700 dark:bg-gray-900">

            <div class="flex flex-1 flex-wrap items-center gap-2">
                <template x-for="id in selected" :key="id">
                    <span
                        class="flex items-center rounded-full bg-gray-100 px-2 py-1 text-sm dark:bg-gray-800 dark:text-white/90">
                        <span x-text="options.find(o => o.id === id)?.name"></span>
                        <button type="button" class="ml-1"
                            @click.stop="selected = selected.filter(i => i !== id)">
                            ✕
                        </button>
                    </span>
                </template>

                <span x-show="selected.length === 0"
                    class="text-sm text-gray-500 dark:text-gray-400">
                    Pilih user...
                </span>
            </div>

            <svg class="h-5 w-5 text-gray-500" :class="open && 'rotate-180'"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
        </div>

        {{-- Dropdown --}}
        <div x-show="open"
            class="absolute z-50 mt-1 w-full rounded-lg border bg-white dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
            <template x-for="option in options" :key="option.id">
                <div
                    @click="
                        selected.includes(option.id)
                            ? selected = selected.filter(i => i !== option.id)
                            : selected.push(option.id)
                    "
                    class="cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800"
                >
                    <span x-text="option.name"></span>
                </div>
            </template>
        </div>
    </div>
</div>


                {{-- PROGRESS & STATUS --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-400">Progress (%)</label>
                        <input
                            type="number"
                            id="progress"
                            name="progress"
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm
                                text-gray-800
                                focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10
                                dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        />

                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-400">Status</label>
                        <select
                            id="status"
                            name="status"
                            class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-3 text-sm
                                text-gray-800
                                focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10
                                dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            <option value="todo">Todo</option>
                            <option value="in_progress">In Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                </div>

                {{-- DESCRIPTION (PALING BAWAH) --}}
                <div>
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-400">Deskripsi</label>
                    <textarea
                        id="description"
                        rows="5"
                        class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm
                            text-gray-800 placeholder:text-gray-400 
                            focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10
                            dark:border-gray-700 dark:bg-gray-900
                            dark:text-white/90 dark:placeholder:text-white/30"></textarea>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="flex items-center justify-between px-6 py-4 border-t rounded-2xl dark:border-transparent bg-gray-50 dark:bg-gray-900">

                <button type="button"
                    id="btnDelete"
                    onclick="deleteTask()"
                    class="text-sm text-red-500 hidden hover:underline">
                    Hapus
                </button>

                <div class="flex gap-2">
                    <button type="button"
                        id="btnAddSubtask"
                        onclick="addSubtask()"
                        class="hidden px-4 py-2 text-sm rounded bg-gray-200">
                        + Subtask
                    </button>

                    <button type="submit"
                        class="px-5 py-2 text-sm rounded bg-brand-500 text-white">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-ui.modal>


<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>



{{-- ================= RESIZE SCRIPT ================= --}}
<script>
const wrapper = document.getElementById('gantt-wrapper');
const panel   = document.getElementById('task-panel');
const resizer = document.getElementById('task-resizer');

let startX = 0;
let startWidth = 0;

resizer.addEventListener('mousedown', e => {
    startX = e.clientX;
    startWidth = parseInt(
        getComputedStyle(wrapper).getPropertyValue('--task-width')
    );
    document.addEventListener('mousemove', resize);
    document.addEventListener('mouseup', stopResize);
});

function resize(e) {
    const dx = e.clientX - startX;
    const newWidth = Math.max(160, Math.min(startWidth + dx, 600));
    wrapper.style.setProperty('--task-width', newWidth + 'px');

    // hide meta if too small
    panel.classList.toggle('hide-meta', newWidth < 260);
}

function stopResize() {
    document.removeEventListener('mousemove', resize);
    document.removeEventListener('mouseup', stopResize);
}
</script>
<script>
const storeTaskUrl = "{{ route('tasks.store', $project) }}";

function openAddTaskModal() {
    const form = document.getElementById('taskForm');

    form.action = storeTaskUrl;
    document.getElementById('_method').value = 'POST';

    // 1. Reset users (Alpine)
    window.dispatchEvent(
        new CustomEvent('set-users', { detail: [] })
    );

    // 2. Open modal
    window.dispatchEvent(
        new CustomEvent('open-modal', { detail: 'task-modal' })
    );

    form.reset();

    document.getElementById('taskModalTitle').innerText = 'Tambah Task';

    document.getElementById('btnDelete').classList.add('hidden');
    document.getElementById('btnAddSubtask').classList.add('hidden');
}

function openEditTaskModal(el) {
    const form = document.getElementById('taskForm');

    window.dispatchEvent(new CustomEvent('open-modal', {
        detail: 'task-modal'
    }));

    form.action = `/tasks/${el.dataset.id}`;
    document.getElementById('_method').value = 'PUT';
    document.getElementById('task_id').value = el.dataset.id;
    document.getElementById('parent_id').value =el.dataset.parentId ?? '';

    document.getElementById('title').value = el.dataset.title ?? '';
    document.getElementById('description').value = el.dataset.description ?? '';
    document.getElementById('start_date').value = el.dataset.start;
    document.getElementById('end_date').value = el.dataset.end;
    document.getElementById('progress').value = el.dataset.progress ?? 0;
    document.getElementById('status').value = el.dataset.status;

    // === USERS (FINAL FIX) ===
    const users = el.dataset.users
        ? el.dataset.users.split(',').map(Number)
        : [];

    // kirim ke Alpine SETELAH modal dibuka
    setTimeout(() => {
        window.dispatchEvent(
            new CustomEvent('set-users', { detail: users })
        );
    }, 0);

    document.getElementById('taskModalTitle').innerText = 'Edit Task';
    document.getElementById('btnDelete').classList.remove('hidden');
    document.getElementById('btnAddSubtask').classList.remove('hidden');
}

function addSubtask() {
    const parentId = document.getElementById('task_id').value;
    const form = document.getElementById('taskForm');

    // reset form
    form.reset();

    // set method POST
    form.action = storeTaskUrl;
    document.getElementById('_method').value = 'POST';

    // set parent
    document.getElementById('parent_id').value = parentId;

    // reset users
    window.dispatchEvent(
        new CustomEvent('set-users', { detail: [] })
    );

    document.getElementById('taskModalTitle').innerText = 'Tambah Subtask';

    // sembunyikan tombol
    document.getElementById('btnDelete').classList.add('hidden');
    document.getElementById('btnAddSubtask').classList.add('hidden');
}

function deleteTask() {
    if (!confirm('Yakin ingin menghapus item ini?')) return;

    const taskId = document.getElementById('task_id').value;
    const form = document.getElementById('deleteForm');

    form.action = `/tasks/${taskId}`;
    form.submit();
}

</script>


@endsection
