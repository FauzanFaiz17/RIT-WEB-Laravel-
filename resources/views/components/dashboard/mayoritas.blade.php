@props(['categories', 'totalUsers'])


<div 
  class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/[0.03]"
  x-data="salesCategory()"
  x-init="initChart()"
>
  <!-- HEADER -->
  <div class="flex items-center justify-between mb-5">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
      Mayoritas
    </h3>

    <div class="relative">
      <button 
        @click="openDropDown = !openDropDown"
        class="text-gray-400 hover:text-gray-700 dark:hover:text-white"
      >
        <!-- TailAdmin icon -->
        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M10.2441 6C10.2441 5.0335 11.0276 4.25 11.9941 4.25H12.0041
               C12.9706 4.25 13.7541 5.0335 13.7541 6
               C13.7541 6.9665 12.9706 7.75 12.0041 7.75H11.9941
               C11.0276 7.75 10.2441 6.9665 10.2441 6ZM
               10.2441 18C10.2441 17.0335 11.0276 16.25 11.9941 16.25H12.0041
               C12.9706 16.25 13.7541 17.0335 13.7541 18
               C13.7541 18.9665 12.9706 19.75 12.0041 19.75H11.9941
               C11.0276 19.75 10.2441 18.9665 10.2441 18ZM
               11.9941 10.25C11.0276 10.25 10.2441 11.0335 10.2441 12
               C10.2441 12.9665 11.0276 13.75 11.9941 13.75H12.0041
               C12.9706 13.75 13.7541 12.9665 13.7541 12
               C13.7541 11.0335 12.9706 10.25 12.0041 10.25H11.9941Z"/>
        </svg>
      </button>

      <div 
        x-show="openDropDown"
        @click.outside="openDropDown = false"
        x-transition
        class="absolute right-0 z-40 w-40 p-2 space-y-1 bg-white border border-gray-200 rounded-2xl shadow-theme-lg dark:bg-gray-dark dark:border-gray-800"
        style="display:none"
      >
        <button class="w-full px-3 py-2 text-left text-theme-xs text-gray-500 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5">
          View More
        </button>
        <button class="w-full px-3 py-2 text-left text-theme-xs text-gray-500 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5">
          Delete
        </button>
      </div>
    </div>
  </div>

  <!-- CONTENT -->
  <div class="flex flex-col items-center gap-8 xl:flex-row">
    <!-- DONUT -->
    <div id="salesCategoryDonut" class="min-h-[239px]"></div>

    <!-- LIST -->
    <div class="flex flex-col items-start gap-6 sm:flex-row xl:flex-col">
      <template x-for="item in categories" :key="item.name">
        <div class="flex items-start gap-2.5">
          <span 
            class="mt-1.5 h-2 w-2 rounded-full"
            :style="`background-color:${item.color}`"
          ></span>

          <div>
            <h5 class="mb-1 font-medium text-gray-800 text-theme-sm dark:text-white/90" x-text="item.name"></h5>
            <div class="flex items-center gap-2 text-theme-sm text-gray-500 dark:text-gray-400">
              <span class="font-medium" x-text="item.percent + '%'"></span>
              <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
              <span x-text="item.products.toLocaleString() + ' Products'"></span>
            </div>
          </div>
        </div>
      </template>
    </div>
  </div>
</div>
<script>
function salesCategory() {
  return {
    openDropDown: false,
    chart: null,

    categories: @js($categories),
    totalUsers: {{ $totalUsers }},

    initChart() {
      if (this.chart) return

      this.chart = new ApexCharts(
        document.querySelector('#salesCategoryDonut'),
        {
          chart: {
            type: 'donut',
            height: 239,
            fontFamily: 'Outfit, sans-serif',
          },

          labels: this.categories.map(c => c.name),
          series: this.categories.map(c => c.users),
          colors: this.categories.map(c => c.color),

          legend: { show: false },
          dataLabels: { enabled: false },

          plotOptions: {
            pie: {
              donut: {
                size: '70%',
                labels: {
                  show: true,

                  value: {
                    show: true,
                    fontSize: '22px',
                    fontWeight: 600,
                    formatter: () => this.totalUsers.toLocaleString(),
                  },

                  total: {
                    show: true,
                    label: 'Total User',
                    formatter: () => this.totalUsers.toLocaleString(),
                  },
                },
              },
            },
          },
        }
      )

      this.chart.render()
    }
  }
}
</script>

