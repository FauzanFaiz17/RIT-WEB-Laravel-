import ApexCharts from 'apexcharts';

export function initSalesCategoryDonut() {
  const el = document.querySelector('#salesCategoryDonut');
  if (!el) return;

  const options = {
    chart: {
      type: 'donut',
      height: 239,
      fontFamily: 'Outfit, sans-serif',
    },
    series: [900, 700, 850],
    labels: ['Affiliate', 'Direct', 'Adsense'],
    legend: { show: false },
    dataLabels: { enabled: false },
    plotOptions: {
      pie: {
        donut: {
          size: '65%',
          labels: {
            show: true,
            total: {
              show: true,
              label: 'Total',
              formatter: () => '2450',
            },
          },
        },
      },
    },
  };

  new ApexCharts(el, options).render();
}
