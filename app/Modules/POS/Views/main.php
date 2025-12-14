<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?= csrf_meta() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="<?=base_url()?>pos/css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/idb@8/build/umd.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />   
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?=base_url()?>pos/js/pos_script.js"></script>
    <script src="<?=base_url()?>pos/js/plugin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
  .select2-container .select2-selection {
    border-radius: 0.7rem; /* Example: applying a custom border-radius */
  }
</style>
</head>
<body class="bg-blue-gray-50" x-data="initApp()" x-init="initDatabase()">
  <div class="hide-print bg-gray-200 flex flex-col md:flex-row h-screen antialiased text-blue-gray-800">
        <div class="flex flex-row w-auto flex-shrink-0 pl-2 pr-2 py-2">
            <div class="flex flex-col items-center py-4 flex-shrink-0 w-20 bg-cyan-500 rounded-3xl">
                <a href="#" x-on:click=""
                    class="flex items-center justify-center h-12 w-12 bg-cyan-50 text-cyan-700 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="123.3" height="123.233" viewBox="0 0 32.623 32.605">
                    <path d="M15.612 0c-.36.003-.705.01-1.03.021C8.657.223 5.742 1.123 3.4 3.472.714 6.166-.145 9.758.019 17.607c.137 6.52.965 9.271 3.542 11.768 1.31 1.269 2.658 2 4.73 2.57.846.232 2.73.547 3.56.596.36.021 2.336.048 4.392.06 3.162.018 4.031-.016 5.63-.221 3.915-.504 6.43-1.778 8.234-4.173 1.806-2.396 2.514-5.731 2.516-11.846.001-4.407-.42-7.59-1.278-9.643-1.463-3.501-4.183-5.53-8.394-6.258-1.634-.283-4.823-.475-7.339-.46z" fill="#fff"/><path d="M16.202 13.758c-.056 0-.11 0-.16.003-.926.031-1.38.172-1.747.538-.42.421-.553.982-.528 2.208.022 1.018.151 1.447.553 1.837.205.198.415.313.739.402.132.036.426.085.556.093.056.003.365.007.686.009.494.003.63-.002.879-.035.611-.078 1.004-.277 1.286-.651.282-.374.392-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.147-.072zM16.22 19.926c-.056 0-.11 0-.16.003-.925.031-1.38.172-1.746.539-.42.42-.554.981-.528 2.207.02 1.018.15 1.448.553 1.838.204.198.415.312.738.4.132.037.426.086.556.094.056.003.365.007.686.009.494.003.63-.002.88-.034.61-.08 1.003-.278 1.285-.652.282-.374.393-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.863-1.31-.977a7.91 7.91 0 00-1.146-.072zM22.468 13.736c-.056 0-.11.001-.161.003-.925.032-1.38.172-1.746.54-.42.42-.554.98-.528 2.207.021 1.018.15 1.447.553 1.837.205.198.415.313.739.401.132.037.426.086.556.094.056.003.364.007.685.009.494.003.63-.002.88-.035.611-.078 1.004-.277 1.285-.651.282-.375.393-.895.393-1.85 0-.688-.065-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.146-.072z" fill="#00dace"/><path d="M9.937 13.736c-.056 0-.11.001-.161.003-.925.032-1.38.172-1.746.54-.42.42-.554.98-.528 2.207.021 1.018.15 1.447.553 1.837.204.198.415.313.738.401.133.037.427.086.556.094.056.003.365.007.686.009.494.003.63-.002.88-.035.61-.078 1.003-.277 1.285-.651.282-.375.393-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.146-.072zM16.202 7.59c-.056 0-.11 0-.16.002-.926.032-1.38.172-1.747.54-.42.42-.553.98-.528 2.206.022 1.019.151 1.448.553 1.838.205.198.415.312.739.401.132.037.426.086.556.093.056.003.365.007.686.01.494.002.63-.003.879-.035.611-.079 1.004-.278 1.286-.652.282-.374.392-.895.393-1.85 0-.688-.066-1.185-.2-1.505-.228-.547-.653-.864-1.31-.978a7.91 7.91 0 00-1.147-.071z" fill="#00bcd4"/><g><path d="M15.612 0c-.36.003-.705.01-1.03.021C8.657.223 5.742 1.123 3.4 3.472.714 6.166-.145 9.758.019 17.607c.137 6.52.965 9.271 3.542 11.768 1.31 1.269 2.658 2 4.73 2.57.846.232 2.73.547 3.56.596.36.021 2.336.048 4.392.06 3.162.018 4.031-.016 5.63-.221 3.915-.504 6.43-1.778 8.234-4.173 1.806-2.396 2.514-5.731 2.516-11.846.001-4.407-.42-7.59-1.278-9.643-1.463-3.501-4.183-5.53-8.394-6.258-1.634-.283-4.823-.475-7.339-.46z" fill="#fff"/><path d="M16.202 13.758c-.056 0-.11 0-.16.003-.926.031-1.38.172-1.747.538-.42.421-.553.982-.528 2.208.022 1.018.151 1.447.553 1.837.205.198.415.313.739.402.132.036.426.085.556.093.056.003.365.007.686.009.494.003.63-.002.879-.035.611-.078 1.004-.277 1.286-.651.282-.374.392-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.147-.072zM16.22 19.926c-.056 0-.11 0-.16.003-.925.031-1.38.172-1.746.539-.42.42-.554.981-.528 2.207.02 1.018.15 1.448.553 1.838.204.198.415.312.738.4.132.037.426.086.556.094.056.003.365.007.686.009.494.003.63-.002.88-.034.61-.08 1.003-.278 1.285-.652.282-.374.393-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.863-1.31-.977a7.91 7.91 0 00-1.146-.072zM22.468 13.736c-.056 0-.11.001-.161.003-.925.032-1.38.172-1.746.54-.42.42-.554.98-.528 2.207.021 1.018.15 1.447.553 1.837.205.198.415.313.739.401.132.037.426.086.556.094.056.003.364.007.685.009.494.003.63-.002.88-.035.611-.078 1.004-.277 1.285-.651.282-.375.393-.895.393-1.85 0-.688-.065-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.146-.072z" fill="#00dace"/><path d="M9.937 13.736c-.056 0-.11.001-.161.003-.925.032-1.38.172-1.746.54-.42.42-.554.98-.528 2.207.021 1.018.15 1.447.553 1.837.204.198.415.313.738.401.133.037.427.086.556.094.056.003.365.007.686.009.494.003.63-.002.88-.035.61-.078 1.003-.277 1.285-.651.282-.375.393-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.146-.072zM16.202 7.59c-.056 0-.11 0-.16.002-.926.032-1.38.172-1.747.54-.42.42-.553.98-.528 2.206.022 1.019.151 1.448.553 1.838.205.198.415.312.739.401.132.037.426.086.556.093.056.003.365.007.686.01.494.002.63-.003.879-.035.611-.079 1.004-.278 1.286-.652.282-.374.392-.895.393-1.85 0-.688-.066-1.185-.2-1.505-.228-.547-.653-.864-1.31-.978a7.91 7.91 0 00-1.147-.071z" fill="#00bcd4"/></g>
                    </svg>
                </a>
                <ul class="flex flex-col space-y-2 mt-12">
                    <li>
                        <a href="#" x-on:click = "chooseMenu('table')"
                            class="flex items-center" title="Point Of Sale (Register)">
                            <span
                            class="flex items-center justify-center h-12 w-12 rounded-2xl"
                            x-bind:class="{
                                'hover:bg-cyan-400 text-cyan-100': activeMenu !== 'table',
                                'bg-cyan-300 shadow-lg text-white': activeMenu === 'table',
                            }">
                            <svg fill="#ffffff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 40 44" xml:space="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M42.558,23.378l2.406-10.92c0.18-0.816-0.336-1.624-1.152-1.803c-0.816-0.182-1.623,0.335-1.802,1.151l-2.145,9.733 h-9.647c-0.835,0-1.512,0.677-1.512,1.513c0,0.836,0.677,1.513,1.512,1.513h0.573l-3.258,7.713 c-0.325,0.771,0.034,1.657,0.805,1.982c0.19,0.081,0.392,0.12,0.588,0.12c0.59,0,1.15-0.348,1.394-0.925l2.974-7.038l4.717,0.001 l2.971,7.037c0.327,0.77,1.215,1.127,1.982,0.805c0.77-0.325,1.13-1.212,0.805-1.982l-3.257-7.713h0.573 C41.791,24.564,42.403,24.072,42.558,23.378z"></path> <path d="M14.208,24.564h0.573c0.835,0,1.512-0.677,1.512-1.513c0-0.836-0.677-1.513-1.512-1.513H5.134L2.99,11.806 C2.809,10.99,2,10.472,1.188,10.655c-0.815,0.179-1.332,0.987-1.152,1.803l2.406,10.92c0.153,0.693,0.767,1.187,1.477,1.187h0.573 L1.234,32.28c-0.325,0.77,0.035,1.655,0.805,1.98c0.768,0.324,1.656-0.036,1.982-0.805l2.971-7.037l4.717-0.001l2.972,7.038 c0.244,0.577,0.804,0.925,1.394,0.925c0.196,0,0.396-0.039,0.588-0.12c0.77-0.325,1.13-1.212,0.805-1.98L14.208,24.564z"></path> <path d="M24.862,31.353h-0.852V18.308h8.13c0.835,0,1.513-0.677,1.513-1.512s-0.678-1.513-1.513-1.513H12.856 c-0.835,0-1.513,0.678-1.513,1.513c0,0.834,0.678,1.512,1.513,1.512h8.13v13.045h-0.852c-0.835,0-1.512,0.679-1.512,1.514 s0.677,1.513,1.512,1.513h4.728c0.837,0,1.514-0.678,1.514-1.513S25.699,31.353,24.862,31.353z"></path> </g> </g> </g></svg>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="#" x-on:click = "chooseMenu('pos')" class="flex items-center" 
                        title="Point Of Sale (Register)">
                        <span
                            class="flex items-center justify-center h-12 w-12 rounded-2xl"
                            x-bind:class="{
                                'hover:bg-cyan-400 text-cyan-100': activeMenu !== 'pos',
                                'bg-cyan-300 shadow-lg text-white': activeMenu === 'pos',
                            }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        </span>
                        </a>
                    </li>
                </ul>
                <a href="#" x-on:click = "" class="mt-auto flex items-center justify-center text-cyan-200 hover:text-cyan-100 h-10 w-10 focus:outline-none">
                    <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> 
                        <path d="M4 21C4 17.4735 6.60771 14.5561 10 14.0709M19.8726 15.2038C19.8044 15.2079 19.7357 15.21 19.6667 15.21C18.6422 15.21 17.7077 14.7524 17 14C16.2923 14.7524 15.3578 15.2099 14.3333 15.2099C14.2643 15.2099 14.1956 15.2078 14.1274 15.2037C14.0442 15.5853 14 15.9855 14 16.3979C14 18.6121 15.2748 20.4725 17 21C18.7252 20.4725 20 18.6121 20 16.3979C20 15.9855 19.9558 15.5853 19.8726 15.2038ZM15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7Z" stroke="#ffffff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </g>
                    </svg>
                </a>
            </div>
        </div>
        <div x-show="activeMenu==='table'" class="min-h-screen w-screen grid grid-cols-6 pl-2 pr-2 py-2 gap-2">
            <div class="flex-grow overflow-y-auto thin-scrollbar bg-white col-span-6 p-2 -ml-2 rounded-2xl">
                <div class="flex antialiased">
                <div class="w-1/4 h-full px-4 pb-4 pl-4 pr-4 overflow-auto">
                    <div class="text-center mb-12">
                        <h2 class="text-xl font-semibold bg-teal-400 text-white rounded-2xl pt-4 pb-4" x-text="store===null?'StoreName':store.name"></h2>
                        <div x-data="{ time: '', date: '', week: ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'], 
                                        startClock() {
                                            setInterval(() => {
                                                this.updateClock();
                                            }, 1000);
                                        },
                                        updateClock() {
                                            let newDate = new Date();
                                            this.time = this.padNum(newDate.getHours(), 2) + ':' + 
                                                        this.padNum(newDate.getMinutes(), 2) + ':' + 
                                                        this.padNum(newDate.getSeconds(), 2);
                                            this.date = this.padNum(newDate.getFullYear(), 4) + '-' + 
                                                        this.padNum(newDate.getMonth() + 1, 2) + '-' + 
                                                        this.padNum(newDate.getDate(), 2) + ' | ' + 
                                                        this.week[newDate.getDay()];
                                        },
                                        padNum(num, digit) {
                                            let zero = '';
                                            for (let i = 0; i < digit; i++) {
                                                zero += '0';
                                            }
                                            return (zero + num).slice(-digit);
                                        }
                                    }" x-init="updateClock(); startClock()">
                            <h1 class="text-lg font-bold" x-text="time"></h1>
                            <p class="text-base font-medium" x-text="date"></p>
                        </div>
                    </div>
                    <div x-show="allArea().length" class="overflow-x-auto whitespace-nowrap mb-5 thin-scrollbar">
                        <div role="button"
                            class="rounded-xl shadow-lg bg-cyan-200 py-4 mb-5 hover:bg-cyan-400 hover:text-white focus:outline-none text-base"
                            x-on:click="addAreaTable(this,'all')">
                        <div class="flex px-5 items-center justify-center ">
                            <p class="nowrap font-semibold">All</p>
                        </div>
                        </div>

                        <template x-for="area in allArea()" :key="area.id">
                            <div role="button"
                            :class="keywordArea==area.id?'bg-pink-400 rounded-xl shadow-lg py-4 mb-5 hover:bg-cyan-400 hover:text-white focus:outline-none text-white':'rounded-xl shadow-lg bg-cyan-200 py-4 mb-5 hover:bg-cyan-400 hover:text-white focus:outline-none text-gray'"
                            :title="area.description"
                            x-on:click="addAreaTable(this,area)">
                            <div class="flex px-5 items-center justify-center ">
                            <p class="nowrap font-semibold" x-text="area.description"></p>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="w-3/4 h-screen pt-4 pb-4 pl-4 pr-4 bg-gray-200 shadow-lg rounded-lg overflow-auto">
                    <div x-show="filteredTables().length" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-4 gap-4">
                        <template x-for="tbl in filteredTables()" :key="tbl.id">
                        <div role="button"
                            :class="tbl.sales!==null?'rounded-xl shadow-lg bg-pink-200 py-2 mb-3 hover:bg-pink-400 hover:text-white focus:outline-none':
                            'rounded-xl shadow-lg bg-cyan-200 py-2 mb-3 hover:bg-cyan-400 hover:text-white focus:outline-none'"
                            :title="tbl.description"
                            x-on:click="chooseTable(this,tbl)">
                            <div class="flex justify-between items-center font-semibold">
                                <div class="flex text-left pl-2">
                                    <p class="nowrap text-lg font-medium" x-text="tbl.description"></p>
                                </div>
                                <div class="flex text-right pr-2">
                                    <p class="nowrap text-base" x-text="tbl.sales!==null?getTimer(tbl.pos_transaction.start):'00:00'"></p>
                                </div>
                            </div>
                            <div class="flex justify-center font-semibold mt-4">
                                <div class="flex items-center">
                                    <p class="nowrap text-lg" x-text="tbl.sales!==null?tbl.reservation_name:'Free'"></p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center font-semibold mt-4">
                                <div class="flex text-left pl-2">
                                    <p class="nowrap text-base">I: </p>
                                    <p class="nowrap text-base"></p>
                                </div>
                                <div class="flex text-right pr-2">
                                    <p class="nowrap text-base">T: </p>
                                    <p class="nowrap text-base" x-text="tbl.sales!==null?priceFormat(tbl.sales.total_before_tax):'0'">Rp. 3.000.000</p>
                                </div>
                            </div>          
                        </template>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div x-show="activeMenu==='pos'" class="min-h-screen w-screen grid grid-cols-6 pl-2 pr-2 py-2 gap-2">
            <!-- start Col 1 -->
            <div class="flex-grow overflow-y-auto thin-scrollbar bg-white col-span-3 p-2 -ml-2 rounded-2xl">
                <!-- start header Menu Content -->
                <div class="flex-grow overflow-y-auto">
                    <div class="flex flex-row">
                        <div class="w-full basis-2/3 relative p-2 ">
                            <div class="absolute left-5 top-5 px-2 py-2 rounded-full bg-cyan-500 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input 
                                type="text"
                                class="bg-white rounded-2xl shadow-md text-lg full w-full h-12 py-4 pl-16 transition-shadow focus:shadow-xl focus:outline-none"
                                placeholder="Cari menu ..."
                                x-model="keyword"
                            /> 
                        </div>
                        <div class="w-full basis-1/3 p-2">
                            <div class="flex-grow py-2">
                                <p class="bg-cyan-300 rounded-xl p-2 font-bold text-lg text-center text-white" x-text="store===null?'storeName':store.name"></p>
                            </div>
                        </div>
                        <div class="basis-1/3 p-2">
                            <div class="flex justify-end py-2">
                            <button class="bg-white border border-gray-300  hover:bg-cyan-300 shadow-lg rounded-xl w-32 h-full text-pink-500 text-lg p-2 mr-1"><i class="fas fa-percentage mr-1"></i> Promo</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end header Menu Content -->
                <!-- start Col Menu Content -->
                <div class="overflow-hidden mt-2">
                    <!-- gap col Menu Content -->
                    <div class="h-full overflow-y-auto px-2">
                        <div class="select-none bg-blue-gray-100 rounded-3xl flex flex-wrap content-center justify-center h-full opacity-25"
                        x-show="foodMenu.length === 0">
                        <div class="w-full text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                            </svg>
                            <p class="text-xl">
                            YOU DON'T HAVE
                            <br/>
                            ANY PRODUCTS TO SHOW
                            </p>
                        </div>
                        </div>
                        <div class="select-none bg-blue-gray-100 rounded-3xl flex flex-wrap content-center justify-center h-full opacity-25"
                        x-show="filteredFoodMenu().length === 0 && keyword.length > 0">
                            <div class="w-full text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <p class="text-xl">
                                EMPTY SEARCH RESULT
                                <br/>
                                "<span x-text="keyword" class="font-semibold"></span>"
                                </p>
                            </div>
                        </div>
                        <!-- start Group Menu -->
                        <div x-show="allCategory().length" class="overflow-x-auto whitespace-nowrap mb-3 thin-scrollbar">
                            <div role="button" 
                            class="select-none inline-block select-none cursor-pointer transition-shadow overflow-hidden rounded-xl bg-white shadow hover:shadow-lg p-1 hover:bg-blue-100 active [&.active]:bg-blue-400"
                            x-on:click="chooseCat(this,'all')">
                                <div class="flex px-3 text-md">
                                <p class="nowrap font-semibold">All</p>
                                </div>
                            </div>
                            <template x-for="cat in allCategory()" :key="cat.id">
                                <div role="button" 
                                :class="keywordCat==cat.id?'bg-pink-400 text-white select-none inline-block select-none cursor-pointer transition-shadow overflow-hidden rounded-xl bg-white shadow hover:shadow-lg p-1':'select-none inline-block select-none cursor-pointer transition-shadow overflow-hidden rounded-xl bg-white shadow hover:shadow-lg p-1 hover'"
                                :title="cat.description"
                                x-on:click="chooseCat(this,cat)">
                                    <div class="flex px-3 text-md">
                                    <p class="nowrap font-semibold" x-text="cat.label_name"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <!-- end Group Menu -->
                        <!--start Item product-->
                        <div x-show="filteredFoodMenu().length" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4">
                        <template x-for="foodmenu in filteredFoodMenu()" :key="foodmenu.id">
                            <div
                            role="button"
                            class="select-none cursor-pointer transition-shadow overflow-hidden rounded-2xl bg-white border border-gray-300 shadow-xl hover:shadow-lg"
                            :title="foodmenu.name"
                            x-on:click="chooseFoodMenu(this,foodmenu)">
                            <img :src="foodmenu.picture===null?'/uploads/1761367532_98507131f206a75fa24d.jpg':foodmenu.picture" :alt="foodmenu.name" class="w-52 h-40">
                            <div class="pb-3 px-3 text-sm -mt-3 label_product">
                                <p class="flex truncate mr-1 description" x-text="foodmenu.name"></p>
                                <p class="flex font-semibold price" x-text="priceFormat(foodmenu.sell_price)"></p>
                            </div>
                            </div>
                        </template>
                        </div>
                        <!--end Item product-->
                    </div>
                    <!-- end gap col Menu Product -->
                </div>

            </div>
            <!-- end Col 1 -->

            <!-- sart Col 1 -->
            <div class="flex-grow overflow-y-auto bg-gray-100 col-span-2 p-2 rounded-2xl">
                <div class="flex flex-col h-full pr-2 pl-2">
                    <div class="bg-white rounded-2xl flex flex-col h-full shadow">
                        <div x-show="cart.length === 0" class="flex-1 w-full p-4 opacity-25 select-none flex flex-col flex-wrap content-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p>
                                CART EMPTY
                            </p>
                        </div>
                        <!-- cart items -->
                        <div x-show="cart.length > 0" class="h-28 flex-1 flex flex-col overflow-auto">
                            <div class="h-16 text-center flex justify-center">
                                <div class="pl-8 text-left text-lg py-4 relative">
                                    <!-- cart icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <div x-show="getItemsCount() > 0" class="text-center absolute bg-cyan-400 text-white w-5 h-5 text-xs p-0 leading-5 rounded-full -right-2 top-3" x-text="getItemsCount()"></div>
                                </div>
                                <div class="flex-grow px-8 text-right text-lg py-4 relative">
                                    <!-- trash button -->
                                    <button x-on:click="clear()" class="text-blue-gray-300 hover:text-pink-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex-1 w-full px-4 overflow-auto">
                                <template x-for="item in cart" :key="item.foodMenuId">
                                    <div class="select-none mb-3 bg-blue-gray-50 rounded-lg w-full text-blue-gray-700 py-2 px-2 flex justify-center">
                                    <img :src="item.image===null?'/uploads/1761367532_98507131f206a75fa24d.jpg':item.image" alt="" class="rounded-lg h-10 w-10 bg-white shadow mr-2">
                                    <div class="flex-grow">
                                        <h5 class="text-sm" x-text="item.name"></h5>
                                        <p class="text-xs block" x-text="priceFormat(item.price)"></p>
                                    </div>
                                    <div class="py-1">
                                        <div class="w-28 grid grid-cols-3 gap-2 ml-2">
                                        <button x-on:click="addQty(item, -1)" class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-3 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <input x-model.number="item.qty" type="text" class="bg-white rounded-lg text-center shadow focus:outline-none focus:shadow-lg text-sm">
                                        <button x-on:click="addQty(item, 1)" class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-3 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </button>
                                        </div>
                                    </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <!-- end of cart items -->
                        <!-- info -->
                        <div class="h-auto bg-white col-span-3 p-2 ml-2 mr-2 border border-gray-300 rounded-xl shadow-xl">
                            <div class="flex justify-between items-center w-full">
                                <div class="grow text-left ml-4 my-2">
                                <p class="text-base font-medium">Table</p>    
                                </div>
                                <div class="flex-none text-right mr-2">
                                    <p class="p-2 text-base font-medium" x-text="pilih_table.name"></p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center w-full">
                                <div class="grow text-left ml-4 my-2">
                                <p class="text-base font-medium">Customer</p>    
                                </div>
                                <div class="flex-none text-right mr-2">
                                    <p class="p-2 text-base font-medium rounded-xl shadow-xl border border-gray-300 cursor-pointer" x-on:click="openModalMember()" x-text="Object.keys(member).length === 0?'Choose Customer':member.fullname">Customer Name</p>
                                </div>
                            </div>
                        </div>
                        <!-- end info-->
                        <!-- Payment Info -->
                        <div class="select-none h-auto w-full text-center pt-3 pb-4 px-4">
                            <div class="flex mb-3 text-lg font-semibold text-blue-gray-700">
                                <div>SubTotal</div>
                                <div class="text-right w-full" x-text="priceFormat(subTotal)"></div>
                            </div>
                        </div>
                        <div x-show="change == 0 && cart.length > 0"
                        class="flex justify-center mb-3 text-lg font-semibold bg-cyan-50 text-cyan-700 rounded-lg py-2 px-3"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                            </svg>
                        </div>
                        <button x-show="take_away=='1'"
                            class="text-white rounded-2xl text-lg w-full py-3 focus:outline-none"
                            x-bind:class="{
                                'bg-cyan-500 hover:bg-cyan-600': submitable(),
                                'bg-blue-gray-200': !submitable()
                            }"
                            :disabled="!submitable()"
                            x-on:click="submit()">Pay
                        </button>
                        <button x-show="take_away=='0'"
                            class="text-white rounded-2xl text-lg w-full py-3 focus:outline-none"
                            x-bind:class="{
                                'bg-cyan-500 hover:bg-cyan-600': submitable(),
                                'bg-blue-gray-200': !submitable()
                            }"
                            :disabled="!submitable()"
                            x-on:click="submitHoldOrdPay()">Submit
                        </button>
                    </div>
                    <!-- end Payment Info -->
                         
                    </div>
                </div>    
            </div>
            <!-- end Col 2 -->
             
            
        </div>
        <div x-show="firstBalance" 
            class="fixed w-full h-screen left-0 top-0 z-10 flex flex-wrap justify-center content-center p-24" x-cloak>
            <div
                x-show="firstBalance"
                class="fixed glass w-full h-screen left-0 top-0 z-0" x-on:click="closeModalBalance()"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            ></div>
            <div
                x-show="firstBalance"
                class="w-2/5 rounded-3xl bg-white shadow-xl overflow-hidden z-10"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90">
                <div id="display" class="text-left w-full text-sm p-6 overflow-auto">
                    <div class="text-center">
                        <img src="<?=base_url()?>pos/img/receipt-logo.png" alt="Zax Resto" class="mb-3 w-8 h-8 inline-block">
                    <h3 class="text-center text-2xl mb-4">Opening Balance</h3>
                    </div>
                    <hr class="my-2">
                    <div class="flex antialiased w-full">
                        <div class="px-2 pb-2 pl-2 pr-2 overflow-auto justify-center">
                            <h3 class="text-left text-sm mb-2 text-gray-600 font-semibold">Choose Store : </h3>
                            <div class="flex justify-left items-center mb-4">
                                <select class="choose_branch w-screen" id="choose_branch" x-show="openingStoreList().length" x-on:change="chooseStore($event.target.value)">
                                    <option></option>    
                                    <template x-for="item in openingStoreList()" :key="item.id">
                                        <option :value="item.id" x-text="item.description">
                                        </option>
                                    </template>
                                </select>
                            </div>
                            <h3 class="text-left text-sm mb-2 text-gray-600 font-semibold">Choose Shift : </h3>
                            <div class="flex justify-left items-center mb-4">
                                <select class="choose_shift w-screen" id="choose_shift" name="shift" x-on:change="chooseShift($event.target.value)">
                                    <option></option>
                                    <option value="1">Shift 1</option>
                                    <option value="2">Shift 2</option>
                                    <option value="3">Shift 3</option>
                                </select>
                            </div>
                            <h3 class="text-left text-sm mb-2 text-gray-600 font-semibold">Amount Balance : </h3>
                            <div class="flex justify-center items-center mb-4">
                                <div class="flex w-full">
                                    <div class="mr-2 p-2">Rp</div>
                                    <input x-bind:value="numberFormat(params_balance)" x-on:keyup="setOpeningBalance($event.target.value)" type="text" class="w-full text-left bg-gray-50 shadow rounded-lg focus:bg-gray-100 focus:shadow-lg px-2 focus:outline-none p-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4 w-full">
                <button x-on:click="submitOpeningStore()" class="bg-cyan-400 text-white text-lg px-4 py-3 rounded-2xl w-full focus:outline-none">Submit</button>
                </div>
            </div>
        </div>
        <div x-show="existShift" 
            class="fixed glass w-full h-screen left-0 top-0 z-10 flex flex-wrap justify-center content-center p-24" x-cloak>
        <div class="w-96 rounded-3xl p-8 bg-white shadow-xl">
            <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="123.3" height="123.233" viewBox="0 0 32.623 32.605">
                <path d="M15.612 0c-.36.003-.705.01-1.03.021C8.657.223 5.742 1.123 3.4 3.472.714 6.166-.145 9.758.019 17.607c.137 6.52.965 9.271 3.542 11.768 1.31 1.269 2.658 2 4.73 2.57.846.232 2.73.547 3.56.596.36.021 2.336.048 4.392.06 3.162.018 4.031-.016 5.63-.221 3.915-.504 6.43-1.778 8.234-4.173 1.806-2.396 2.514-5.731 2.516-11.846.001-4.407-.42-7.59-1.278-9.643-1.463-3.501-4.183-5.53-8.394-6.258-1.634-.283-4.823-.475-7.339-.46z" fill="#fff"/><path d="M16.202 13.758c-.056 0-.11 0-.16.003-.926.031-1.38.172-1.747.538-.42.421-.553.982-.528 2.208.022 1.018.151 1.447.553 1.837.205.198.415.313.739.402.132.036.426.085.556.093.056.003.365.007.686.009.494.003.63-.002.879-.035.611-.078 1.004-.277 1.286-.651.282-.374.392-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.147-.072zM16.22 19.926c-.056 0-.11 0-.16.003-.925.031-1.38.172-1.746.539-.42.42-.554.981-.528 2.207.02 1.018.15 1.448.553 1.838.204.198.415.312.738.4.132.037.426.086.556.094.056.003.365.007.686.009.494.003.63-.002.88-.034.61-.08 1.003-.278 1.285-.652.282-.374.393-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.863-1.31-.977a7.91 7.91 0 00-1.146-.072zM22.468 13.736c-.056 0-.11.001-.161.003-.925.032-1.38.172-1.746.54-.42.42-.554.98-.528 2.207.021 1.018.15 1.447.553 1.837.205.198.415.313.739.401.132.037.426.086.556.094.056.003.364.007.685.009.494.003.63-.002.88-.035.611-.078 1.004-.277 1.285-.651.282-.375.393-.895.393-1.85 0-.688-.065-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.146-.072z" fill="#00dace"/><path d="M9.937 13.736c-.056 0-.11.001-.161.003-.925.032-1.38.172-1.746.54-.42.42-.554.98-.528 2.207.021 1.018.15 1.447.553 1.837.204.198.415.313.738.401.133.037.427.086.556.094.056.003.365.007.686.009.494.003.63-.002.88-.035.61-.078 1.003-.277 1.285-.651.282-.375.393-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.146-.072zM16.202 7.59c-.056 0-.11 0-.16.002-.926.032-1.38.172-1.747.54-.42.42-.553.98-.528 2.206.022 1.019.151 1.448.553 1.838.205.198.415.312.739.401.132.037.426.086.556.093.056.003.365.007.686.01.494.002.63-.003.879-.035.611-.079 1.004-.278 1.286-.652.282-.374.392-.895.393-1.85 0-.688-.066-1.185-.2-1.505-.228-.547-.653-.864-1.31-.978a7.91 7.91 0 00-1.147-.071z" fill="#00bcd4"/><g><path d="M15.612 0c-.36.003-.705.01-1.03.021C8.657.223 5.742 1.123 3.4 3.472.714 6.166-.145 9.758.019 17.607c.137 6.52.965 9.271 3.542 11.768 1.31 1.269 2.658 2 4.73 2.57.846.232 2.73.547 3.56.596.36.021 2.336.048 4.392.06 3.162.018 4.031-.016 5.63-.221 3.915-.504 6.43-1.778 8.234-4.173 1.806-2.396 2.514-5.731 2.516-11.846.001-4.407-.42-7.59-1.278-9.643-1.463-3.501-4.183-5.53-8.394-6.258-1.634-.283-4.823-.475-7.339-.46z" fill="#fff"/><path d="M16.202 13.758c-.056 0-.11 0-.16.003-.926.031-1.38.172-1.747.538-.42.421-.553.982-.528 2.208.022 1.018.151 1.447.553 1.837.205.198.415.313.739.402.132.036.426.085.556.093.056.003.365.007.686.009.494.003.63-.002.879-.035.611-.078 1.004-.277 1.286-.651.282-.374.392-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.147-.072zM16.22 19.926c-.056 0-.11 0-.16.003-.925.031-1.38.172-1.746.539-.42.42-.554.981-.528 2.207.02 1.018.15 1.448.553 1.838.204.198.415.312.738.4.132.037.426.086.556.094.056.003.365.007.686.009.494.003.63-.002.88-.034.61-.08 1.003-.278 1.285-.652.282-.374.393-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.863-1.31-.977a7.91 7.91 0 00-1.146-.072zM22.468 13.736c-.056 0-.11.001-.161.003-.925.032-1.38.172-1.746.54-.42.42-.554.98-.528 2.207.021 1.018.15 1.447.553 1.837.205.198.415.313.739.401.132.037.426.086.556.094.056.003.364.007.685.009.494.003.63-.002.88-.035.611-.078 1.004-.277 1.285-.651.282-.375.393-.895.393-1.85 0-.688-.065-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.146-.072z" fill="#00dace"/><path d="M9.937 13.736c-.056 0-.11.001-.161.003-.925.032-1.38.172-1.746.54-.42.42-.554.98-.528 2.207.021 1.018.15 1.447.553 1.837.204.198.415.313.738.401.133.037.427.086.556.094.056.003.365.007.686.009.494.003.63-.002.88-.035.61-.078 1.003-.277 1.285-.651.282-.375.393-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.146-.072zM16.202 7.59c-.056 0-.11 0-.16.002-.926.032-1.38.172-1.747.54-.42.42-.553.98-.528 2.206.022 1.019.151 1.448.553 1.838.205.198.415.312.739.401.132.037.426.086.556.093.056.003.365.007.686.01.494.002.63-.003.879-.035.611-.079 1.004-.278 1.286-.652.282-.374.392-.895.393-1.85 0-.688-.066-1.185-.2-1.505-.228-.547-.653-.864-1.31-.978a7.91 7.91 0 00-1.147-.071z" fill="#00bcd4"/></g>
            </svg>
                <h3 class="text-center text-xl mb-2">Data Shift anda masih terbuka</h3>
                <h3 class="text-center text-sm mb-8">Silahkan melanjutkan atau tutup terlebih dahulu.!</h3>
            </div>
            <div class="w-full flex justify-between items-center text-lg font-semibold">
                <div class="w-1/6 flex-grow text-left">
                <h3 class="text-left text-sm mb-2">Name</h3>
                </div>
                <div class="w-5/6 flex text-right">
                    <div class="text-sm ml-2 mr-2 mb-2" x-text="Object.keys(exist_user).length === 0?'user':exist_user.fullname"></div>
                </div>
            </div>
            <div class="w-full flex justify-between items-center text-lg font-semibold">
                <div class="w-1/6 flex-grow text-left">
                <h3 class="text-left text-sm mb-2">Store</h3>
                </div>
                <div class="w-5/6 flex text-right">
                    <div class="text-sm ml-2 mr-2 mb-2" x-text="Object.keys(exist_store).length === 0?'store':exist_store.description"></div>
                </div>
            </div>
            <div class="w-full flex justify-between items-center text-lg font-semibold">
                <div class="w-1/6 flex-grow text-left">
                <h3 class="text-left text-sm mb-2">Shift</h3>
                </div>
                <div class="w-5/6 flex text-right">
                    <div class="text-sm ml-2 mr-2 mb-2" x-text="exist_shift === 0?'shift':exist_shift"></div>
                </div>
            </div>
            <div class="w-full flex justify-between items-center text-lg font-semibold">
                <div class="w-1/6 flex-grow text-left">
                <h3 class="text-left text-sm mb-2">Time</h3>
                </div>
                <div class="w-5/6 flex text-right">
                    <div class="text-sm ml-2 mr-2 mb-2" x-text="exist_startTime === null?'startTime':exist_startTime"></div>
                </div>
            </div>
            <div class="text-center justify-center">
            <button x-on:click="running_pos()" class="text-left w-full mb-3 rounded-xl bg-blue-gray-500 text-white text-center focus:outline-none hover:bg-cyan-400 px-4 py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block -mt-1 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                </svg>
                Lanjutkan
            </button>
            </div>
        </div>
        </div>
        <div x-show="isShowHoldAndPay"
            class="fixed w-full h-screen left-0 top-0 z-10 flex flex-wrap justify-center content-center p-24" x-cloak>
            <div x-show="isShowHoldAndPay"
                class="fixed glass w-full h-screen left-0 top-0 z-0" x-on:click="closeModalReceipt()"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            ></div>
            <div
                x-show="isShowHoldAndPay"
                class="w-96 rounded-3xl bg-white shadow-xl overflow-hidden z-10"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
            >
                <div id="receipt-content" class="text-left w-full text-sm p-6 overflow-auto">
                    <div class="text-center">
                        <img src="" class="mb-3 w-8 h-8 inline-block">
                        <h2 class="text-xl font-semibold" x-text="business.display_name"></h2>
                        <p x-text="store.display_name"></p>
                    </div>
                    <div class="flex mt-4 text-xs">
                        <div class="flex-grow">Cashier: <span x-text="user.fullname"></span></div>
                    <div x-text="receiptDate"></div>
                    </div>
                    <div class="flex mt-1 text-xs">
                        <div class="flex-grow">No: <span x-text="receiptNo"></span></div>
                        <div class="text-right">Customer: <span x-text="member.fullname=='General'?'General':member.fullname"></span></div>
                </div>
                <hr class="my-2">
                <div>
                    <table class="w-full text-xs">
                    <thead>
                        <tr>
                        <th class="py-1 w-1/12 text-center">#</th>
                        <th class="py-1 text-left">Item</th>
                        <th class="py-1 w-2/12 text-center">Qty</th>
                        <th class="py-1 w-3/12 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in cart" :key="item">
                            <tr>
                            <td class="py-2 text-center" x-text="index+1"></td>
                            <td class="py-2 text-left">
                            <span x-text="item.name"></span>
                            <br/>
                            <small x-text="priceFormat(item.price)"></small>
                            </td>
                            <td class="py-2 text-center" x-text="item.qty"></td>
                            <td class="py-2 text-right" x-text="priceFormat(item.qty * item.price)"></td>
                        </tr>
                        </template>
                    </tbody>
                    </table>
                </div>
                <hr class="my-2">
                <div>
                    <div class="flex font-semibold">
                    <div class="flex-grow">SubTotal</div>
                    <div x-text="priceFormat(subTotal)"></div>
                    </div>
                    <div class="flex font-semibold">
                    <div class="flex-grow">Disc %</div>
                    <div x-text="priceFormat(disc)"></div>
                    </div>
                    <div class="flex font-semibold">
                    <div class="flex-grow">TOTAL</div>
                    <div x-text="priceFormat(getTotalPrice())"></div>
                    </div>
                    <div class="flex text-xs font-semibold">
                    <div class="flex-grow">PAY AMOUNT</div>
                    <div x-text="priceFormat(cash)"></div>
                    </div>
                    <hr class="my-2">
                    <div class="flex text-xs font-semibold">
                    <div class="flex-grow">CHANGE</div>
                    <div x-text="priceFormat(change)"></div>
                    </div>
                </div>
                </div>
                <div class="flex p-4 gap-2 w-full">
                <button class=" flex-grow bg-pink-400 text-white text-lg px-4 py-3 rounded-2xl w-full focus:outline-none" x-on:click="submitToPayForm()">PAY</button>
                <button class="bg-cyan-500 text-white text-lg px-4 py-3 rounded-2xl w-full focus:outline-none" x-on:click="">HOLD</button>
                </div>
                <div class="p-4 gap-2 w-full">
                <button class=" bg-gray-200 text-gray-400 text-lg px-4 py-3 rounded-2xl w-full focus:outline-none" x-on:click="closeHPForm()">Close</button>
                </div>
            </div>
        </div>
        <div x-show="isShowPayForm"
            class="fixed w-full h-screen left-0 top-0 z-10 flex flex-wrap justify-center content-center p-24" x-cloak>
            <div
                x-show="isShowPayForm"
                class="fixed glass w-full h-screen left-0 top-0 z-0" x-on:click="closeModalPayMethod()"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            ></div>
            <div
                x-show="isShowPayForm"
                class="w-2/5 rounded-3xl bg-white shadow-xl overflow-hidden z-10"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
            >
                <div id="display" class="text-left w-full text-sm p-6 overflow-auto">
                    <div class="text-center">
                        <img src="img/receipt-logo.png" alt="Zax Resto" class="mb-3 w-8 h-8 inline-block">
                    <h3 class="text-center text-2xl mb-4">Payment</h3>
                    </div>
                    <hr class="my-2">
                    <div class="flex flex-col antialiased">
                        <div class="flex justify-center">
                                <div class="flex pl-2 mt-4">
                                    <select class="choose_paymethod w-56" id="choose_paymethod" name="pay_method" x-on:change="choosePaymentMethod($event.target.value)">
                                        <option></option>
                                        <option value="cash">Cash</option>
                                        <option value="debit">Debit</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div x-show="payMethod==='cash'" class="grid grid-cols-3 gap-2 mt-2">
                        <template x-for="money in moneys">
                        <button x-on:click="addCash(money)" class="bg-white rounded-lg shadow hover:shadow-lg focus:outline-none inline-block px-2 py-1 text-base font-medium">+<span x-text="numberFormat(money)"></span></button>
                        </template>
                    </div>
                    <div x-show="payMethod==='debit'" class="grid grid-cols-2 gap-2 mt-4 text-base">
                        <div class="flex">
                            <select class="choose_bank_2 w-48 px-2 mt-2" id="choose_bank_2" name="bank_account" x-on:change="chooseBank($event.target.value)">
                                <option></option>
                                <option value="bca">BCA</option>
                                <option value="mandiri">Mandiri</option>
                                <option value="bni">BNI</option>
                                <option value="bri">BRI</option>
                                <option value="cimb">CIMB Niaga</option>
                                <option value="permata">Permata</option>
                                <option value="mega">Mega</option>
                                
                            </select>
                        </div>
                        <input type="text" placeholder="Transaction Number" x-on:keyup="setTransactionNumber($event.target.value)" class="h-10 bg-white rounded-lg shadow hover:shadow-lg focus:outline-none inline-block px-2 py-1 text-base font-medium">
                    </div>
                    <div x-show="payMethod==='bank_transfer'" class="grid grid-cols-2 gap-2 mt-4 text-base">
                        <input type="text" placeholder="Account Name" x-on:keyup="setAccountName($event.target.value)" class="h-10 bg-white rounded-lg shadow hover:shadow-lg focus:outline-none inline-block px-2 py-1 text-base font-medium">
                        <input type="text" placeholder="Account Number"x-on:keyup="setAccountNumber($event.target.value)" class="h-10 bg-white rounded-lg shadow hover:shadow-lg focus:outline-none inline-block px-2 py-1 text-base font-medium">
                         <div class="flex">
                            <select class="choose_bank w-48 px-2" id="choose_bank" name="bank_account" x-on:change="chooseBank($event.target.value)">
                                <option></option>
                                <option value="bca">BCA</option>
                                <option value="mandiri">Mandiri</option>
                                <option value="bni">BNI</option>
                                <option value="bri">BRI</option>
                                <option value="cimb">CIMB Niaga</option>
                                <option value="permata">Permata</option>
                                <option value="mega">Mega</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex mt-4 justify-between items-center text-lg font-semibold">
                        <div class="flex-grow text-left">
                            <p>Amount</p>
                        </div>
                        <div class="flex text-right">
                            <div class="mr-2">Rp</div>
                            <input x-bind:value="numberFormat(cash)" x-on:keyup="updateCash($event.target.value)" type="text" class="w-28 text-right bg-white shadow rounded-lg focus:bg-white focus:shadow-lg px-2 focus:outline-none">
                        </div>
                    </div>
                    <div class="flex mt-4 justify-between items-center text-lg font-semibold">
                        <div class="flex-grow text-left">
                            <p>SubTotal</p>
                        </div>
                        <div class="flex text-right">
                            <div
                                :class="(cash<subTotal || cash == 0)?'text-right flex-grow text-pink-500':'text-right flex-grow text-cyan-500'"
                                x-text="priceFormat(subTotal)">
                            </div>
                        </div>
                    </div>
                    <div class="flex mt-4 justify-between items-center text-lg font-semibold">
                        <div class="flex-grow text-left">
                            <p>Changes</p>
                        </div>
                        <div class="flex text-right">
                            <div
                                class="text-right flex-grow text-cyan-600"
                                x-text="priceFormat(change)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4 -mt-2 w-full">
                <button x-on:click="submitToOrder(false)" class="bg-cyan-400 text-white text-lg px-4 py-3 rounded-2xl w-full focus:outline-none">Submit</button>
                </div>
            </div>
        </div>
        <!-- modal member Input -->
        <div x-show="isShowMember"
        class="fixed w-full h-screen left-0 top-0 z-10 flex flex-wrap justify-center content-center p-24" x-cloak>
            <div
                x-show="isShowMember"
                class="fixed glass w-full h-screen left-0 top-0 z-0" x-on:click="closeModalMember()"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            ></div>
            <div
                x-show="isShowMember"
                class="w-96 rounded-3xl bg-white shadow-xl overflow-hidden z-10"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
            >
                <div id="table-content" class="text-left h-full text-sm p-6">
                    <div class="text-center">
                        <img src="" alt="Zax Resto" class="mb-3 w-8 h-8 inline-block">
                        <h2 class="text-xl font-semibold">List Of Member</h2>
                        <h2 class="text-base text-cyan-500">Choose an Member</h2>
                    </div>
                    <hr class="my-2">
                    <div class="flex antialiased">
                    <div class="w-full px-2 pb-2 pl-2 pr-2 overflow-auto">
                        <div class="w-full basis-2/3 relative p-2 ">
                                    <div class="absolute left-5 top-5 px-2 py-2 rounded-full bg-cyan-500 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input 
                                        type="text"
                                        class="bg-white rounded-2xl shadow-md text-lg full w-full h-12 py-4 pl-16 transition-shadow focus:shadow-xl focus:outline-none"
                                        placeholder="Cari Member ..."
                                        x-model="keywordMember"
                                    /> 
                                </div>
                        <div x-show="filteredMembers().length" class="overflow-x-auto whitespace-nowrap mb-3 thin-scrollbar">
                            <template x-for="mbr in filteredMembers()" :key="mbr.id">
                                <div role="button"
                                :class="'rounded-xl shadow-lg bg-cyan-300 border border-gray-400 py-2 mb-3 hover:bg-cyan-400 hover:text-white focus:outline-none text-gray'"
                                :title="mbr.name"
                                x-on:click="chooseMember(this,mbr)">
                                <div class="flex font-semibold pl-2 pr-2">
                                    <div class="flex-grow text-white text-base font-medium">Email</div>
                                    <div class="text-white text-base font-medium "  x-text="mbr.email"></div>
                                </div>
                                <div class="flex font-semibold pl-2 pr-2">
                                    <div class="flex-grow text-white text-base font-medium">Name</div>
                                    <div class="text-white text-base font-medium"  x-text="mbr.fullname"></div>
                                </div>
                            </template>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="p-4 w-full">
                <button x-on:click="closeModalDisc()" class="bg-cyan-400 text-white text-lg px-4 py-3 rounded-2xl w-full focus:outline-none" x-on:click="printAndProceed()">Submit</button>
                </div>
            </div>
        </div>
        <!-- end modal member input -->
  </div>
</body>
</html>
