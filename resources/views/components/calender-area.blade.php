@props(['events', 'unit', 'isKetua'])
<div>
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="custom-calendar p-4">
            <div id="calendar" class="min-h-screen"></div>
        </div>
    </div>

    <div class="fixed inset-0 items-center justify-center hidden p-5 overflow-y-auto modal z-99999" id="eventModal">
        <div class="modal-close-btn fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-sm" onclick="closeModal()">
        </div>
        <div
            class="modal-dialog relative z-50 flex w-full max-w-[700px] flex-col overflow-y-auto rounded-3xl bg-white p-6 lg:p-11 dark:bg-gray-900 shadow-2xl">

            <form id="activityForm" method="POST">
                @csrf

                <input type="hidden" id="in-id" name="id">
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <button type="button" onclick="closeModal()"
                    class="absolute top-5 right-5 z-999 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 dark:bg-white/[0.05]">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg>
                </button>

                <div class="flex flex-col px-2">
                    <div class="modal-header mb-8">
                        <h5 class="font-semibold text-gray-800 text-2xl dark:text-white/90" id="modalTitle">Add Activity
                        </h5>
                        <p class="text-sm text-gray-500">Rencanakan agenda kegiatan atau acara divisi Anda.</p>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Judul
                                Aktivitas</label>
                            <input id="in-title" name="title" type="text" required
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:text-white"
                                placeholder="Masukkan judul..." />
                        </div>
                        <div>
    <label class="mb-1.5 block text-sm font-medium">Status</label>
    <select id="in-status" name="status"
        class="w-full rounded-lg border px-4 py-2.5">
        <option value="pending">Pending</option>
        <option value="progress">Progress</option>
        <option value="completed">Completed</option>
    </select>
</div>


                        <div>
                            <label class="block mb-4 text-sm font-medium text-gray-700 dark:text-gray-400">Jenis
                                Aktivitas</label>
                            <div class="flex items-center gap-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="type" value="kegiatan" id="type-kegiatan" checked
                                        class="w-4 h-4 text-[#3C50E0]">
                                    <span class="text-sm text-gray-700 dark:text-gray-400">Kegiatan (Biru)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="type" value="acara" id="type-acara"
                                        class="w-4 h-4 text-[#FFA70B]">
                                    <span class="text-sm text-gray-700 dark:text-gray-400">Acara (Orange)</span>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Waktu
                                    Mulai</label>
                                <input id="in-start" name="start_date" type="datetime-local" required
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:text-white" />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Waktu
                                    Selesai</label>
                                <input id="in-end" name="end_date" type="datetime-local"
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:text-white" />
                            </div>
                        </div>

                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Lokasi</label>
                            <input id="in-location" name="location" type="text"
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:text-white"
                                placeholder="Ruang Rapat / Zoom" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Deskripsi
                            </label>
                            <textarea id="in-description" name="description" rows="3"
                                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:text-white"
                                placeholder="Masukkan deskripsi kegiatan..."></textarea>
                        </div>

                    </div>

                    <div class="flex items-center gap-3 mt-10 justify-end">
                        <button type="button" onclick="closeModal()"
                            class="rounded-lg border border-gray-300 px-6 py-2.5 text-sm font-medium dark:text-gray-400">Close</button>
                        <button type="button" id="btnDelete" onclick="submitDelete()"
                            class="hidden rounded-lg bg-red-500 px-6 py-2.5 text-sm font-medium text-white hover:bg-opacity-90">Delete</button>
                        <button type="submit" id="btnSubmit"
                            class="rounded-lg bg-[#3C50E0] px-6 py-2.5 text-sm font-medium text-white hover:bg-opacity-90">Save
                            Activity</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
    // 1. Definisikan fungsi modal secara GLOBAL agar bisa diakses atribut onclick template
    window.openModal = function() {
        const modal = document.getElementById('eventModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden'; // Kunci scroll saat modal buka
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



    document.addEventListener('DOMContentLoaded', function() {
        // 2. Pasang Event Listener ke semua tombol close bawaan template
        const closeButtons = document.querySelectorAll('.modal-close-btn');
        closeButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                window.closeModal();
            });
        });

        // 3. Inisialisasi Kalender dengan ID 'calendar' sesuai HTML template Anda
        const calendarEl = document.getElementById('calendar');

        // Cek keamanan untuk mencegah eror 'null'
        if (!calendarEl) return;




        // Gunakan FullCalendar (Huruf Kapital) sesuai standar CDN v6
        if (typeof FullCalendar !== 'undefined') {


            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',

                selectable: true,
                selectMirror: true,
                unselectAuto: false,
                editable: true,

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },

                events: @json($events ?? []),
                eventDrop: function(info) {
                    autoSaveEvent(info);
                },

                eventResize: function(info) {
                    autoSaveEvent(info);
                },


                select: function(info) {
                @php if($isKetua ?? false): @endphp
                    const form = document.getElementById('activityForm');
                    form.reset();

                    // MODE CREATE
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

                    const now = new Date();

                    const start = new Date(info.start);
                    start.setHours(now.getHours(), now.getMinutes());

                    const end = new Date(info.end || info.start);
                    end.setHours(now.getHours() + 1, now.getMinutes());

                    document.getElementById('in-id').value = '';
                    document.getElementById('in-start').value = format(start);
                    document.getElementById('in-end').value = format(end);

                    openModal();
                @php endif; @endphp
                },


               eventClick: function(info) {
            @php if($isKetua ?? false): @endphp
                const e = info.event;
                const form = document.getElementById('activityForm');

                // MODE EDIT
                form.action = `/activities/${e.id}`;
                document.getElementById('formMethod').value = "PUT";
                document.getElementById('in-status').value = e.extendedProps.status ?? 'pending';

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

                // EXTRA
                if (e.extendedProps) {
                    document.getElementById('in-location').value = e.extendedProps.location || '';
                    document.getElementById('in-description').value = e.extendedProps.description || '';
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
                    } else {
                        console.error("Library FullCalendar gagal dimuat. Periksa koneksi internet.");
                    }
                });

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
</script>
<script>
document.getElementById('activityForm').addEventListener('submit', function () {
    const type = document.querySelector('input[name="type"]:checked').value;

    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.innerText = 'Saving...';
});
</script>
 --}}

 <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<script>
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


// ================= AUTO SAVE DRAG =================

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
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            start_date: start,
            end_date: end
        })
    })
    .then(async res => {
        if (!res.ok) {
            throw await res.text();
        }
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

// ================= DELETE =================

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

document.getElementById('activityForm').addEventListener('submit', function () {
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.innerText = 'Saving...';
});
</script>
