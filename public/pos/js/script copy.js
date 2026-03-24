  function getCookie(naming){
        const nameEQ = naming + "=";
        const ca = document.cookie.split(";");
        for (let i = 0; i < ca.length; i++) {
          let c = ca[i];
          while (c.charAt(0)=== ' ') {
            c = c.substring(1,c.length);
          }
          if (c.indexOf(nameEQ)===0){
            return decodeURIComponent(c.substring(nameEQ.length,c.length));
          }
        }
        return null;
    }
  function setCookie(name, value, days) {
      let expires = "";
      if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); // Calculate future date in milliseconds
        expires = "; expires=" + date.toUTCString(); // Format to UTC string
      }
      document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }
  
  function getBaseDate(){
    const now = new Date();
    // Extract individual components
    const year = now.getFullYear();
    const month = (now.getMonth() + 1).toString().padStart(2, '0'); // Month is 0-indexed, add 1
    const day = now.getDate().toString().padStart(2, '0');
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    const customDateTimeString = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    return customDateTimeString;
  }
  function getFormatDate(stringDate){
    const mysqlDatetimeString =stringDate; 

    // 1. Create a Date object from the MySQL datetime string
    const dateObject = new Date(mysqlDatetimeString);

    // 2. Extract and format the date part using toISOString() and slice()
    const dateOnlyISO = dateObject.toISOString().slice(0, 10); // "YYYY-MM-DD"

    // 3. Alternatively, use toDateString() for a more human-readable format
    const dateOnlyReadable = dateObject.toDateString(); // "Thu Oct 26 2023"

    // 4. Or, construct a custom format
    const year = dateObject.getFullYear();
    const month = (dateObject.getMonth() + 1).toString().padStart(2, '0'); // Month is 0-indexed
    const day = dateObject.getDate().toString().padStart(2, '0');
    const customFormattedDate = `${year}-${month}-${day}`; // "YYYY-MM-DD"
    return dateOnlyISO;
  }

  function getFormatTime(stringDate){
    const dateObject = new Date(stringDate);

    // Method 1: Using toTimeString() and slicing
    const timeString1 = dateObject.toTimeString().slice(0, 8); // Extracts HH:MM:SS

    // Method 2: Manually extracting hours, minutes, and seconds
    const hours = dateObject.getHours();
    const minutes = dateObject.getMinutes();
    const seconds = dateObject.getSeconds();

    // Format with leading zeros if needed
    const formattedHours = String(hours).padStart(2, '0');
    const formattedMinutes = String(minutes).padStart(2, '0');
    const formattedSeconds = String(seconds).padStart(2, '0');

    const timeString2 = `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
    return timeString2;
  }

  function getTimer(stringDate){
    const now = new Date().getTime();
    const bookingTime = new Date(stringDate).getTime();
    const distance = now - bookingTime;
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    const formattedHours = String(hours).padStart(2, '0');
    const formattedMinutes = String(minutes).padStart(2, '0');
    const formattedSeconds = String(seconds).padStart(2, '0');
    const timeCount = `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
    return timeCount;
  }
  function splitString(sparat,string){
    const sentence = string;
    const words = sentence.split(sparat);
    return words;
  }
  async function loadDatabase() {
    const db = await idb.openDB("zax_store", 1, {
      upgrade(db, oldVersion, newVersion, transaction) {
        db.createObjectStore("category", {
          keyPath: "id",
          autoIncrement: true,
        });
        db.createObjectStore("products", {
          keyPath: "id",
          autoIncrement: true,
        });
        db.createObjectStore("sales", {
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

  function initApp() {
    //  let base_url = $("#baseUrl").val();
    const app = {
      db: null,
      time: null,
      firstTime: localStorage.getItem("first_time") === null,
      firstBalance:false,
      existShift : false,
      activeMenu: 'pos',
      isopenDetail:false,
      isInputDisc: false,
      isShowTable: false,
      isShowMember: false,
      isShowModalReceipt: false,
      isPayMethod: false,
      loadingSampleData: false,
      moneys: [2000, 5000, 10000, 20000, 50000, 100000],
      concept: ["Dine In", "Take Away"],
      chooseConcept : "Dine In",
      products: [],
      openingbalance:0,
      start_time:null,
      end_time:null,
      holdOrder:false,
      user:{},
      shift:0,
      table:{},
      areatable:{},
      member:{},
      business:{},
      branch:{},
      listBranch:[],
      listAreatable:[],
      listtable:[],
      listMember:[],
      category: [],
      optionSelect:"",
      keywordCat:"",
      keywordArea:"",
      keywordMember:"",
      keyword: "",
      cart: [],
      cash: 0,
      disc: 0,
      change: 0,
      subTotal:0,
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
      receiptNo: null,
      receiptDate: null,
      exist_user:{},
      exist_branch:{},
      exist_shift:0,
      exist_sessionPos:null,
      exist_business:{},
      exist_startTime:null,
      exist_prefixes:null,
      exist_balance:0,
      params_branch:{},
      params_balance:0,
      params_shift:0,
      transaction_pending:[],
      async initDatabase() {
        this.db = await loadDatabase();
        this.loadCategory();
        this.loadProducts();
        this.loadTablePos();
        this.loadMember(); 
        this.loadBranch();
        this.check_openStore();
        this.initialData();
      }, 
      async loadCategory() {
        this.category = await this.db.getCategory();
        console.log("products Category", this.category);
      },
      async loadProducts() {
        this.products = await this.db.getProducts();
        console.log("products loaded", this.products);
      },
      async loadTablePos() {
        this.getTableArea();
        this.getTable();
      },
      async loadMember() {
        this.getMember();
      },
      async loadBranch(){
        this.getAllBranch();
      },
      async start_pos() {
        this.setFirstTime(false);
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
                      document.cookie = "branch=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
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

      },
      async addUpdateProducts() {
        const branchId = this.branch.id;
        const endpoint = 'http://localhost:8080/pos/getProducts/'+branchId; // Or any other specific endpoint
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.products = data.product;
        this.category = data.category;
        for (let product of data.product) {
          await this.db.addProduct(product);
        }
        for (let cat of data.category) {
          await this.db.addCategory(cat);
        }
          await this.loadProducts();
          this.loadTablePos();
      },
      async reUpdateProducts() {
        const branchId = this.branch.id;
        const endpoint = 'http://localhost:8080/pos/getProducts/'+branchId; // Or any other specific endpoint
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.products = data.product;
        this.category = data.category;
        for (let update of data.category) {
          await this.db.editCategory(update);
        }
        for (let update of data.product) {
          await this.db.editProduct(update);
        }
          await this.loadProducts();
          this.initialData();
      },
      async getAllBranch() {
        const endpoint = 'http://localhost:8080/pos/all_branch'; // Or any other specific endpoint
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.listBranch = data;
      },
      async getRowBranch($id) {
        const endpoint = 'http://localhost:8080/pos/row_branch/'+$id; // Or any other specific endpoint
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.params_branch = data;
      },
      async getTableArea() {
        const endpoint = 'http://localhost:8080/tablearea/pos/'+this.branch.id; // Or any other specific endpoint
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.listAreatable = data;
      },
      async getMember() {
        const endpoint = 'http://localhost:8080/customer/pos'; // Or any other specific endpoint
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.listMember = data;
      },
      async getTable() {
        const endpoint = 'http://localhost:8080/table/pos/'+this.branch.id; // Or any other specific endpoint
        const fullURL = `${endpoint}`;
        const response = await fetch(fullURL);
        const data = await response.json();
        this.listtable = data;
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
              concept:this.chooseConcept,
              hold:this.holdOrder,
              branch: this.branch,
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
            const response = await fetch('http://localhost:8080/pos/inputTransaction', {
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
              this.clear();
              this.initialData();
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
      setFirstTime(firstTime) {
        this.firstTime = firstTime;
        if (firstTime) {
          localStorage.removeItem("first_time");
        } else {
          localStorage.setItem("first_time", new Date().getTime());
        }
        this.checkOpenShift();
      },
      initialData(){
        if(getCookie('session_pos')!== null){
            this.branch = JSON.parse(getCookie('branch'));
            this.openingbalance = getCookie('amount_opening');
            this.user = JSON.parse(getCookie('user'));
            this.business = JSON.parse(getCookie('business'));
            this.start_time = getCookie('start_time');
            this.shift = getCookie('shift');
            this.exist_user ={};
            this.exist_branch={};
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
      check_openStore(){
        const s_branch =  getCookie("branch") === null;
        if(s_branch === true){
          this.firstBalance = true;
        }else{
          this.checkOpenShift();
        }
       
      },
      allCategory() {
        return this.category;
      },
      allArea() {
        console.log(this.listAreatable);
        return this.listAreatable;
      },
      allTable() {
        return this.listtable;
      },
      allBranch() {
        return this.listBranch;
      },
      filteredProducts() {
        if(this.keywordCat != ""){
            //const rg = this.keyword ? new RegExp(this.keyword, "gi") : null;
            return this.products.filter((p) => p.category.match(this.keywordCat));
        }else{
            const rg = this.keyword ? new RegExp(this.keyword, "gi") : undefined;
            return this.products.filter((p) => !rg || p.name.match(rg));
        }
      },
      filteredTables() {
        if(this.keywordArea != ""){
            return this.listtable.filter((p) => p.area_id.match(this.keywordArea));
        }else{
            return this.listtable;
        }   
      },
      filteredMembers() {
        if(this.keywordMember != ""){
            return this.listMember.filter((p) => p.fullname.toLowerCase().match(this.keywordMember.toLowerCase()));
        }else{
            return this.listMember;
        }   
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
          this.table = table;
          this.closeModalTable();
        }
      },
      chooseMember(element,member){
        console.log(JSON.stringify(member));
        this.member = member;
        this.closeModalMember();
      },
      chooseBranch(branch) {
        this.getRowBranch(branch);
      },
      chooseBank(bank) {
        this.account_bank = bank;
      },
      setTransactionNumber(number) {
        this.account_trans_number = number;
      },
      setAccountNumber(number){
        this.account_number = number;
      },
      setAccountName(name){
        this.account_name = name;
      },
      chooseShift(shift) {
        const getShift = parseInt(shift);
        this.params_shift = getShift;
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
      setOpeningBalance(value) {
        this.params_balance = parseFloat(value.replace(/[^0-9]+/g, ""));
      },
      async checkOpenShift() {
        const branchParams = (Object.keys(this.params_branch).length === 0)?JSON.parse(getCookie('branch')):this.params_branch;
        try {
          const myData = {
                location_id: branchParams,
              };
          const csrfToken = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');
          const response = await fetch('http://localhost:8080/pos/check_openshift', {
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
              this.exist_branch = data.data.branch;
              this.exist_shift = data.data.shift;
              this.exist_sessionPos = data.data.session_pos;
              this.exist_startTime = data.data.open_at;
              this.exist_business = getCookie('business');
              this.exist_user = JSON.parse(getCookie('user'));
              this.firstBalance = false;
              this.existShift = true;
            }else{
              if(Object.keys(this.params_branch).length > 0 && this.params_balance > 0 && this.params_shift > 0){
                const currentDate = getBaseDate();
                this.exist_startTime = currentDate;
                this.exist_sessionPos = crypto.randomUUID();
                this.exist_branch = this.params_branch;
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
                        document.cookie = "branch=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
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
      async getTransactionPending() {
        try {
          const myData = {
                location_id: JSON.parse(getCookie('branch')).id,
                scope:this.chooseConcept,
                status:"pending"
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
            if(data.data !== null){
              this.transaction_pending = data.data;
            }else{

            }
          }
        } catch (error) {
            console.error('Error:', error);
            // Handle network errors or other exceptions
        }
      },
      async getShiftPOS() {
        try {
          const myData = {
                business_id: this.branch.business_id,
                location_id: JSON.parse(getCookie('branch')).id,
              };
          const csrfToken = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');
          const response = await fetch('http://localhost:8080/pos/get_shift', {
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
             this.existShift = true;
             const currentDate = getBaseDate();
             setCookie("start_time",currentDate);
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
                business_id: this.exist_branch.business_id,
                location_id:this.exist_branch.id,
                shift:this.exist_shift,
                opening_amount:this.exist_balance,
                session_pos:this.exist_sessionPos
              };
          const csrfToken = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');
          const response = await fetch('http://localhost:8080/pos/start_shift', {
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
              setCookie("branch",JSON.stringify(this.exist_branch));
              setCookie("amount_opening",this.exist_balance);
              setCookie('shift',this.exist_shift);
              this.reUpdateProducts();
              this.existShift = false;
          }if(data.status === "add"){
              setCookie("session_pos",this.exist_sessionPos);
              setCookie("start_time",this.exist_startTime);
              setCookie("branch",JSON.stringify(this.exist_branch));
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
                      document.cookie = "branch=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
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
      submitOpeningStore(){
        this.checkOpenShift();
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
      OpenRegisterDetail(){
        this.isopenDetail = true;
      },
      closeModalPosDetail(){
        this.isopenDetail = false;
      },
      OpenPayMethod(){
        this.isPayMethod = true;
      },
      closeModalPayMethod(){
        this.isPayMethod = false;
      },
      addAreaTable(element,content){
        if(content === "all"){
          this.keywordArea = "";
        }else{
          this.keywordArea = content.id;
        }
      },
      addCatActive(element,cat) {
        if(cat === "all"){
          this.keywordCat = "";
        }else{
          
          this.keywordCat = cat.id;
        }

      },
      addToCart(product) {
        const index = this.findCartIndex(product);
        if (index === -1) {
          this.cart.push({
            productId: product.id,
            image: product.image,
            name: product.name,
            price: product.price,
            option: product.option,
            category:product.category,
            qty: 1,
            variationId: product.variation_id
          });
        } else {
          this.cart[index].qty += 1;
        }
        this.beep();
        this.updateChange();
      },
      findCartIndex(product) {
        return this.cart.findIndex((p) => p.productId === product.id);
      },
      addQty(item, qty) {
        const index = this.cart.findIndex((i) => i.productId === item.productId);
        if (index === -1) {
          return;
        }
        const afterAdd = item.qty + qty;
        if (afterAdd === 0) {
          this.cart.splice(index, 1);
          this.clearSound();
        } else {
          this.cart[index].qty = afterAdd;
          this.beep();
        }
        this.updateChange();
      },
      addCash(amount) {
        this.cash = (this.cash || 0) + amount;
        this.amount = this.cash;
        this.updateChange();
        this.beep();
      },
      addConcept(concept){
        this.chooseConcept = concept;
      },
      getItemsCount() {
        return this.cart.reduce((count, item) => count + item.qty, 0);
      },
      updateChange() {
        this.change = this.cash - this.getTotalPrice();
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
      getTotalPrice() {
        this.subTotal = this.cart.reduce(
          (total, item) => total + item.qty * item.price,
          0
        );
        return this.subTotal - this.disc;
      },
      submitable() {
        return this.change >= 0 && this.cart.length > 0;
      },
      submitHoldOrder() {
        return Object.keys(this.table).length > 0 && this.cart.length > 0;
      },
      submitToTableOrder() {
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
                    this.holdOrder = true;
                    this.submitransaction();
                }
            });
      },
      submitToReceipt() {
        if(this.chooseConcept === "Dine In"){
          if(this.table === null  || this.table === undefined || (typeof this.table === 'object' && Object.keys(this.table).length === 0)){
             Swal.fire({
                title: 'Dine In harus pilih meja terlebih dahulu',
                text: "Silahkan Pilih meja terlebih dahulu",
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Close'
            }).then((result) => {
                if (result.isConfirmed) {  
                }
            });
          }else{
             if(this.member === null  || this.member === undefined || (typeof this.member === 'object' && Object.keys(this.member).length === 0)){
              var obj = {};
              obj["username"] = "general";
              obj['fullname'] = "General";
              this.member = obj;
            }
            const time = new Date();
            this.isShowModalReceipt = true;
            const getPrefix = getCookie('prefix');
            this.receiptNo = getPrefix+`-${Math.round(time.getTime() / 1000)}`;
            this.receiptDate = this.dateFormat(time);
          }
        }else{
            if(this.member === null  || this.member === undefined || (typeof this.member === 'object' && Object.keys(this.member).length === 0)){
              var obj = {};
              obj["username"] = "general";
              obj['fullname'] = "General";
              this.member = obj;
            }
            const time = new Date();
            this.isShowModalReceipt = true;
            const getPrefix = getCookie('prefix');
            this.receiptNo = getPrefix+`-${Math.round(time.getTime() / 1000)}`;
            this.receiptDate = this.dateFormat(time);
        }
      },

      closeModalReceipt() {
        this.isShowModalReceipt = false;
      },
      closeModalDisc() {
        this.isInputDisc = false;
      },
      closeModalTable() {
        this.isShowTable = false;
      },
      closeModalMember() {
        this.isShowMember = false;
      },
      closeModalBalance() {
        console.log("tidak bisa close");
      },
      openModalDisc() {
        this.isInputDisc = true;
      },
      openModalTable() {
        this.loadTablePos();
        this.isShowTable = true;
      },
      openModalMember() {
        this.loadTablePos();
        this.isShowMember = true;
      },
      dateFormat(date) {
        const formatter = new Intl.DateTimeFormat('id', { dateStyle: 'short', timeStyle: 'short'});
        return formatter.format(date);
      },
      numberFormat(number) {
        return (number || "")
          .toString()
          .replace(/^0|\./g, "")
          .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
      },
      numberFormatDisplay(number) {
        return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 2, // Ensure at least 2 decimal places
        maximumFractionDigits: 2, // Ensure no more than 2 decimal places
      }).format(number);
    },
      priceFormat(number) {
        return number ? `${this.numberFormatDisplay(number)}` : `Rp. 0`;
      },
      clear() {
        this.cash = 0;
        this.disc = 0;
        this.cart = [];
        this.receiptNo = null;
        this.receiptDate = null;
        this.updateChange();
        this.clearSound();
        this.member = {};
        this.table = {};
        this.amount = 0;
        this.payMethod="cash";
        this.account_name=null;
        this.account_bank=null;
        this.account_number=null;
        this.account_trans_number=null;
        this.isPayDebit=false;
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
      printAndProceed() {
        this.submitransaction();
        const receiptContent = document.getElementById('receipt-content');
        const titleBefore = document.title;
        const printArea = document.getElementById('print-area');

        printArea.innerHTML = receiptContent.innerHTML;
        document.title = this.receiptNo;

        window.print();
        this.isShowModalReceipt = false;

        printArea.innerHTML = '';
        document.title = titleBefore;
        // TODO save sale data to database
        
        this.clear();
      }
    };

    return app;
  }