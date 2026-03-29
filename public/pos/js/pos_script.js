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
      item_transaction_id:null,
      item_transaction:{},
      //Setup Store//
      store_setup:null,
      take_away :"1",
      //Setup Store//

      //params//
      pos_id:(getCookie('pos_id')!==null)?JSON.parse(getCookie('pos_id')):null,
      firstBalance:false,
      closeCashier:false,
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

      // CLOSING //
      input_closing_cash: 0,
      input_closing_card: 0,
      input_closing_banktransfer: 0,
      total_closing: 0,
      note_closing: "",

      // OPEN DETAIL //
      Total_Transaction: 0,
      Amount_Transaction: 0,
      Total_Final: 0,
      Amount_Final: 0,
      Total_Pending: 0,
      Amount_Pending: 0,
      Total_Cash: 0,
      Amount_Cash: 0,
      Total_Card: 0,
      Amount_Card: 0,
      Total_Bank_Transfer: 0,
      Amount_Bank_Transfer: 0,
      // SHOW //
      isShowMember:false,
      isShowHoldAndPay:false,
      isShowPayForm:false,
      isInputDisc: false,
      isopenDetail:false,
      //exisst//
      exist_user:{},
      exist_store:{},
      exist_shift:0,
      exist_sessionPos:null,
      exist_business:{},
      exist_startTime:null,
      exist_prefixes:null,
      exist_balance:0,
      exist_pos_id:null,

      //table
      pilih_table :{},
      foodMenu: [],
      category: [],
      cart: [],
      member:{},
      shift:(getCookie('shift')!==null)?JSON.parse(getCookie('shift')):null,
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
      account_name:null,
      account_bank:null,
      account_number:null,
      account_trans_number:null,
      isPayCard:false,
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
      chooseBank(bank) {
        this.account_bank = bank;
      },
      setAccountNumber(number){
        this.account_number = number;
      },
      setAccountName(name){
        this.account_name = name;
      },
      setTransactionNumber(number) {
        this.account_trans_number = number;
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
      clear() {
        this.cash = 0;
        this.disc = 0;
        this.cart = [];
        this.receiptNo = null;
        this.receiptDate = null;
        this.updateChange();
        //this.clearSound();
        this.member = {};
        this.table = {};
        this.amount = 0;
        this.payMethod="cash";
        this.account_name=null;
        this.account_bank=null;
        this.account_number=null;
        this.account_trans_number=null;
        this.isPayCard=false;
        this.isPayTransfer=false;
        this.isPayCash=true;
        this.pay_refNumber=null;
        this.pay_note=null;
      },
      beep() {
        this.playSound("sound/beep-29.mp3");
      },
      clearSound() {
        this.playSound("sound/button-21.mp3");
      },
      clearDiscount() {
        this.disc = 0;
        this.updateChange();
      },
      playSound(src) {
        const sound = new Audio();
        sound.src = src;
        sound.play();
        sound.onended = () => delete(sound);
      },
      chooseMenu(type) {
        if(type=="table"){
          this.activeMenu = type;
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
        }if(method==="card"){
          this.updateCashPay(this.getTotalPrice());
          this.isPayCard = true;
          this.payMethod = "card";
        }if(method==="bank_transfer"){
          this.updateCashPay(this.getTotalPrice());
          this.isPayTransfer = true;
          this.payMethod = "bank_transfer";
        }
        this.isPayMethod = false;
      },
      updateCloseCash(value) {
        this.input_closing_cash = parseFloat(value.replace(/[^0-9]+/g, ""));
        console.log("Cash "+this.input_closing_cash);
        this.updateTotalClosing();
      },
      updateCloseCard(value) {
        this.input_closing_card = parseFloat(value.replace(/[^0-9]+/g, ""));
        this.updateTotalClosing();
      },
      updateCloseBankTransfer(value) {
        this.input_closing_banktransfer = parseFloat(value.replace(/[^0-9]+/g, ""));
        this.updateTotalClosing();
      },
      updateNoteClosing(value) {
        this.note_closing = value;
      },
      updateTotalClosing() {
        this.total_closing = this.input_closing_cash + this.input_closing_card + this.input_closing_banktransfer;
        console.log("Total Closing "+this.total_closing);
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
          console.log("Shift Exist "+this.shift);
            this.store = JSON.parse(getCookie('store'));
            this.openingbalance = getCookie('amount_opening');
            this.user = JSON.parse(getCookie('user'));
            this.business = JSON.parse(getCookie('business'));
            this.start_time = getCookie('start_time');
            this.shift = getCookie('shift');
            this.pos_id = getCookie('pos_id');
            this.exist_user ={};
            this.exist_store={};
            this.exist_shift=0;
            this.exist_sessionPos=null;
            this.exist_business={};
            this.exist_startTime=null;
            this.exist_prefixes=null;
            this.exist_balance=0;
            this.exist_pos_id = null;
            this.params_store={};
            this.params_balance=0;
            this.params_shift=0;
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
        this.isopenDetail = false;
        this.closeCashier = false;
      },
      closeModalMember() {
        this.isShowMember = false;
      },
      OpenRegisterDetail(){
        this.isopenDetail = true;
        this.getDetailAmountTransaction(this.pos_id);

      },
      closeModalCloseCashier() {
        this.closeCashier = false;
      },
      closeModalPosDetail(){
        this.isopenDetail = false;
      },
      submit(){
        console.log("Submit");
      },
      submitable() {
        return  Object.keys(this.member).length > 0 && this.cart.length > 0;
      },
      submitClosing() {
        return  this.total_closing > 0;
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
        if(table.pos_transaction!==null){
          this.table = table;
          this.item_transaction = table.pos_transaction;
          this.item_transaction_id = table.pos_transaction.id;
           this.cart = [];
          this.getDataMemberLines(table.pos_transaction.id);
          this.getDataProductsLines(table.pos_transaction.id);
          this.pilih_table = table;
          this.chooseMenu("pos");
          console.log("CLICK TABLE "+JSON.stringify(table));
        }else{
          this.pilih_table = table;
          this.chooseMenu("pos");
          console.log("CLICK TABLE "+JSON.stringify(table));
        }
      },
      
      // optionsSelect//
      async getDataMemberLines($id) {
        const endpoint = 'http://localhost:8080/posmain/getMemberLines/'+$id; // Or any other specific endpoint
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.member = data.customer;
       
      },
      async getDataProductsLines($id) {
        const endpoint = 'http://localhost:8080/posmain/getProductsLines/'+$id; // Or any other specific endpoint
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        for await (const foodMenu of data.product) {
           this.cart.push({
            foodMenuId: foodMenu.id,
            image: foodMenu.picture,
            name: foodMenu.name,
            price: foodMenu.sell_price,
            option: "",
            category:foodMenu.category_id,
            qty: parseFloat(foodMenu.quantity)
          });
        }
      },
      //OpeningForm//
      openingStoreList(){
        return this.listofStore;
      },
      submitOpeningStore(){
        this.checkOpenShift();
      },
      submitClosingStore(){
        this.closeCashier = true;
      },
      submitEndCashier(){
        this.formClosing();
      },
      getStartTime(type){
        let Result = null;
        var getDate = getFormatDate(this.start_time);
        var getTime = getFormatTime(this.start_time);
        if(type==="date"){
          Result = getDate;
        }else{
          Result = getTime;
        }
        return Result;
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
            console.log("DATA SUCCESS "+JSON.stringify(data));
            if(data.data !== null){
              console.log("data.data !==null");
              this.exist_pos_id = data.data.id;
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
                        document.cookie = "pos_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
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
      
      async getTransactionPending() {
        try {
          const myData = {
                location_id: JSON.parse(getCookie('store')).id,
                status:"hold"
              };
          const csrfToken = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');
          const response = await fetch('http://localhost:8080/widget/pending_transaction', {
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
            if(this.transaction_pending.length > 0){
              this.transaction_pending = [];
            }
            if(data.data !== null){
              console.log("Transaction Pending ada ");
              this.transaction_pending = data.data;
            }else{

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
              console.log("DATA EXIST Start SHIft"+JSON.stringify(data));
              setCookie("pos_id",this.exist_pos_id);
              setCookie("session_pos",this.exist_sessionPos);
              setCookie("start_time",this.exist_startTime);
              setCookie("store",JSON.stringify(this.exist_store));
              setCookie("store_setup",JSON.stringify(this.store_setup));
              setCookie("amount_opening",this.exist_balance);
              setCookie('shift',this.exist_shift);
              this.reUpdateProducts();
              this.existShift = false;
          }if(data.status === "add"){
            console.log("DATA ADD Start SHIft"+JSON.stringify(data));
              setCookie("pos_id",data.data);
              setCookie("prefix","POS");
              setCookie("session_pos",this.exist_sessionPos);
              setCookie("start_time",this.exist_startTime);
              setCookie("store",JSON.stringify(this.exist_store));
              setCookie("amount_opening",this.exist_balance);
              setCookie('shift',this.exist_shift);
              this.firstBalance = false; 
              this.initialData();
              this.addUpdateProducts();
              console.log("ADD");
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
                      document.cookie = "pos_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
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
                      document.cookie = "pos_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
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
      async addUpdateProducts() {
        const storeId = this.store.id;
        const endpoint = 'http://localhost:8080/posmain/getProducts/'+storeId; // Or any other specific endpoint
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.products = data.product;
        this.category = data.category;
        this.loadTablePos();
      },
      async reUpdateProducts() {
        const storeId = this.store.id;
        const endpoint = 'http://localhost:8080/posmain/getProducts/'+storeId; // Or any other specific endpoint
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.products = data.product;
        this.category = data.category;
        this.loadTablePos();
        this.initialData();
      },
      async submitransaction() {
        const getPayment ={
            payMethod:this.payMethod,
            amount:this.amount,
            change:this.change,
            account_name:this.account_name,
            account_bank:this.account_bank,
            account_number:this.account_number,
            account_trans_number:this.account_trans_number
        }
        try {
          const myData = {
              transaction_id:this.item_transaction_id,
              pos_id:this.pos_id,
              start_time: getBaseDate(),
              hold:this.holdOrder,
              store: this.store,
              user:this.user,
              table:this.pilih_table,
              customer:this.member,
              items:this.cart,
              discount:this.disc,
              sub_total:this.subTotal,
              total:this.getTotalPrice(),
              shift:this.shift,
              ref_no:this.receiptNo,
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
              this.clear();
              this.initialData();
              this.closeAllForm();
              this.chooseMenu("table");
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
      async formClosing() {
                   Swal.fire({
                  title: 'Periksa Terlebih dahulu Data Tutup Cashier ? ',
                  text: "Silahkan tekan tombol Lanjutkan atau batalkan",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Lanjutkan',
                  cancelButtonText: 'Batalkan'
                }).then((result) => {
                  if (result.isConfirmed) {
                    this.processClosing();
                  } else if (result.dismiss === Swal.DismissReason.cancel) {
                        this.closeCashier = false;
                      }
                  });
  
      },
      // FUNCTION GET DETAIL AMOUNT TRANSACTION//
      async getDetailAmountTransaction($id) {
        const endpoint = 'http://localhost:8080/posmain/getSummaryTransaction/'+$id; // Or any other specific endpoint
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const get = await response.json();
        const data = get.transactions;
        this.Total_Transaction = data.Total_Transaction;
        this.Amount_Transaction = data.Amount_Transaction;
        this.Total_Card = data.Total_Card;
        this.Total_Cash = data.Total_Cash;
        this.Total_Bank_Transfer = data.Total_Bank_Transfer;
        this.Total_Pending = data.Total_Pending;
        this.Amount_Card = data.Amount_Card;
        this.Amount_Cash = data.Amount_Cash;
        this.Amount_Bank_Transfer = data.Amount_Bank_Transfer;
        this.Amount_Pending = data.Amount_Pending;
        console.log("Detail Amount Transaction "+JSON.stringify(data));
      },

      async processClosing(){
        try {
          const myData = {
              pos_id:this.pos_id,
              store: this.store,
              shift:this.shift,
              user:this.user,
              session:getCookie('session_pos'),
              close_at:getBaseDate(),
              closing_amount:this.total_closing,
              note:this.note_closing,
              total_cash:this.input_closing_cash,
              total_card:this.input_closing_card,
              total_bank_transfer:this.input_closing_banktransfer
            };
            const csrfToken = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');
            const response = await fetch(this.urlServer+'posmain/closeShift', {
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
              this.clear();
              this.closeAllForm();
              document.cookie = "pos_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
              document.cookie = "session_pos=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
              document.cookie = "store=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
              document.cookie = "store_setup=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
              document.cookie = "business=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
              document.cookie = "shift=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
              document.cookie = "start_time=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
              document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
              document.cookie = "prefix=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
              document.cookie = "amount_opening=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
              window.location.replace('/'+data.redirect);
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
      }
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
      getCategory: async () => await db.getAll("category"),
      getProducts: async () => await db.getAll("products"),
      addCategory: async (category) => await db.add("category", category),
      editCategory: async (category) =>
        await db.put("category", category),
      addProduct: async (product) => await db.add("products", product),
      editProduct: async (product) =>
        await db.put("products", product),
      deleteProduct: async (product) => await db.delete("products", product.id),
    };
  }
