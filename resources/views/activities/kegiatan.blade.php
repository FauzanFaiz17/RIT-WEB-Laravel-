<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-6">
            Daftar Agenda - {{ $unit->name }}
        </h1>

        <div class="overflow-x-auto bg-white rounded-xl shadow">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left">Judul</th>
                        <th class="px-4 py-3">Mulai</th>
                        <th class="px-4 py-3">Selesai</th>
                        <th class="px-4 py-3">Lokasi</th>
                        <th class="px-4 py-3">Jenis</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activities as $a)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $a->title }}</td>
                            <td class="px-4 py-3">{{ $a->start_date }}</td>
                            <td class="px-4 py-3">{{ $a->end_date }}</td>
                            <td class="px-4 py-3">{{ $a->location }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded text-xs
                                    {{ $a->type == 'kegiatan' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' }}">
                                    {{ ucfirst($a->type) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 flex gap-2">
                                <a href="{{ route('activities.edit', $a->id) }}"
                                   class="text-blue-600 hover:underline">Edit</a>

                                <form method="POST"
                                      action="{{ route('activities.destroy', $a->id) }}"
                                      onsubmit="return confirm('Hapus agenda ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
