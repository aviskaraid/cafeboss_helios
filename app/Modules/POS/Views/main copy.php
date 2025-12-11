<?php

use PhpParser\Node\Expr\Cast\String_;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?= csrf_meta() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ZAX POS</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="<?=base_url()?>pos/css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/idb@8/build/umd.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />   
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?=base_url()?>pos/js/script.js"></script>
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
              <a href="#"
                  class="flex items-center justify-center h-12 w-12 bg-cyan-50 text-cyan-700 rounded-full">
                  <svg xmlns="http://www.w3.org/2000/svg" width="123.3" height="123.233" viewBox="0 0 32.623 32.605">
                  <path d="M15.612 0c-.36.003-.705.01-1.03.021C8.657.223 5.742 1.123 3.4 3.472.714 6.166-.145 9.758.019 17.607c.137 6.52.965 9.271 3.542 11.768 1.31 1.269 2.658 2 4.73 2.57.846.232 2.73.547 3.56.596.36.021 2.336.048 4.392.06 3.162.018 4.031-.016 5.63-.221 3.915-.504 6.43-1.778 8.234-4.173 1.806-2.396 2.514-5.731 2.516-11.846.001-4.407-.42-7.59-1.278-9.643-1.463-3.501-4.183-5.53-8.394-6.258-1.634-.283-4.823-.475-7.339-.46z" fill="#fff"/><path d="M16.202 13.758c-.056 0-.11 0-.16.003-.926.031-1.38.172-1.747.538-.42.421-.553.982-.528 2.208.022 1.018.151 1.447.553 1.837.205.198.415.313.739.402.132.036.426.085.556.093.056.003.365.007.686.009.494.003.63-.002.879-.035.611-.078 1.004-.277 1.286-.651.282-.374.392-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.147-.072zM16.22 19.926c-.056 0-.11 0-.16.003-.925.031-1.38.172-1.746.539-.42.42-.554.981-.528 2.207.02 1.018.15 1.448.553 1.838.204.198.415.312.738.4.132.037.426.086.556.094.056.003.365.007.686.009.494.003.63-.002.88-.034.61-.08 1.003-.278 1.285-.652.282-.374.393-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.863-1.31-.977a7.91 7.91 0 00-1.146-.072zM22.468 13.736c-.056 0-.11.001-.161.003-.925.032-1.38.172-1.746.54-.42.42-.554.98-.528 2.207.021 1.018.15 1.447.553 1.837.205.198.415.313.739.401.132.037.426.086.556.094.056.003.364.007.685.009.494.003.63-.002.88-.035.611-.078 1.004-.277 1.285-.651.282-.375.393-.895.393-1.85 0-.688-.065-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.146-.072z" fill="#00dace"/><path d="M9.937 13.736c-.056 0-.11.001-.161.003-.925.032-1.38.172-1.746.54-.42.42-.554.98-.528 2.207.021 1.018.15 1.447.553 1.837.204.198.415.313.738.401.133.037.427.086.556.094.056.003.365.007.686.009.494.003.63-.002.88-.035.61-.078 1.003-.277 1.285-.651.282-.375.393-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.146-.072zM16.202 7.59c-.056 0-.11 0-.16.002-.926.032-1.38.172-1.747.54-.42.42-.553.98-.528 2.206.022 1.019.151 1.448.553 1.838.205.198.415.312.739.401.132.037.426.086.556.093.056.003.365.007.686.01.494.002.63-.003.879-.035.611-.079 1.004-.278 1.286-.652.282-.374.392-.895.393-1.85 0-.688-.066-1.185-.2-1.505-.228-.547-.653-.864-1.31-.978a7.91 7.91 0 00-1.147-.071z" fill="#00bcd4"/><g><path d="M15.612 0c-.36.003-.705.01-1.03.021C8.657.223 5.742 1.123 3.4 3.472.714 6.166-.145 9.758.019 17.607c.137 6.52.965 9.271 3.542 11.768 1.31 1.269 2.658 2 4.73 2.57.846.232 2.73.547 3.56.596.36.021 2.336.048 4.392.06 3.162.018 4.031-.016 5.63-.221 3.915-.504 6.43-1.778 8.234-4.173 1.806-2.396 2.514-5.731 2.516-11.846.001-4.407-.42-7.59-1.278-9.643-1.463-3.501-4.183-5.53-8.394-6.258-1.634-.283-4.823-.475-7.339-.46z" fill="#fff"/><path d="M16.202 13.758c-.056 0-.11 0-.16.003-.926.031-1.38.172-1.747.538-.42.421-.553.982-.528 2.208.022 1.018.151 1.447.553 1.837.205.198.415.313.739.402.132.036.426.085.556.093.056.003.365.007.686.009.494.003.63-.002.879-.035.611-.078 1.004-.277 1.286-.651.282-.374.392-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.147-.072zM16.22 19.926c-.056 0-.11 0-.16.003-.925.031-1.38.172-1.746.539-.42.42-.554.981-.528 2.207.02 1.018.15 1.448.553 1.838.204.198.415.312.738.4.132.037.426.086.556.094.056.003.365.007.686.009.494.003.63-.002.88-.034.61-.08 1.003-.278 1.285-.652.282-.374.393-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.863-1.31-.977a7.91 7.91 0 00-1.146-.072zM22.468 13.736c-.056 0-.11.001-.161.003-.925.032-1.38.172-1.746.54-.42.42-.554.98-.528 2.207.021 1.018.15 1.447.553 1.837.205.198.415.313.739.401.132.037.426.086.556.094.056.003.364.007.685.009.494.003.63-.002.88-.035.611-.078 1.004-.277 1.285-.651.282-.375.393-.895.393-1.85 0-.688-.065-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.146-.072z" fill="#00dace"/><path d="M9.937 13.736c-.056 0-.11.001-.161.003-.925.032-1.38.172-1.746.54-.42.42-.554.98-.528 2.207.021 1.018.15 1.447.553 1.837.204.198.415.313.738.401.133.037.427.086.556.094.056.003.365.007.686.009.494.003.63-.002.88-.035.61-.078 1.003-.277 1.285-.651.282-.375.393-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.146-.072zM16.202 7.59c-.056 0-.11 0-.16.002-.926.032-1.38.172-1.747.54-.42.42-.553.98-.528 2.206.022 1.019.151 1.448.553 1.838.205.198.415.312.739.401.132.037.426.086.556.093.056.003.365.007.686.01.494.002.63-.003.879-.035.611-.079 1.004-.278 1.286-.652.282-.374.392-.895.393-1.85 0-.688-.066-1.185-.2-1.505-.228-.547-.653-.864-1.31-.978a7.91 7.91 0 00-1.147-.071z" fill="#00bcd4"/></g>
                  </svg>
              </a>
              <ul class="flex flex-col space-y-2 mt-12">
                  <li>
                    <a href="#"
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
                    <a href="#"
                      class="flex items-center" title="Point Of Sale (Register)">
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
                  <li>
                      <a href="#" x-on:click="reUpdateProducts()"
                      class="flex items-center">
                          <span class="flex items-center justify-center text-cyan-100 hover:bg-cyan-400 h-12 w-12 rounded-2xl">
                          <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7.37756 11.6296H6.62756H7.37756ZM7.37756 12.5556L6.81609 13.0528C6.95137 13.2056 7.14306 13.2966 7.34695 13.3049C7.55084 13.3133 7.74932 13.2382 7.89662 13.0969L7.37756 12.5556ZM9.51905 11.5414C9.81805 11.2547 9.82804 10.7799 9.54137 10.4809C9.2547 10.182 8.77994 10.172 8.48095 10.4586L9.51905 11.5414ZM6.56148 10.5028C6.28686 10.1927 5.81286 10.1639 5.50277 10.4385C5.19267 10.7131 5.16391 11.1871 5.43852 11.4972L6.56148 10.5028ZM14.9317 9.0093C15.213 9.31337 15.6875 9.33184 15.9915 9.05055C16.2956 8.76927 16.3141 8.29476 16.0328 7.9907L14.9317 9.0093ZM12.0437 6.25C9.05802 6.25 6.62756 8.653 6.62756 11.6296H8.12756C8.12756 9.49251 9.87531 7.75 12.0437 7.75V6.25ZM6.62756 11.6296L6.62756 12.5556H8.12756L8.12756 11.6296H6.62756ZM7.89662 13.0969L9.51905 11.5414L8.48095 10.4586L6.85851 12.0142L7.89662 13.0969ZM7.93904 12.0583L6.56148 10.5028L5.43852 11.4972L6.81609 13.0528L7.93904 12.0583ZM16.0328 7.9907C15.0431 6.9209 13.6212 6.25 12.0437 6.25V7.75C13.1879 7.75 14.2154 8.23504 14.9317 9.0093L16.0328 7.9907Z" fill="#ffffff"></path> 
                          <path d="M16.6188 11.4443L17.1795 10.9462C17.044 10.7937 16.8523 10.703 16.6485 10.6949C16.4447 10.6868 16.2464 10.7621 16.0993 10.9034L16.6188 11.4443ZM14.4805 12.4581C14.1817 12.745 14.1722 13.2198 14.4591 13.5185C14.746 13.8173 15.2208 13.8269 15.5195 13.54L14.4805 12.4581ZM17.4393 13.4972C17.7144 13.8068 18.1885 13.8348 18.4981 13.5597C18.8078 13.2846 18.8358 12.8106 18.5607 12.5009L17.4393 13.4972ZM9.04688 15.0047C8.76342 14.7027 8.28879 14.6876 7.98675 14.9711C7.68472 15.2545 7.66966 15.7292 7.95312 16.0312L9.04688 15.0047ZM11.9348 17.7499C14.9276 17.7499 17.3688 15.3496 17.3688 12.3703H15.8688C15.8688 14.5047 14.1158 16.2499 11.9348 16.2499V17.7499ZM17.3688 12.3703V11.4443H15.8688V12.3703H17.3688ZM16.0993 10.9034L14.4805 12.4581L15.5195 13.54L17.1383 11.9853L16.0993 10.9034ZM16.0581 11.9425L17.4393 13.4972L18.5607 12.5009L17.1795 10.9462L16.0581 11.9425ZM7.95312 16.0312C8.94543 17.0885 10.3635 17.7499 11.9348 17.7499V16.2499C10.792 16.2499 9.76546 15.7704 9.04688 15.0047L7.95312 16.0312Z" fill="#ffffff"></path> 
                          <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
                          </span>
                      </a>
                  </li>
              </ul>
              <a href="#" x-on:click = "OpenRegisterDetail" class="mt-auto flex items-center justify-center text-cyan-200 hover:text-cyan-100 h-10 w-10 focus:outline-none">
                <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> 
                    <path d="M4 21C4 17.4735 6.60771 14.5561 10 14.0709M19.8726 15.2038C19.8044 15.2079 19.7357 15.21 19.6667 15.21C18.6422 15.21 17.7077 14.7524 17 14C16.2923 14.7524 15.3578 15.2099 14.3333 15.2099C14.2643 15.2099 14.1956 15.2078 14.1274 15.2037C14.0442 15.5853 14 15.9855 14 16.3979C14 18.6121 15.2748 20.4725 17 21C18.7252 20.4725 20 18.6121 20 16.3979C20 15.9855 19.9558 15.5853 19.8726 15.2038ZM15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7Z" stroke="#ffffff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                  </g>
                </svg>
              </a>
          </div>
      </div>
      <div class="min-h-screen w-screen grid grid-cols-6 pl-2 pr-2 py-2 gap-2">
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
                              <p class="bg-cyan-300 rounded-xl p-2 font-bold text-lg text-center text-white" x-text="branch.name"></p>
                          </div>
                      </div>
                      <div class="basis-1/3 p-2">
                          <div class="flex justify-end py-2">
                          <button class="bg-pink-400 rounded-xl w-32 h-full text-white text-lg p-2 mr-1"><i class="fas fa-percentage mr-1"></i> Promo</button>
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
                      x-show="products.length === 0">
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
                      x-show="filteredProducts().length === 0 && keyword.length > 0">
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
                          x-on:click="addCatActive(this,'all')">
                              <div class="flex px-3 text-md">
                              <p class="nowrap font-semibold">All</p>
                              </div>
                          </div>
                          <template x-for="cat in allCategory()" :key="cat.id">
                              <div role="button" 
                              :class="keywordCat==cat.id?'bg-cyan-400 select-none inline-block select-none cursor-pointer transition-shadow overflow-hidden rounded-xl bg-white shadow hover:shadow-lg p-1':'select-none inline-block select-none cursor-pointer transition-shadow overflow-hidden rounded-xl bg-white shadow hover:shadow-lg p-1 hover'"
                              :title="cat.description"
                              x-on:click="addCatActive(this,cat)">
                                  <div class="flex px-3 text-md">
                                  <p class="nowrap font-semibold" x-text="cat.description"></p>
                                  </div>
                              </div>
                          </template>
                      </div>
                      <!-- end Group Menu -->
                      <!--start Item product-->
                      <div x-show="filteredProducts().length" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4">
                      <template x-for="product in filteredProducts()" :key="product.id">
                          <div
                          role="button"
                          class="select-none cursor-pointer transition-shadow overflow-hidden rounded-2xl bg-white shadow hover:shadow-lg"
                          :title="product.name"
                          x-on:click="addToCart(product)">
                          <img :src="product.image" :alt="product.name" class="w-52 h-40">
                          <div class="flex pb-3 px-3 text-sm -mt-3 label_product">
                              <p class="flex-grow truncate mr-1 description" x-text="product.name"></p>
                              <p class="nowrap font-semibold" x-text="priceFormat(product.price)"></p>
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
          <!-- start Col 2 -->
          <div class="flex-grow overflow-y-auto bg-gray-100 col-span-2 p-2 rounded-2xl">
              <!-- start Col Summary Content -->
              <div class="flex flex-col h-full pr-2 pl-2">
                  <div class="bg-white rounded-2xl flex flex-col h-full shadow">
                      <div class="grid grid-cols-2 gap-2 mt-2">
                          <template x-for="conc in concept">
                          <button x-on:click="addConcept(conc)" :class="conc==chooseConcept?'bg-cyan-400 text-white font-semibold rounded-lg shadow hover:shadow-lg focus:outline-none inline-block px-2 py-1 text-md':'bg-white rounded-lg shadow hover:shadow-lg focus:outline-none inline-block px-2 py-1 text-md'"><span x-text="conc"></span></button>
                          </template>
                      </div>
                      <!-- empty cart -->
                      <div x-show="cart.length === 0" class="flex-1 w-full p-4 opacity-25 select-none flex flex-col flex-wrap content-center justify-center">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                          </svg>
                          <p>
                          CART EMPTY
                          </p>
                      </div>
                      <!-- end empty cart -->
                      <!-- cart items -->
                      <div x-show="cart.length > 0" class="flex-1 flex flex-col overflow-auto">
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
                              <template x-for="item in cart" :key="item.productId">
                                  <div class="select-none mb-3 bg-blue-gray-50 rounded-lg w-full text-blue-gray-700 py-2 px-2 flex justify-center">
                                  <img :src="item.image" alt="" class="rounded-lg h-10 w-10 bg-white shadow mr-2">
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

                      <!-- payment info -->
                      <div class="select-none h-auto w-full text-center pt-3 pb-4 px-4">
                          <div class="flex justify-between items-center text-lg font-semibold">
                            <div x-on:click="openModalDisc();$nextTick(() => { $refs.myInputDisc.focus(); })" 
                              class="flex-grow text-left text-sm cursor-pointer text-pink-400 w-32"><i class="fas fa-percentage mr-1"></i>Input Disc</div>
                                <div :class="disc==0?'hidden':'text-right text-sm text-pink-600 pr-4 cursor-pointer'" x-on:click="clearDiscount()"><i class="fas fa-trash-alt" style="font-size:14px"></i></div>
                              <div class="text-right text-sm text-pink-600" x-text="priceFormat(disc)"></div>

                          </div>
                          <div class="flex mb-3 text-lg font-semibold text-blue-gray-700">
                              <div>SubTotal</div>
                              <div class="text-right w-full" x-text="priceFormat(subTotal)"></div>
                          </div>
                          <div class="mb-3 text-blue-gray-700 px-3 pt-2 pb-2 rounded-lg bg-blue-gray-50">
                              <div class="flex justify-between items-center text-lg font-semibold">
                              <div class="flex-grow text-left">
                                  <button x-on:click="openModalMember()" class="rounded-md shadow-lg bg-gray-200 pt-2 pb-2 pl-2 pr-4 hover:text-blue-500 focus:outline-none font-semibold text-base" x-text="Object.keys(member).length === 0?'Choose Customer':member.fullname"></button>
                              </div>
                              <div class="flex text-right">
                                  <p :class ="chooseConcept!='Dine In'?'hidden':'rounded-md bg-white shadow-md px-1 py-1 focus:outline-none text-sm cursor-pointer'" x-on:click="openModalTable()" x-text="Object.keys(table).length === 0?'Choose Table':table.description"></p>
                              </div>
                          </div>
                          <hr class="my-1">
                          <div class="flex justify-between items-center text-lg font-semibold">
                              <div class="flex-grow text-left">
                                  <button x-on:click="OpenPayMethod()" class="rounded-md shadow-lg bg-gray-200 pt-2 pb-2 pl-2 pr-4 hover:text-blue-500 focus:outline-none font-semibold text-base" x-text="payMethod.toUpperCase()"></button>
                              </div>
                              <div class="flex text-right">
                                  <div class="mr-2">Rp</div>
                                  <input x-bind:value="numberFormat(cash)" x-on:keyup="updateCash($event.target.value)" type="text" class="w-28 text-right bg-white shadow rounded-lg focus:bg-white focus:shadow-lg px-2 focus:outline-none">
                              </div>
                          </div>
                          <hr class="my-2">
                          <div x-show="payMethod==='debit'" class="grid grid-cols-2 gap-2 mt-2 px-2 py-1 text-sm">
                              <div class="flex">
                                  <select class="choose_bank_2 w-48" id="choose_bank_2" name="bank_account" x-on:change="chooseBank($event.target.value)">
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
                              <input type="text" placeholder="Transaction Number" x-on:keyup="setTransactionNumber($event.target.value)" class="h-6 bg-white rounded-lg shadow hover:shadow-lg focus:outline-none inline-block px-2 py-1 text-sm">
                          </div>
                          <div x-show="payMethod==='bank_transfer'" class="grid grid-cols-2 gap-2 mt-2 px-2 py-1 text-sm">
                              <input type="text" placeholder="Account Name" x-on:keyup="setAccountName($event.target.value)" class="h-6 bg-white rounded-lg shadow hover:shadow-lg focus:outline-none inline-block px-2 py-1 text-sm">
                              <div class="flex">
                                  <select class="choose_bank w-48" id="choose_bank" name="bank_account" x-on:change="chooseBank($event.target.value)">
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
                              <input type="text" placeholder="Account Number"x-on:keyup="setAccountNumber($event.target.value)" class="h-6 bg-white rounded-lg shadow hover:shadow-lg focus:outline-none inline-block px-2 py-1 text-sm">
                          </div>
                          <div x-show="payMethod==='cash'" class="grid grid-cols-3 gap-2 mt-2">
                              <template x-for="money in moneys">
                              <button x-on:click="addCash(money)" class="bg-white rounded-lg shadow hover:shadow-lg focus:outline-none inline-block px-2 py-1 text-sm">+<span x-text="numberFormat(money)"></span></button>
                              </template>
                          </div>
                          </div>
                          <div x-show="change > 0"
                              class="flex mb-3 text-lg font-semibold bg-cyan-50 text-blue-gray-700 rounded-lg py-2 px-3">
                              <div class="text-cyan-800">CHANGE</div>
                              <div
                                  class="text-right flex-grow text-cyan-600"
                                  x-text="priceFormat(change)">
                              </div>
                          </div>
                          <div
                              x-show="change < 0"
                              class="flex mb-3 text-lg font-semibold bg-pink-100 text-blue-gray-700 rounded-lg py-2 px-3">
                              <div
                                  class="text-right flex-grow text-pink-600"
                                  x-text="priceFormat(change)">
                              </div>
                          </div>
                          <div x-show="change == 0 && cart.length > 0"
                              class="flex justify-center mb-3 text-lg font-semibold bg-cyan-50 text-cyan-700 rounded-lg py-2 px-3">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                              </svg>
                          </div>
                          <div :class="chooseConcept === 'Dine In'?'flex justify-between items-center text-lg font-semibold':'hidden flex justify-between items-center text-lg font-semibold'">
                              <div class="w-1/2">
                                  <button
                                      type="hidden"
                                      class="text-white rounded-2xl text-lg w-full py-3 focus:outline-none font-bold"
                                      x-bind:class="{
                                          'bg-cyan-500 hover:bg-cyan-600': submitHoldOrder(),
                                          'bg-blue-gray-200': !submitHoldOrder()
                                      }"
                                      :disabled="!submitHoldOrder()"
                                      x-on:click="submitToTableOrder()"
                                      >
                                      Hold Order
                                  </button>
                              </div>
                              <div class="w-1/2 ml-2">
                                  <button
                                      type="hidden"
                                      class="text-white rounded-2xl text-lg w-full py-3 focus:outline-none font-bold"
                                      x-bind:class="{
                                          'bg-cyan-500 hover:bg-cyan-600': submitable(),
                                          'bg-blue-gray-200': !submitable()
                                      }"
                                      :disabled="!submitable()"
                                      x-on:click="submitToReceipt()"
                                      x-text="`Pay ${priceFormat(getTotalPrice())}`"
                                      >
                                  </button>
                              </div>
                          </div>
                          <button 
                          type="hidden"
                          :class="chooseConcept === 'Dine In'?'hidden text-white rounded-2xl text-lg w-full py-3 focus:outline-none font-bold':'text-white rounded-2xl text-lg w-full py-3 focus:outline-none font-bold'"
                          x-bind:class="{
                              'bg-cyan-500 hover:bg-cyan-600': submitable(),
                              'bg-blue-gray-200': !submitable()
                          }"
                          :disabled="!submitable()"
                          x-on:click="submitToReceipt()"
                          x-text="priceFormat(getTotalPrice())"
                          >
                          </button>
                      </div>
                      <!-- end of payment info -->
                  </div>
              </div>
              <!-- end Col Summary Content -->
          </div>
          <!-- end Col 2 -->
          <!-- start Col 3 -->
          <div class="flex-grow overflow-y-auto bg-gray-100 p-2 rounded-2xl">
          <div class="flex justify-between items-center text-lg font-semibold">
              <div class="flex-grow text-center text-base text-cyan-600">
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
                      <h1 x-text="time"></h1>
                      <p x-text="date"></p>
                  </div>
                  <hr class="my-2">
                  <div class="bg-cyan-200 text-white rounded-xl">Transactions List</div>
                  <hr class="my-2">
                  <template x-for="mbr in transaction_pending" :key="mbr.id">
                      <div role="button"
                      :class="'rounded-xl shadow-lg bg-pink-200 py-2 mb-3 hover:bg-pink-400 hover:text-white text-black focus:outline-none'"
                      :title="mbr.pos.table.name">
                    <div class="flex-grow text-center text-sm">
                      <div x-text="mbr.pos.table.name"></div>
                        <div x-text="splitString(';',mbr.sub_status)[1]" class="text-cyan-500"></div>
                      <div class="flex justify-between items-center text-sm font-semibold pr-2 pl-2">
                          <div class="flex-grow text-left" x-text="splitString(';',mbr.sub_status)[0]"></div>
                          <div class="flex text-right" x-text="priceFormat(mbr.sales.total_before_tax)"></div>
                      </div>
                  </div>
                  </div>
                  </template>
              </div>
          </div>
            <!-- end Col 3 -->
          </div>
          <!-- end Col 3 -->
      </div>
  </div>
</body>
</html>
