<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?= csrf_meta() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?></title>
    <!-- Add Tailwind CSS via CDN -->
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="<?=base_url()?>pos/js/pos_main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
</head>

<body class="min-h-screen bg-black">
<div class="hide-print bg-gradient-to-b from-slate-800 to-cyan-800 flex flex-col h-screen antialiased text-blue-gray-800">
    <div class="w-full pl-4 pr-4 overflow-auto" x-data="{ 
    reports: [
        { id: 1, name: 'Summary Sales Report', url: 'http://localhost:8080' },
        { id: 2, name: 'Item Sales Report / Department', url: 'http://localhost:8080' },
        { id: 3, name: 'Item Sales Report / Category', url: 'http://localhost:8080' },
        { id: 4, name: 'Item Count Report', url: 'http://localhost:8080' },
        { id: 5, name: 'Hourly Sales Report', url: 'http://localhost:8080' },
        { id: 6, name: 'Hourly Sales Report Per Cashier', url: 'http://localhost:8080' },
        { id: 7, name: 'Hourly Sales Report Per Department', url: 'http://localhost:8080' },
        { id: 8, name: 'Top Item Report By Revenue', url: 'http://localhost:8080' },
        { id: 9, name: 'Top Item Report By Quantity', url: 'http://localhost:8080' },
        { id: 10, name: 'Payment Report', url: 'http://localhost:8080' },
        { id: 11, name: 'Cashier Report', url: 'http://localhost:8080' },
        { id: 12, name: 'Cashier Detail Report', url: 'http://localhost:8080' },
        { id: 13, name: 'Cashier TOPUP Refund Report', url: 'http://localhost:8080' },
        { id: 14, name: 'Payment Employee Report', url: 'http://localhost:8080' },
        { id: 15, name: 'Void Report', url: 'http://localhost:8080' },
        { id: 16, name: 'Item Void Report / Category', url: 'http://localhost:8080' },
        { id: 17, name: 'No Sales Item Report Department', url: 'http://localhost:8080' },
        { id: 18, name: 'No Sales Item Report Category', url: 'http://localhost:8080' },
        { id: 19, name: 'Attendance Report', url: 'http://localhost:8080' },
        { id: 20, name: 'Summary Sales Report', url: 'http://localhost:8080' },
        { id: 21, name: 'Cashier TOPUP Report', url: 'http://localhost:8080' },
        { id: 22, name: 'Item Sales Report All (Inc No Sales)', url: 'http://localhost:8080' },
        { id: 23, name: 'Outstanding Item Sales Report', url: 'http://localhost:8080' },
        { id: 24, name: 'Hourly Department Report', url: 'http://localhost:8080' },
        { id: 25, name: 'Print Count Report', url: 'http://localhost:8080' },
        { id: 26, name: 'Change Table Report', url: 'http://localhost:8080' },
        { id: 27, name: 'Product Data Report', url: 'http://localhost:8080' },
        { id: 28, name: 'Summary Sales Report-Shift 1', url: 'http://localhost:8080' },
        { id: 29, name: 'Item Sales Report-Shift 1', url: 'http://localhost:8080' },
        { id: 30, name: 'Summary Sales Report-Shift 2', url: 'http://localhost:8080' },
        { id: 31, name: 'Item Sales Report Shift 2', url: 'http://localhost:8080' },
        { id: 32, name: 'Summary Sales Report-Shift 3', url: 'http://localhost:8080' },
        { id: 33, name: 'Item Sales Report Shift 3', url: 'http://localhost:8080' },
        { id: 34, name: 'Item Sales Report', url: 'http://localhost:8080' },

    ],
    titleMenu: 'Report Pos List'
}">
        <div x-show="reports.length" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-8 gap-2">
            <template x-for="tbl in reports" :key="tbl.id">
                <div role="button" class="rounded-lg shadow-xl bg-gradient-to-b from-slate-400 to-cyan-200 py-2 hover:bg-cyan-400 hover:text-white focus:outline-none"
                :title="tbl.name">
                    <div class="flex items-center justify-center h-6 font-semibold m-2">
                        <div class="flex text-center">
                            <p class="max-w-md text-lg font-medium" x-text="tbl.name"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
    <div class="w-full pl-2 pr-4 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-1">
        <div class="flex flex-col items-center bg-gray-200 justify-center font-semibold m-2 rounded-lg">
            <div class="flex text-center pt-2 -pb-2">
                <p class="max-w-md text-lg font-medium">Total Sales Per Category</p>
            </div>
            <div x-data="chartComp1()" x-init="renderChart1()" class="w-full max-w-lg p-2 bg-white shadow-lg rounded-lg m-4">
                <canvas id="myChart1"></canvas>
            </div>
        </div>
        <div class="flex flex-col items-center bg-gray-200 justify-center font-semibold m-1 rounded-lg">
            <div class="flex text-center pt-2 -pb-2">
                <p class="max-w-md text-lg font-medium">Payment Method</p>
            </div>
            <div x-data="chartComp2()" x-init="renderChart2()" class="w-full max-w-lg p-2 bg-white shadow-lg rounded-lg m-4">
                <canvas id="myChart2"></canvas>
            </div>
        </div>
        <div class="flex flex-col items-center bg-gray-200 justify-center font-semibold m-1 rounded-lg">
            <div class="flex text-center pt-2 -pb-2">
                <p class="max-w-md text-lg font-medium">Total Sales Per Shift</p>
            </div>
            <div x-data="chartComp3()" x-init="renderChart3()" class="w-full max-w-lg p-2 bg-white shadow-lg rounded-lg m-4">
                <canvas id="myChart3"></canvas>
            </div>
        </div>
        <div class="flex flex-col items-center bg-gray-200 justify-center font-semibold m-1 rounded-lg">
            <div class="flex text-center pt-2 -pb-2">
                <p class="max-w-md text-lg font-medium">Last 30 Days Sales Comparison</p>
            </div>
            <div x-data="chartComp4()" x-init="renderChart4()" class="w-full max-w-lg p-2 bg-white shadow-lg rounded-lg m-4">
                <canvas id="myChart4"></canvas>
            </div>
        </div>
    </div>
    <div class="text-right w-full pl-4 pr-4">
  <button class="bg-gradient-to-b from-yellow-200 to-yellow-800 hover:bg-yellow-700 text-white font-bold h-14 py-2 px-8 rounded">
    Utilities
  </button>
   <button class="bg-gradient-to-b from-green-400 to-green-900  hover:bg-green-700 text-white font-bold h-14 py-2 px-8 rounded">
    <a href="<?= base_url('posmain/pos') ?>">Back To POS</a>
  </button>
</div>
 </div>

</body>
</html>