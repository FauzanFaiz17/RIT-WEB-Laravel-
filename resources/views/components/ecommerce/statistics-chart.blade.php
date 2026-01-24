@props(['totalPemasukan', 'totalPengeluaran', 'saldo', 'chartData'])

    {{-- SUB-SECTION: LEFT CARD - STATISTICS --}}
    <div class="col-span-12 lg:col-span-8">
        <x-dashboard.statistik-keuangan 
            :totalPemasukan="$totalPemasukan" 
            :totalPengeluaran="$totalPengeluaran" 
            :saldo="$saldo" 
            :chartData="$chartData" 
        />
    </div>
