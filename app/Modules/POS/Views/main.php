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
              <a href="#" x-on:click="reUpdateProducts()"
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
                    <h2 class="text-xl font-semibold bg-teal-400 text-white rounded-2xl pt-4 pb-4" x-text="store.name"></h2>
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
              x-transition:leave-end="opacity-0 transform scale-90"
          >
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
                              <select class="choose_branch w-96" id="choose_branch" x-show="openingStoreList().length" x-on:change="chooseStore($event.target.value)">
                                  <option></option>    
                                  <template x-for="item in openingStoreList()" :key="item.id">
                                      <option :value="item.id" x-text="item.description">
                                      </option>
                                  </template>
                              </select>
                          </div>
                          <h3 class="text-left text-sm mb-2 text-gray-600 font-semibold">Choose Shift : </h3>
                          <div class="flex justify-left items-center mb-4">
                              <select class="choose_shift w-96" id="choose_shift" name="shift" x-on:change="chooseShift($event.target.value)">
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
  </div>
</body>
</html>
