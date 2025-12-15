@props(['menus'])

<div class="space-y-6">
@foreach ($menus as $menu)
<div
    x-data="menuDragDrop()"
    x-init="init()"
    class="rounded-xl border border-gray-200 bg-white
           dark:border-gray-800 dark:bg-white/[0.03]"
>
    <div class="px-5 py-3 font-semibold border-b dark:border-gray-800">
        {{ $menu->title }}
    </div>

    <table class="w-full">
        <tbody x-ref="root">
        @foreach ($menu->items as $item)
            <tr
                class="draggable border-b border-gray-100 dark:border-gray-800"
                data-id="{{ $item->id }}"
                data-parent=""
            >
                <td class="px-5 py-3 cursor-move font-medium text-gray-800 dark:text-gray-200">
                    {{ $item->name }}
                </td>
                <td class="px-5 py-3 text-gray-500 dark:text-gray-400">
                    {{ $item->path }}
                </td>
                <td class="px-5 py-3">
                    {{ $item->order }}
                </td>
                <td class="px-5 py-3">
                    <a href="{{ route('menu-items.edit', $item) }}"
                       class="text-blue-600">Edit</a>

                    <form method="POST"
                          action="{{ route('menu-items.destroy', $item) }}"
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600">Delete</button>
                    </form>
                </td>
            </tr>

            @foreach ($item->children as $child)
            <tr
                class="draggable bg-gray-50 dark:bg-white/[0.02]"
                data-id="{{ $child->id }}"
                data-parent="{{ $item->id }}"
            >
                <td class="px-10 py-3 cursor-move text-gray-700 dark:text-gray-300">
                    └ {{ $child->name }}
                </td>
                <td class="px-5 py-3 text-gray-500 dark:text-gray-400">
                    {{ $child->path }}
                </td>
                <td class="px-5 py-3">
                    {{ $child->order }}
                </td>
                <td class="px-5 py-3">
                    <a href="{{ route('menu-items.edit', $child) }}"
                       class="text-blue-600">Edit</a>

                    <form method="POST"
                          action="{{ route('menu-items.destroy', $child) }}"
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
</div>
@endforeach
</div>

<script>
function menuDragDrop() {
    return {
        init() {
            new Sortable(this.$refs.root, {
                animation: 150,
                handle: '.cursor-move',
                onEnd: () => this.save()
            })
        },
        save() {
            const items = []

            this.$refs.root.querySelectorAll('[data-parent=""]').forEach((el, index) => {
                items.push({
                    id: el.dataset.id,
                    parent_id: null,
                    order: index + 1
                })

                this.$refs.root
                    .querySelectorAll(`[data-parent="${el.dataset.id}"]`)
                    .forEach((child, cIndex) => {
                        items.push({
                            id: child.dataset.id,
                            parent_id: el.dataset.id,
                            order: cIndex + 1
                        })
                    })
            })

            fetch('{{ route('menu-items.reorder') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ items })
            })
            .then(res => {
                if (res.ok) {
                    location.reload() // 🔥 INI KUNCINYA
                }
            })
        }

    }
}
</script>
