  function initApp() {
    const app = {
      db: null,
      time: null,
      activeMenu: 'table',
      urlServer:getCookie('server'),
      store : (getCookie('store')!==null)?JSON.parse(getCookie('store')):null,
      keywordCat:"",
      keywordArea:"",
      keywordMember:"",
      listofArea:[],
      listofTable:[],
      listofStore:[],

      //Setup Store//
      store_setup:null,
      //Setup Store//

      //params//
      firstBalance:false,
      params_store:{},
      params_balance:0,
      params_shift:0,
      openingbalance:0,
      start_time:null,
      end_time:null,
      business:{},
      table:{},
      user:{},
      //params//

      //exisst//
      exist_user:{},
      exist_store:{},
      exist_shift:0,
      exist_sessionPos:null,
      exist_business:{},
      exist_startTime:null,
      exist_prefixes:null,
      exist_balance:0,

      //exisst//
      firstTime: localStorage.getItem("first_time") === null,
      async initDatabase() {
        this.db = await loadDatabase();
        this.getStore();
        this.getPosTableArea();
        this.getPosTable();
        this.check_openStore();
      },

      // function
      chooseMenu(type) {
        this.activeMenu = type;
        this.hasil();
      },
      hasil(){
        console.log(this.activeMenu);
      },
      async getPosTableArea() {
        var endpoint = this.urlServer+'apis/get_pos_table_area';
        if(this.store !==null){
          endpoint = this.urlServer+'apis/get_pos_table_area?keyword='+this.store.id;
        }
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.listofArea = data;
      },

      async getPosTable() {
        var endpoint = this.urlServer+'apis/get_pos_table';
        if(this.store !==null){
          endpoint = this.urlServer+'apis/get_pos_table?keyword='+this.store.id;
        }
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.listofTable = data;
      },

      async loadTablePos() {
        this.getPosTableArea();
        this.getPosTable();
      },

      async getStore() {
        const endpoint = this.urlServer+'apis/get_store'; // Or any other specific endpoint
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.listofStore = data;
      },

      async getStoreRow($id) {
        const endpoint = this.urlServer+'apis/get_store?keyword='+$id; // Or any other specific endpoint
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.params_store = data[0];
      },
      initialData(){
        if(getCookie('session_pos')!== null){
            this.store = JSON.parse(getCookie('store'));
            this.openingbalance = getCookie('amount_opening');
            this.user = JSON.parse(getCookie('user'));
            this.business = JSON.parse(getCookie('business'));
            this.start_time = getCookie('start_time');
            this.shift = getCookie('shift');
            this.exist_user ={};
            this.exist_store={};
            this.exist_shift=0;
            this.exist_sessionPos=null;
            this.exist_business={};
            this.exist_startTime=null;
            this.exist_prefixes=null;
            this.exist_balance=0;
            this.params_branch={};
            this.params_balance=0;
            this.params_shift=0;
            console.log(this.submitHoldOrder());
            this.loadTablePos();
            this.getTransactionPending();
        }
     
      },

      // optionSelect//
      chooseStore(store) {
        this.getStoreRow(store);
        console.log(store);
      },
      chooseShift(shift) {
        const getShift = parseInt(shift);
        this.params_shift = getShift;
      },
      // optionsSelect//

      //OpeningForm//
      openingStoreList(){
        return this.listofStore;
      },
      submitOpeningStore(){
        this.checkOpenShift();
      },
      setOpeningBalance(value) {
        this.params_balance = parseFloat(value.replace(/[^0-9]+/g, ""));
      },
      //OpeningForm//

      // LIST DATA //
      allArea(){
        console.log(this.listofTable);
        return this.listofArea;
      },
      addAreaTable(element,content){
        if(content === "all"){
          this.keywordArea = "";
        }else{
          this.keywordArea = content.id;
        }
      },
      // LIST DATA //
  
      // FILTER//
      filteredTables() {
        console.log("Keyword "+this.keywordArea);
        if(this.keywordArea != "" || this.keywordArea != null){
            return this.listofTable.filter((p) => p.area_id.match(this.keywordArea));
        }else{
            return this.listofTable;
        }   
      },

      // CHECK//
      check_openStore(){
        const s_store =  getCookie("store") === null;
        if(s_store === true){
          this.firstBalance = true;
        }else{
          this.checkOpenShift();
        }
       
      },
      async checkOpenShift() {
        const storeParams = (Object.keys(this.params_store).length === 0)?JSON.parse(getCookie('store')):this.params_store;
        try {
          const myData = {
                store_id: storeParams,
              };
          const csrfToken = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');
          const response = await fetch(this.urlServer+'posmain/check_openshift', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
              },
              body: JSON.stringify(myData) // Send your data as JSON
          });

          if (!response.ok) {
              // Handle HTTP errors
              throw new Error(`HTTP error! status: ${response.status}`);
          }

          const data = await response.json();
          if(data.status === "success"){
            if(data.data !== null){
              this.exist_balance = data.data.opening_amount;
              this.exist_store = data.data.store;
              this.exist_shift = data.data.shift;
              this.exist_sessionPos = data.data.session_pos;
              this.exist_startTime = data.data.open_at;
              this.exist_business = getCookie('business');
              this.exist_user = JSON.parse(getCookie('user'));
              this.firstBalance = false;
              this.existShift = true;
            }else{
              if(Object.keys(this.params_store).length > 0 && this.params_balance > 0 && this.params_shift > 0){
                const currentDate = getBaseDate();
                this.exist_startTime = currentDate;
                this.exist_sessionPos = crypto.randomUUID();
                this.exist_store = this.params_store;
                this.exist_balance = this.params_balance;
                this.exist_shift = this.params_shift;
                Swal.fire({
                  title: 'Yakin ingin membuka POS Regiser ? ',
                  text: "Silahkan tekan tombol Lanjutkan atau batalkan",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.isConfirmed) {
                    this.startShiftPOS();
                  } else if (result.dismiss === Swal.DismissReason.cancel) {
                        document.cookie = "session_pos=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                        document.cookie = "store=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                        document.cookie = "business=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                        document.cookie = "shift=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                        document.cookie = "start_time=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                        document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                        document.cookie = "prefix=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                        document.cookie = "amount_opening=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                        window.close();
                        window.location.href = 'http://localhost:8080'; 
                      }
                  });

              }else{
                this.firstBalance = true;
                this.existShift = false;
              }
            }
          }
        } catch (error) {
            console.error('Error:', error);
            // Handle network errors or other exceptions
        }
      },
      async startShiftPOS() {
        try {
          const myData = {
                business_id: this.exist_store.business_id,
                store_id:this.exist_store.id,
                shift:this.exist_shift,
                opening_amount:this.exist_balance,
                session_pos:this.exist_sessionPos
              };
          const csrfToken = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');
          const response = await fetch(this.urlServer+'posmain/start_shift', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
              },
              body: JSON.stringify(myData) // Send your data as JSON
          });

          if (!response.ok) {
              // Handle HTTP errors
              throw new Error(`HTTP error! status: ${response.status}`);
          }

          const data = await response.json();
          if(data.status === "exist"){
              setCookie("session_pos",this.exist_sessionPos);
              setCookie("start_time",this.exist_startTime);
              setCookie("store",JSON.stringify(this.exist_store));
              setCookie("amount_opening",this.exist_balance);
              setCookie('shift',this.exist_shift);
              this.reUpdateProducts();
              this.existShift = false;
          }if(data.status === "add"){
              setCookie("session_pos",this.exist_sessionPos);
              setCookie("start_time",this.exist_startTime);
              setCookie("store",JSON.stringify(this.exist_store));
              setCookie("amount_opening",this.exist_balance);
              setCookie('shift',this.exist_shift);
              this.firstBalance = false; 
              this.initialData();
              this.addUpdateProducts();
          }if(data.status === "error"){
             Swal.fire({
                title: 'Ada Masalah dengan System ',
                text: "Silahkan Tutup ",
                icon: 'danger',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                   document.cookie = "session_pos=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                      document.cookie = "store=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                      document.cookie = "business=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                      document.cookie = "shift=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                      document.cookie = "start_time=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                      document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                      document.cookie = "prefix=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                      window.close();
                      window.location.href = 'http://localhost:8080';  
                }
            });
          }
        } catch (error) {
            console.error('Error:', error);
            // Handle network errors or other exceptions
        }
      },
    }
    return app;
  }


  // DATABASE ///
  async function loadDatabase() {
    const db = await idb.openDB("zax_store", 1, {
      upgrade(db, oldVersion, newVersion, transaction) {
        db.createObjectStore("foodmenu_category", {
          keyPath: "id",
          autoIncrement: true,
        });
        db.createObjectStore("foodmenu", {
          keyPath: "id",
          autoIncrement: true,
        });
      },
    });

    
    return {
      db,
      //getCategory: async () => await db.getAll("category"),
      //getProducts: async () => await db.getAll("products"),
      //addCategory: async (category) => await db.add("category", category),
      //editCategory: async (category) =>await db.put("category", category),
      //addProduct: async (product) => await db.add("products", product),
      //editProduct: async (product) => await db.put("products", product),
      //deleteProduct: async (product) => await db.delete("products", product.id),
    };
  }



//Function

