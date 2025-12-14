@props(['menus'])

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <table class="w-full min-w-[900px]">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="px-5 py-3 text-left sm:px-6">Menu</th>
                    <th class="px-5 py-3 text-left sm:px-6">Item</th>
                    <th class="px-5 py-3 text-left sm:px-6">Path</th>
                    <th class="px-5 py-3 text-left sm:px-6">Icon</th>
                    <th class="px-5 py-3 text-left sm:px-6">Order</th>
                    <th class="px-5 py-3 text-left sm:px-6">Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($menus as $menu)
                    {{-- MENU HEADER --}}
                    <tr class="bg-gray-50 dark:bg-gray-900/30">
                        <td colspan="6" class="px-5 py-3 font-semibold text-gray-800 dark:text-white">
                            {{ $menu->title }}
                        </td>
                    </tr>

                    {{-- MENU ITEMS --}}
                    @foreach ($menu->items as $item)
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <td class="px-5 py-4 sm:px-6"></td>
                            <td class="px-5 py-4 sm:px-6 font-medium">
                                {{ $item->name }}
                            </td>
                            <td class="px-5 py-4 sm:px-6">{{ $item->path }}</td>
                            <td class="px-5 py-4 sm:px-6">{{ $item->icon }}</td>
                            <td class="px-5 py-4 sm:px-6">{{ $item->order }}</td>
                            <td class="px-5 py-4 sm:px-6">
                                @if ($item->is_active)
                                    <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs text-green-700">Active</span>
                                @else
                                    <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs text-red-700">Inactive</span>
                                @endif
                            </td>
                        </tr>

                        {{-- CHILDREN --}}
                        @foreach ($item->children as $child)
                            <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/10">
                                <td></td>
                                <td class="px-5 py-4 sm:px-10 text-gray-600">
                                    └ {{ $child->name }}
                                </td>
                                <td class="px-5 py-4 sm:px-6">{{ $child->path }}</td>
                                <td class="px-5 py-4 sm:px-6">{{ $child->icon }}</td>
                                <td class="px-5 py-4 sm:px-6">{{ $child->order }}</td>
                                <td class="px-5 py-4 sm:px-6">
                                    @if ($child->is_active)
                                        <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs text-green-700">Active</span>
                                    @else
                                        <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs text-red-700">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
