@extends('layouts.app')

@section('content')
<x-common.component-card title="Create Menu Item">

<form method="POST" action="{{ route('menu-items.store') }}" class="space-y-4">
@csrf

<select name="menu_id" class="w-full border rounded p-2">
    @foreach ($menus as $menu)
        <option value="{{ $menu->id }}">{{ $menu->title }}</option>
    @endforeach
</select>

<select name="parent_id" class="w-full border rounded p-2">
    <option value="">Parent (optional)</option>
    @foreach ($parents as $parent)
        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
    @endforeach
</select>

<input name="name" placeholder="Name" class="w-full border p-2">
<input name="icon" placeholder="Icon (optional)" class="w-full border p-2">
<input name="path" placeholder="/dashboard" class="w-full border p-2">
<input name="order" type="number" class="w-full border p-2">

<button class="bg-blue-600 text-white px-4 py-2 rounded">
    Save
</button>

</form>
</x-common.component-card>
@endsection
