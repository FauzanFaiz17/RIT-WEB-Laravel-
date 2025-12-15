@extends('layouts.app')

@section('content')
<x-common.component-card title="Create Menu Item">

<form method="POST"
      action="{{ route('menu-items.store') }}"
      class="space-y-5">
    @csrf

    <x-app.form.select.select label="Menu" name="menu_id">
        @foreach ($menus as $menu)
            <option value="{{ $menu->id }}">{{ $menu->title }}</option>
        @endforeach
    </x-app.form.select.select>

    <x-app.form.select.select label="Parent Menu (Optional)" name="parent_id">
        <option value="">— No Parent —</option>
        @foreach ($parents as $parent)
            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
        @endforeach
    </x-app.form.select.select>

    <x-app.form.form-elements.default-inputs
        label="Name"
        name="name"
        placeholder="Menu name"
    />

    <x-app.form.form-elements.default-inputs
        label="Icon"
        name="icon"
        placeholder="Icon class (optional)"
    />

    <x-app.form.form-elements.default-inputs
        label="Path"
        name="path"
        placeholder="/dashboard"
    />

    <x-app.form.form-elements.default-inputs
        label="Order"
        name="order"
        type="number"
    />

    <button
        class="inline-flex items-center justify-center rounded-lg
               bg-brand-500 px-5 py-2.5 text-sm font-medium
               text-white hover:bg-brand-600 transition">
        Save
    </button>
</form>

</x-common.component-card>
@endsection
