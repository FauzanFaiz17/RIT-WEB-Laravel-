@extends('layouts.app')

@section('content')
<x-common.page-breadcrumb pageTitle="Menu Items" />

<x-common.component-card title="Manage Menu Items">
    <a href="{{ route('menu-items.create') }}"
       class="mb-4 inline-block rounded bg-blue-600 px-4 py-2 text-white">
        + Add Menu Item
    </a>

    <x-tables.menu-dnd-table :menus="$menus" />
</x-common.component-card>
@endsection
