{{-- SECTION: COMPONENT PROPERTIES --}}
@props(['events', 'unit', 'isKetua'])

<div>
    {{-- SECTION: CALENDAR CONTAINER --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="custom-calendar p-4">
            <div id="calendar" class="min-h-screen"></div>
        </div>
    </div>

    {{-- SECTION: EVENT MODAL (ADD & EDIT) --}}
    <div class="fixed inset-0 z-[99999] hidden items-center justify-center p-4" id="eventModal">
        {{-- Modal Overlay --}}
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeModal()"></div>
        
        {{-- Modal Dialog --}}
        <div class="relative z-50 flex w-full max-w-[650px] max-h-[95vh] flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#24303F] shadow-2xl">
            
            {{-- Close Button --}}
            <button type="button" onclick="closeModal()" 
                class="absolute top-4 right-4 z-[60] flex h-9 w-9 items-center justify-center rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/10">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>

            {{-- Activity Form --}}
            <form id="activityForm" method="POST" class="flex flex-col overflow-hidden">
                @csrf
                <input type="hidden" id="in-id" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">

                {{-- Scrollable Content Body --}}
                <div class="flex-1 overflow-y-auto p-6 lg:p-10 custom-scrollbar">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white" id="modalTitle">Atur Aktivitas</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Rencanakan agenda kegiatan divisi Anda di sini.</p>
                    </div>

                    <div class="space-y-6">
                        {{-- Title Input --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-800 dark:text-white">Judul Aktivitas</label>
                            <input id="in-title" name="title" type="text" required
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 dark:text-white outline-none focus:border-[#3C50E0] dark:border-gray-700"
                                placeholder="Contoh: Rapat Koordinasi" />
                        </div>

                        {{-- Status Select --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-800 dark:text-white">Status</label>
                            <select id="in-status" name="status" 
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 dark:text-white outline-none focus:border-[#3C50E0] dark:border-gray-700">
                                <option value="pending">Pending</option>
                                <option value="progress">Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>

                        {{-- Activity Type (Radio) --}}
                        <div>
                            <label class="mb-3 block text-sm font-medium text-gray-800 dark:text-white">Jenis Aktivitas</label>
                            <div class="flex gap-6 mt-2">
                                <label class="flex items-center gap-2 cursor-pointer text-sm dark:text-gray-300">
                                    <input type="radio" name="type" value="kegiatan" id="type-kegiatan" checked class="w-4 h-4 text-[#3C50E0]"> Kegiatan (Biru)
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer text-sm dark:text-gray-300">
                                    <input type="radio" name="type" value="acara" id="type-acara" class="w-4 h-4 text-orange-500"> Acara (Orange)
                                </label>
                            </div>
                        </div>

                        {{-- Date/Time Inputs --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-800 dark:text-white">Mulai</label>
                                <input id="in-start" name="start_date" type="datetime-local" required
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm dark:text-white focus:border-[#3C50E0] dark:border-gray-700" />
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-800 dark:text-white">Selesai</label>
                                <input id="in-end" name="end_date" type="datetime-local"
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm dark:text-white focus:border-[#3C50E0] dark:border-gray-700" />
                            </div>
                        </div>

                        {{-- Location Input --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-800 dark:text-white">Lokasi</label>
                            <input id="in-location" name="location" type="text"
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm dark:text-white dark:border-gray-700" placeholder="Aula Utama / Zoom" />
                        </div>

                        {{-- Description Input --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-800 dark:text-white">Deskripsi</label>
                            <textarea id="in-description" name="description" rows="3"
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm dark:text-white dark:border-gray-700" placeholder="Detail kegiatan..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="flex items-center justify-between border-t border-gray-100 bg-gray-50/50 p-6 dark:border-gray-800 dark:bg-white/[0.02]">
                    <button type="button" id="btnDelete" onclick="submitDelete()"
                        class="hidden text-sm font-bold text-red-500 hover:text-red-700 flex items-center gap-1.5 transition">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus Data
                    </button>
                    <div class="flex gap-3 ml-auto">
                        <button type="button" onclick="closeModal()" 
                            class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/10 transition">Batal</button>
                        <button type="submit" id="btnSubmit"
                            class="rounded-lg bg-[#3C50E0] px-8 py-2.5 text-sm font-bold text-white hover:bg-opacity-90 shadow-lg transition-all active:scale-95">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SECTION: EXTERNAL SCRIPTS --}}
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<script>
    {{-- SECTION: MODAL ACTIONS (OPEN/CLOSE) --}}
    window.openModal = function() {
        const modal = document.getElementById('eventModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    };

    window.closeModal = function() {
        const modal = document.getElementById('eventModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';

        document.getElementById('btnDelete').classList.add('hidden');
        document.getElementById('activityForm').reset();
        document.getElementById('formMethod').value = "POST";
    };

    {{-- SECTION: FULLCALENDAR INITIALIZATION --}}
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        if (!calendarEl) return;

        if (typeof FullCalendar !== 'undefined') {
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                editable: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: @json($events ?? []),
                eventDrop: autoSaveEvent,
                eventResize: autoSaveEvent,

                {{-- Logic: Select Date to Add Event --}}
                select: function(info) {
                    @php if($isKetua ?? false): @endphp
                        const form = document.getElementById('activityForm');
                        form.reset();
                        form.action = "{{ route('activities.store', $unit->id) }}";
                        document.getElementById('formMethod').value = "POST";
                        document.getElementById('btnDelete').classList.add('hidden');

                        function format(d) {
                            const pad = n => n.toString().padStart(2, '0');
                            return d.getFullYear() + '-' +
                                pad(d.getMonth() + 1) + '-' +
                                pad(d.getDate()) + 'T' +
                                pad(d.getHours()) + ':' +
                                pad(d.getMinutes());
                        }

                        document.getElementById('in-id').value = '';
                        document.getElementById('in-start').value = format(info.start);
                        document.getElementById('in-end').value = format(info.end || info.start);

                        openModal();
                    @php endif; @endphp
                },

                {{-- Logic: Click Event to Edit --}}
                eventClick: function(info) {
                    @php if($isKetua ?? false): @endphp
                        const e = info.event;
                        const form = document.getElementById('activityForm');

                        form.action = `/activities/${e.id}`;
                        document.getElementById('formMethod').value = "PUT";
                        document.getElementById('btnDelete').classList.remove('hidden');

                        function format(d) {
                            const pad = n => n.toString().padStart(2, '0');
                            return d.getFullYear() + '-' +
                                pad(d.getMonth() + 1) + '-' +
                                pad(d.getDate()) + 'T' +
                                pad(d.getHours()) + ':' +
                                pad(d.getMinutes());
                        }

                        document.getElementById('in-id').value = e.id;
                        document.getElementById('in-title').value = e.title;
                        document.getElementById('in-start').value = format(e.start);
                        document.getElementById('in-end').value = e.end ? format(e.end) : '';

                        if (e.extendedProps) {
                            document.getElementById('in-location').value = e.extendedProps.location || '';
                            document.getElementById('in-description').value = e.extendedProps.description || '';
                            document.getElementById('in-status').value = e.extendedProps.status || 'pending';

                            if (e.extendedProps.type === 'acara') {
                                document.getElementById('type-acara').checked = true;
                            } else {
                                document.getElementById('type-kegiatan').checked = true;
                            }
                        }

                        openModal();
                    @php endif; @endphp
                },
            });

            calendar.render();
        }
    });

    {{-- SECTION: AUTO SAVE ON DRAG/RESIZE --}}
    function autoSaveEvent(info) {
        const event = info.event;

        function formatDate(date) {
            const pad = n => n.toString().padStart(2, '0');
            return date.getFullYear() + '-' +
                   pad(date.getMonth() + 1) + '-' +
                   pad(date.getDate());
        }

        let start = formatDate(event.start);
        let end   = event.end ? formatDate(event.end) : null;

        fetch(`/activities/${event.id}/drag`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                start_date: start,
                end_date: end
            })
        })
        .then(async res => {
            if (!res.ok) { throw await res.text(); }
            return res.json();
        })
        .then(res => {
            if (!res.status) {
                alert('Gagal menyimpan perubahan');
                info.revert();
            }
        })
        .catch(err => {
            console.error(err);
            alert('Gagal menyimpan perubahan');
            info.revert();
        });
    }

    {{-- SECTION: DELETE ACTIVITY ACTION --}}
    function submitDelete() {
        const id = document.getElementById('in-id').value;
        if (!id) return;

        if (!confirm('Yakin ingin menghapus kegiatan ini?')) return;

        fetch(`/activities/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        }).then(res => {
            if (res.ok) {
                location.reload();
            } else {
                alert('Gagal menghapus');
            }
        });
    }

    {{-- SECTION: FORM SUBMIT LOADING --}}
    document.getElementById('activityForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerText = 'Saving...';
    });
</script>