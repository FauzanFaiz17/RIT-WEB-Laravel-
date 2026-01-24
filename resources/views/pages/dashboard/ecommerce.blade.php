@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-(--breakpoint-2xl) p-4 pb-20 md:p-6 md:pb-6">
            <div class="grid grid-cols-12 gap-4 md:gap-6">
              <div class="col-span-12">
                <!-- Metric Group Four -->
                  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 xl:grid-cols-3">
                    <x-dashboard.cardpane
                      :value="$totalUsers"
                      label="Total Users"
                      :change="$userGrowth"
                    />

                    <x-dashboard.cardpane
                      :value="$totalDivisions"
                      label="Total Divisions"
                      :change="$divisionGrowth"
                    />

                    <x-dashboard.cardpane
                      :value="$totalProjects"
                      label="Total Projects"
                      :change="$projectGrowth"
                    />
                  </div>

                <!-- Metric Group Four -->
              </div>

              <div class="col-span-12 xl:col-span-8">
                <!-- ====== Chart Eleven Start -->
                <x-dashboard.statistik-keuangan />
<!-- ====== Chart Eleven End -->
              </div>

              <div class="col-span-12 xl:col-span-4">
                <!-- ====== Chart Twelve Start -->
<x-dashboard.list-project :projects="$projectProgress" />





<!-- ====== Chart Twelve End -->
              </div>

              <div class="col-span-12 xl:col-span-6">
                <!-- ====== Chart Thirteen Start -->
         <x-dashboard.mayoritas
             :categories="$userByDivision"
    :total-users="$totalUsers"/>
<!-- ====== Chart Thirteen End -->
              </div>

        <div class="col-span-12 xl:col-span-6">
            <x-ecommerce.recent-orders
              :upcomingActivities="$upcomingActivities"
            />
        </div>

<!-- Table Four -->
              </div>
            </div>
          </div>
@endsection
