@extends('layouts.app')

@section('content')
<x-common.component-card title="Edit Menu Item">

<form method="POST" action="{{ route('menu-items.update', $menuItem) }}" class="space-y-4">
@csrf
@method('PUT')

<input name="name" value="{{ $menuItem->name }}" class="w-full border p-2">
<input name="icon" value="{{ $menuItem->icon }}" class="w-full border p-2">
<input name="path" value="{{ $menuItem->path }}" class="w-full border p-2">
<input name="order" type="number" value="{{ $menuItem->order }}" class="w-full border p-2">

<button class="bg-green-600 text-white px-4 py-2 rounded">
    Update
</button>

</form>
</x-common.component-card>
@endsection
