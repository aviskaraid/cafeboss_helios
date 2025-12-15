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
      keyword:"",
      listofArea:[],
      listofTable:[],
      listofStore:[],
      listOfMember:[],

      //Setup Store//
      store_setup:null,
      take_away :"1",
      //Setup Store//

      //params//
      firstBalance:false,
      existShift : false,
      params_store:{},
      params_balance:0,
      params_shift:0,
      openingbalance:0,
      start_time:null,
      end_time:null,
      business:{},
      user:(getCookie('user')!==null)?JSON.parse(getCookie('user')):null,
      
      //params//

      // SHOW //
      isShowMember:false,
      isShowHoldAndPay:false,
      isShowPayForm:false,
      isInputDisc: false,

      //exisst//
      exist_user:{},
      exist_store:{},
      exist_shift:0,
      exist_sessionPos:null,
      exist_business:{},
      exist_startTime:null,
      exist_prefixes:null,
      exist_balance:0,

      //table
      pilih_table :{},
      foodMenu: [],
      category: [],
      cart: [],
      member:{},
      cash: 0,
      disc: 0,
      change: 0,
      subTotal:0,
      payMethod:"cash",
      moneys: [2000, 5000, 10000, 20000, 50000, 100000],
      transaction_pending:[],
      receiptNo: null,
      receiptDate: null,
      amount:0,
      payMethod:"cash",
      account_name:null,
      account_bank:null,
      account_number:null,
      account_trans_number:null,
      isPayDebit:false,
      isPayTransfer:false,
      isPayCash:true,
      pay_refNumber:null,
      pay_note:null,
      //exisst//
      firstTime: localStorage.getItem("first_time") === null,
      async initDatabase() {
        this.db = await loadDatabase();
        this.check_openStore();
        this.getStore();
        this.getPosTableArea();
        this.getPosTable();
        this.getFoodMenuCategory();
        this.getMember();
      },
      getTotalPrice() {
        this.subTotal = this.cart.reduce(
          (total, item) => total + item.qty * item.price,
          0
        );
        return this.subTotal - this.disc;
      },
      chooseCat(element,cat) {
        if(cat === "all"){
          this.keywordCat = "";
        }else{
          this.keywordCat = cat.id;
        }
      },
      chooseFoodMenu(element,food){
        console.log(this.store_setup.display_name);
        console.log("Choose Menu "+food.name);
        console.log("Take Away "+this.take_away);
        this.addToCart(food);
      },
      openModalMember() {
        //this.loadTablePos();
        console.log("Modal Member Open");
        console.log(JSON.stringify(this.listOfMember));
        this.isShowMember = true;
      },
      chooseMember(element,member){
        console.log(JSON.stringify(member));
        this.member = member;
        this.isShowMember = false;
      },
      addToCart(foodMenu) {
        const index = this.findCartIndex(foodMenu);
        if (index === -1) {
          this.cart.push({
            foodMenuId: foodMenu.id,
            image: foodMenu.picture,
            name: foodMenu.name,
            price: foodMenu.sell_price,
            option: "",
            category:foodMenu.category_id,
            qty: 1
          });
        } else {
          this.cart[index].qty += 1;
        }
        this.updateChange();
        console.log("setup "+JSON.stringify(this.store_setup));
      },
      addQty(item, qty) {
        const index = this.cart.findIndex((i) => i.foodMenuId === item.foodMenuId);
        if (index === -1) {
          return;
        }
        const afterAdd = item.qty + qty;
        if (afterAdd === 0) {
          this.cart.splice(index, 1);
        } else {
          this.cart[index].qty = afterAdd;
        }
        this.updateChange();
      },
      updateChange() {
        this.change = this.cash - this.getTotalPrice();
        console.log(this.change);
      },
      findCartIndex(foodMenu) {
        return this.cart.findIndex((p) => p.foodMenuId === foodMenu.id);
      },
      // function
      priceFormat(number) {
        return number ? `${numberFormatDisplay(number)}` : `Rp. 0`;
      },
      chooseMenu(type) {
        if(type=="table"){
          if(this.cart.length > 0){
            this.cart = [];
            this.activeMenu = type;
          }
        }else{
          this.activeMenu = type;
          this.hasil();
        }
      },
      choosePaymentMethod(method){
        if(method==="cash"){
          this.updateCashPay(0);
          this.isPayCash = true;
          this.payMethod = "cash";
        }if(method==="debit"){
          this.updateCashPay(this.getTotalPrice());
          this.isPayDebit = true;
          this.payMethod = "debit";
        }if(method==="bank_transfer"){
          this.updateCashPay(this.getTotalPrice());
          this.isPayTransfer = true;
          this.payMethod = "bank_transfer";
        }
        this.isPayMethod = false;
      },
            updateCash(value) {
        this.cash = parseFloat(value.replace(/[^0-9]+/g, ""));
        this.updateChange();
      },
      updateCashPay(value) {
        this.cash = value;
        this.amount = value;
        this.updateChange();
      },
      setDiscount(value) {
        let ins = parseFloat(value.replace(/[^0-9]+/g, ""));
        this.disc = isNaN(ins) ? 0 : ins;
        this.updateChange();
      },
      hasil(){
        console.log(this.activeMenu);
      },
      allCategory() {
        return this.category;
      },
      getItemsCount() {
        return this.cart.reduce((count, item) => count + item.qty, 0);
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

      async getFoodMenuCategory() {
        var endpoint = this.urlServer+'apis/get_foodmenu_category_bystore';
        if(this.store !==null){
          endpoint = this.urlServer+'apis/get_foodmenu_category_bystore?keyword='+this.store.id;
        }
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.category = data;
        console.log(data);
        this.getFoodMenu();
      },

      async getFoodMenu() {
        var endpoint = this.urlServer+'apis/get_foodmenu_bystore';
        if(this.store !==null){
          endpoint = this.urlServer+'apis/get_foodmenu_bystore?keyword='+this.store.id;
        }
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.foodMenu = data;
        console.log(data);
      },

      async getStoreRow($id) {
        const endpoint = this.urlServer+'apis/get_store?keyword='+$id; // Or any other specific endpoint
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.params_store = data[0];
        console.log("params_store "+this.params_store);
      },
      async getMember() {
        const endpoint = this.urlServer+'apis/get_customer'; // Or any other specific endpoint
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.listOfMember = data;
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
            this.params_store={};
            this.params_balance=0;
            this.params_shift=0;
            console.log(this.submitHoldOrder());
            this.loadTablePos();
            this.getTransactionPending();
        }
      },
      submitToPayForm(){
        this.isShowPayForm = true;
        console.log("User "+JSON.stringify(this.user));
      },
      closeHPForm(){
        this.isShowHoldAndPay = false;
      },
      closeAllForm(){
        this.isShowHoldAndPay = false;
        this.isShowPayForm = false;
      },
      submit(){
        console.log("Submit");
      },
      submitable() {
        return  Object.keys(this.member).length > 0 && this.cart.length > 0;
      },
      submitHoldOrder() {
        return Object.keys(this.pilih_table).length > 0 && this.cart.length > 0;
      },
      submitToOrder(hold) {
         Swal.fire({
                title: 'Periksa terlebh dahulu data Order !',
                text: "jika sudah yakin silahkan Submit Data Order",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Submit'
            }).then((result) => {
                if (result.isConfirmed) {
                  if(this.member === null  || this.member === undefined || (typeof this.member === 'object' && Object.keys(this.member).length === 0)){
                      var obj = {};
                      obj["username"] = "general";
                      obj['fullname'] = "General";
                      this.member = obj;
                    }
                    this.holdOrder = hold;
                    this.submitransaction();
                }
            });
      },
      submitHoldOrdPay() {
        if(this.member === null  || this.member === undefined || (typeof this.member === 'object' && Object.keys(this.member).length === 0)){

        }else{
            const time = new Date();
            this.isShowHoldAndPay = true;
            const getPrefix = getCookie('prefix');
            this.receiptNo = getPrefix+`-${Math.round(time.getTime() / 1000)}`;
            this.receiptDate = dateFormat(time); 
        }
      },
      addCash(amount) {
        this.cash = (this.cash || 0) + amount;
        this.amount = this.cash;
        this.updateChange();
        //this.beep();
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
      chooseTable(element,table){
        if(table.sales!==null){
          Swal.fire({
                  title: 'Meja ini tidak bisa digunakan!',
                  text: "Silahkan pilih meja yang lain",
                  icon: 'warning',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'CLOSE'
                }).then((result) => {
                  if (result.isConfirmed) {
                  }
                });
        }else{
          this.pilih_table = table;
          this.chooseMenu("pos");
          console.log("CLICK TABLE "+JSON.stringify(table));
        }
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
      filteredFoodMenu() {
        if(this.keywordCat != ""){
            //const rg = this.keyword ? new RegExp(this.keyword, "gi") : null;
            return this.foodMenu.filter((p) => p.category_id.match(this.keywordCat));
        }else{
            const rg = this.keyword ? new RegExp(this.keyword, "gi") : undefined;
            return this.foodMenu.filter((p) => !rg || p.name.match(rg));
        }
      },
      filteredMembers() {
        if(this.keywordMember != ""){
            return this.listOfMember.filter((p) => p.fullname.toLowerCase().match(this.keywordMember.toLowerCase()));
        }else{
            return this.listOfMember;
        }   
      },
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
          console.log("OpenStore "+true);
          this.firstBalance = true;
        }else{
          console.log("OpenStore "+false);
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
              console.log("data.data !==null");
              this.exist_balance = data.data.opening_amount;
              this.exist_store = data.data.store;
              this.store_setup = data.data.store.store_setup[0];
              this.take_away = data.data.store.store_setup[0].take_away;
              this.exist_shift = data.data.shift;
              this.exist_sessionPos = data.data.session_pos;
              this.exist_startTime = data.data.open_at;
              this.exist_business = getCookie('business');
              this.exist_user = JSON.parse(getCookie('user'));
              this.firstBalance = false;
              this.existShift = true;
            }else{
              console.log("data.data ===null");
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
                        window.location.href = this.urlServer; 
                      }
                  });

              }else{
                console.log("data.data ===null existshift false");
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
              setCookie("store_setup",JSON.stringify(this.store_setup));
              setCookie("amount_opening",this.exist_balance);
              setCookie('shift',this.exist_shift);
             // this.reUpdateProducts();
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
                      window.location.href = this.urlServer;  
                }
            });
          }
        } catch (error) {
            console.error('Error:', error);
            // Handle network errors or other exceptions
        }
      },
      async running_pos() {
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
                      window.location.href = this.urlServer; 
                    }
            });

      },
      async submitransaction() {
        const getPayment ={
            payMethod:this.payMethod,
            subtotal:this.subTotal,
            amount:this.amount,
            change:this.change,
            account_name:this.account_name,
            account_bank:this.account_bank,
            account_number:this.account_number,
            account_trans_number:this.account_trans_number
        }
        try {
          const myData = {
              start_time: getBaseDate(),
              hold:this.holdOrder,
              branch: this.store,
              user:this.user,
              table:this.table,
              customer:this.member,
              items:this.cart,
              discount:this.disc,
              shift:this.shift,
              session:getCookie('session_pos'),
              payment:getPayment
            };
            const csrfToken = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');
            const response = await fetch(this.urlServer+'posmain/inputTransaction', {
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
            console.log(data);
            if(data.status === "success"){
              //this.clear();
              //this.initialData();
            }else{
              Swal.fire({
                  title: 'Terjadi masalah dengan system',
                  text: "Hubungi administrator untuk lebih lanjut",
                  icon: 'warning',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
              }).then((result) => {
                  if (result.isConfirmed) {  
                  }
              });
            }
        } catch (error) {
            console.error('Error:', error);
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

