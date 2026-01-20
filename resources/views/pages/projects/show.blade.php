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

<div id="gantt-wrapper"
     class="grid overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
     style="grid-template-columns: var(--task-width) 4px 1fr;">

{{-- ================= TASK PANEL ================= --}}
<div id="task-panel" class="rounded-lg   border border-gray-200 dark:border-gray-800 overflow-hidden">

    {{-- HEADER --}}
    <div class="h-[120px] px-4 flex items-center justify-between font-semibold border-b">
        <span class="text-lg font-semibold text-gray-800 dark:text-white/90">Tasks</span>

        <button
                onclick="openAddTaskModal()"
            class="px-3 py-1.5 text-sm rounded bg-brand-500 text-white hover:bg-brand-600">
            + Add Task
        </button>
    </div>


    {{-- ROWS --}}
    @foreach($rows as $row)
        @php $task = $row['data']; @endphp

        <div class="flex items-center gap-2 px-2 cursor-pointer hover:bg-gray-50"
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
     class="cursor-col-resize bg-gray-200 hover:bg-primary"></div>

{{-- ================= GANTT ================= --}}
<div class="overflow-auto dark:text-gray-400">

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




{{-- ================= TASK MODAL ================= --}}
<x-ui.modal name="task-modal"
    class="w-full max-w-xl p-6"
    :showCloseButton="false"
    x-on:open-modal.window="if ($event.detail === 'task-modal') open = true">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-5">
        <h3 id="taskModalTitle"
            class="text-lg font-bold text-gray-800 dark:text-white">
            Task
        </h3>
        <button @click="open = false" class="text-gray-400 hover:text-gray-600">✕</button>
    </div>

    {{-- FORM --}}
    <form id="taskForm" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" id="_method" name="_method" value="POST">
        <input type="hidden" id="parent_id" name="parent_id">
        <input type="hidden" id="task_id">

        

        {{-- TITLE --}}
        <div>
            <label class="text-sm font-medium">Judul</label>
            <input id="title" name="title"
                   class="h-11 w-full rounded-lg border px-3 text-sm">
        </div>

        {{-- DESCRIPTION --}}
        <div>
            <label class="text-sm font-medium">Deskripsi</label>
            <textarea id="description" name="description"
                      class="w-full rounded-lg border px-3 py-2 text-sm"></textarea>
        </div>

        {{-- DATE PICKER --}}
        <div class="grid grid-cols-2 gap-3">
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


{{-- ASSIGN USER --}}
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
                        class="flex items-center rounded-full bg-gray-100 px-2 py-1 text-sm dark:bg-gray-800">
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
            class="absolute z-50 mt-1 w-full rounded-lg border bg-white dark:bg-gray-900">
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

  

        
        {{-- PROGRESS --}}
    {{-- PROGRESS --}}
<div>
    <label class="mb-1.5 block text-sm font-medium text-gray-700">
        Progress (%)
    </label>
    <input type="number"
           id="progress"
           name="progress"
           min="0"
           max="100"
           value="0"
           class="h-11 w-full rounded-lg border px-3 text-sm">
</div>


    {{-- STATUS --}}
<div>
    <label class="text-sm font-medium">Status</label>
    <select id="status"
            name="status"
            class="h-11 w-full rounded-lg border px-3 text-sm">
        <option value="">-- Pilih Status --</option>
        <option value="todo">Todo</option>
        <option value="in_progress">In Progress</option>
        <option value="done">Done</option>
    </select>
</div>


        {{-- FOOTER --}}
        <div class="flex justify-between pt-4 border-t">


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
