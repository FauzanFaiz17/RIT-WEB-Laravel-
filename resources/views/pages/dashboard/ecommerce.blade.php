@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12 space-y-6 xl:col-span-7">
            <x-ecommerce.ecommerce-metrics
             :totalUser="$totalUser"
             :totalDivisions="$totalDivisions"
             :totalActivity="$totalActivity"
             :totalCommunities="$totalCommunities"

            />
            
            {{-- <x-ecommerce.monthly-sale /> --}}
        </div>
        {{-- <div class="col-span-12 xl:col-span-5">
        <x-ecommerce.monthly-target />
            </div> --}}

        <div class="col-span-12">
            <div class="grid grid-cols-12 gap-4 md:gap-6">
            <x-ecommerce.statistics-chart 
                :totalPemasukan="$totalPemasukan"
                :totalPengeluaran="$totalPengeluaran"
                :saldo="$saldo"
                :chartData="$chartData"
            />
 
        </div>

        <div class="col-span-12 xl:col-span-5">
            <x-ecommerce.customer-demographic />
        </div>

        <div class="col-span-12 xl:col-span-7">
            <x-ecommerce.recent-orders
              :upcomingActivities="$upcomingActivities"
            />
        </div>
    </div>

    @endsection
