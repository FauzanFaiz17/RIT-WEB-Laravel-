@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Calender" />
    
    {{-- TAMBAHKAN ATRIBUT DI BAWAH INI --}}
    <x-calender-area :events="$events" :unit="$unit" :isKetua="$isKetua" />
@endsection

