@props(['totalPemasukan', 'totalPengeluaran', 'saldo', 'chartData'])

<div class="rounded-2xl border border-gray-200 bg-white px-5 pb-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
    <div class="flex flex-col gap-5 mb-6 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Statistik Keuangan
            </h3>
            <p class="mt-1 text-gray-500 text-theme-sm dark:text-gray-400">
                Ringkasan pemasukan dan pengeluaran.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <div class="text-right">
                <h4 class="text-base font-bold text-gray-800 dark:text-white/90 sm:text-theme-xl">
                    Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}
                </h4>
                <p class="text-gray-500 text-theme-xs dark:text-gray-400">Total Saldo</p>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-4 sm:gap-9 mb-6">
        <!-- Pemasukan -->
        <div class="flex items-start gap-2">
            <div>
                <h4 class="mb-0.5 text-base font-bold text-gray-800 dark:text-white/90 sm:text-theme-xl">
                    Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}
                </h4>
                <span class="text-gray-500 text-theme-xs dark:text-gray-400">Total Pemasukan</span>
            </div>
            <span class="mt-1.5 flex items-center gap-1 rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                <svg class="fill-current w-3 h-3" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.35716 2.47737L0.908974 5.82987L5.0443e-07 4.94612L5 0.0848689L10 4.94612L9.09103 5.82987L5.64284 2.47737L5.64284 10.0849L4.35716 10.0849L4.35716 2.47737Z" />
                </svg>
                Masuk
            </span>
        </div>

        <!-- Pengeluaran -->
        <div class="flex items-start gap-2">
            <div>
                <h4 class="mb-0.5 text-base font-bold text-gray-800 dark:text-white/90 sm:text-theme-xl">
                    Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}
                </h4>
                <span class="text-gray-500 text-theme-xs dark:text-gray-400">Total Pengeluaran</span>
            </div>
            <span class="mt-1.5 flex items-center gap-1 rounded-full bg-error-50 px-2 py-0.5 text-theme-xs font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500">
                <svg class="fill-current w-3 h-3" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.64284 7.69236L9.09102 4.33986L10 5.22361L5.00001 10.0849L0 5.22361L0.908973 4.33986L4.35715 7.69236L4.35715 0.0848683L5.64284 0.0848684L5.64284 7.69236Z" />
                </svg>
                Keluar
            </span>
        </div>
    </div>

    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <div id="chartKeuangan" class="-ml-4 min-w-[1000px] pl-2 xl:min-w-full min-h-[235px]"></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const chartElement = document.querySelector("#chartKeuangan");
            
            if (chartElement) {
                const options = {
                    series: [
                        { name: "Pemasukan", data: @json($chartData['pemasukan'] ?? []) },
                        { name: "Pengeluaran", data: @json($chartData['pengeluaran'] ?? []) }
                    ],
                    chart: {
                        type: "area",
                        height: 235,
                        fontFamily: "Outfit, sans-serif",
                        toolbar: { show: false },
                    },
                    colors: ["#10B981", "#EF4444"],
                    fill: {
                        type: "gradient",
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.55,
                            opacityTo: 0.0,
                            stops: [0, 100],
                        },
                    },
                    dataLabels: { enabled: false },
                    stroke: { curve: "smooth", width: 2 },
                    xaxis: {
                        categories: @json($chartData['dates'] ?? []),
                        axisBorder: { show: false },
                        axisTicks: { show: false },
                    },
                    yaxis: {
                        labels: {
                            style: { colors: "#64748b", fontSize: "12px" },
                            formatter: function (value) {
                                if (value >= 1000) {
                                    return (value / 1000).toFixed(0) + "k";
                                }
                                return value;
                            }
                        },
                    },
                    grid: {
                        borderColor: "#e0e0e0",
                        strokeDashArray: 0,
                    },
                    legend: { show: true, position: 'top', horizontalAlign: 'right' },
                    tooltip: {
                        enabled: true,
                        shared: true,
                        intersect: false,
                        y: {
                            formatter: function (val) {
                                return "Rp " + new Intl.NumberFormat('id-ID').format(val);
                            }
                        }
                    },
                    markers: {
                        size: 0,
                        hover: {
                            size: 6,
                            sizeOffset: 3
                        }
                    }
                };

                const chart = new ApexCharts(chartElement, options);
                chart.render();
            }
        });
    </script>
</div>