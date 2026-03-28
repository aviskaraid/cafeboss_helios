$(function() {
    "use strict";
    console.log(userData);
    var supplierId = userData.supplier_id;
    let base_url = $("#baseUrl").val();
    const discount_view = document.getElementById('discount_view');
    const delivery_charge_view = document.getElementById('delivery_charge_view');
    const prevBtn = document.getElementById("prev_btn");
    const nextBtn = document.getElementById("next_btn");
    const createBtn = document.getElementById("create_btn");
    const btnSave = document.getElementById("btnSave");
    const form_supplier = document.getElementById("form_supplier");
    const form_remark = document.getElementById("form_remark");
    const form_payment = document.getElementById("form_payment");
    const form_date = document.getElementById("form_date");
    document.getElementById('taktikal_status').value = 0;
    createBtn.disabled = true;
    btnSave.disabled = true;
    let currentPage = 0;
    let totalPages = 0;
    let rowsPerPage = 8;
    let dataReq = null;
    $(document).ready(function() {
        let totalData = 0;
        checkSupplier();
        document.getElementById("transaction_date").value = userData.transaction_date.substring(0, 10); 
        document.getElementById("due_date").value = userData.due_date.substring(0, 10); 
        document.getElementById("delivery_date").value = userData.delivery_date.substring(0, 10);
        document.getElementById("remark").value = userData.remark;
        document.getElementById("remark_delivery").value = userData.remark_delivery;
        const myInput = document.getElementById("sub_total");
        const myInput_view = document.getElementById("sub_total_view");
        myInput.setAttribute("value", Math.trunc(userData.subtotal));
        myInput_view.setAttribute("value", numberFormat(Math.trunc(userData.subtotal)));
        document.getElementById("discount").value = Math.trunc(userData.discount);
        document.getElementById("discount_view").value = numberFormat(Math.trunc(userData.discount));
        document.getElementById("delivery_charge").value = Math.trunc(userData.delivery_charges);
        document.getElementById("delivery_charge_view").value = numberFormat(Math.trunc(userData.delivery_charges));
        document.getElementById("vat").value = numberFormat(Math.trunc(userData.vat));
        document.getElementById("total").value = Math.trunc(userData.amount);
        document.getElementById("total_view").value = numberFormat(Math.trunc(userData.amount));
        
        
        checkPurchaseOrder(userData.id);
        $('.delivery_date').datepicker({
            format: 'yyyy-mm-dd', // Customize the date format
            autoclose: true,     // Automatically close after date selection
            todayHighlight: true // Highlight today's date
        });
        $('.transaction_date').datepicker({
            format: 'yyyy-mm-dd', // Customize the date format
            autoclose: true,     // Automatically close after date selection
            todayHighlight: true // Highlight today's date
        });
        $('.due_date').datepicker({
            format: 'yyyy-mm-dd', // Customize the date format
            autoclose: true,     // Automatically close after date selection
            todayHighlight: true // Highlight today's date
        });
        prevBtn.addEventListener("click", prevPage);
        nextBtn.addEventListener("click", nextPage);
        function initialData(data){
            currentPage = 1;
            totalPages = Math.ceil(data.length / rowsPerPage);
            displayTable(data,currentPage);
        };
        function displayTable(data,page) {
            const getDate =  document.getElementById("now_date").value;
            const tableBody = document.querySelector("#detail_list");
            tableBody.innerHTML = "";
            
            // Logic Slice
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            // const paginatedItems = data.slice(start, end);
            const paginatedItems = data;

            // Buat Baris <tr>
            paginatedItems.forEach((data,index) => {
                const runningIndex = start + index + 1;
                tableBody.innerHTML += 
                                    `<tr id="detail-${runningIndex}">
                                    <td>${runningIndex}</td>
                                    <td>${data.item_sku}</td>
                                    <td>${data.warehouse_name}</td>
                                    <td class="name-detail">${data.item_name}</td>
                                    <td class="parstock-detail">${data.par_stock}</td>
                                    <td class="stock-detail">${data.stock_on_hand}</td>
                                    <td class="price-detail"><input type="text" class="form-control input_price_detail" name="pricedetail[${data.index_id}_${data.item_id}_${data.warehouse_id}_${data.par_stock}_${data.stock_on_hand}]" value="${Math.trunc(data.price)}"></td>
                                    <td style="width: 12%">
                                        <input type="number" name="qty[${data.index_id}_${data.item_id}_${data.warehouse_id}_${data.par_stock}_${data.stock_on_hand}]" class="form-control jumlah" 
                                        value="${Math.trunc(data.purchase_stock)}" step="any">
                                    </td>
                                    <td>${data.main_unit}</td>
                                    <td class="total-price">${Math.trunc(data.purchase_stock) * Math.trunc(data.price)}</td>
                                    <td class="date-stock">${getDate}</td>
                                    <td><button type="button" class="btn btn-danger btn-sm remove-detail" data-id="${runningIndex}" data-item="${data.item_id_stock}">Remove</button></td>
                                </tr>`;
            });

            // Update info halaman di UI (opsional)
            document.querySelector("#page-info").innerText = `Halaman ${currentPage} dari ${totalPages}`;
        };

        function nextPage() {
            if (currentPage < totalPages) {
                currentPage++;
                totalPages = Math.ceil(dataReq.length / rowsPerPage);
                displayTable(dataReq,currentPage);
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                 totalPages = Math.ceil(dataReq.length / rowsPerPage);
                displayTable(dataReq,currentPage);
            }
        }

        $(document).on("click", ".remove-detail", function() {
             let detailID = $(this).data("id");
            let itemIdStock = $(this).data("item");
            let index_id = $(this).data("index_id");
            let trans_id = document.getElementById('transaction_id').value;
            console.log(index_id+" "+trans_id);
            $("#detail-" + detailID).remove();
            const indexToRemove = dataReq.findIndex(item => item.item_id_stock === itemIdStock.toString());
            if (indexToRemove !== -1) {
                dataReq.splice(indexToRemove, 1);
            }
            removeItemPO(index_id,trans_id);
        });
       
        function checkPurchaseOrder($id,$supplier = null){
            fetch(base_url+'apis/get_PurchaseOrderLines?keyword='+$id+'&supplier='+$supplier+'&selected='+0)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    totalData = parseFloat(data.length);
                    dataReq = data;
                    initialData(data);
                    if(totalData > 0){
                        form_supplier.classList.remove('card-disabled');
                        form_date.classList.remove('card-disabled');
                        form_payment.classList.remove("card-disabled");
                        form_remark.classList.remove("card-disabled");
                        btnSave.disabled = false;
                    }else{
                        form_supplier.classList.add('card-disabled');
                        form_date.classList.add('card-disabled');
                        form_remark.classList.add('card-disabled');
                        form_payment.classList.add('card-disabled');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        };

        $('#purchaseorder_form_edit').on('submit', function(e) {
            const myForm = document.querySelector('#purchaseorder_form_edit');
            e.preventDefault();
            if (totalData > 0 &  document.getElementById("pr_id").value.length >0) {
                Swal.fire({
                    title: 'Are you sure you Want Proceed Form ? ',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, submit Form!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                    showLoader();
                    const formData = new FormData(myForm);
                    //const data = Object.fromEntries(formData.entries());
                    fetch(base_url +'purchase/purchaseorder/changes', { // Replace '/auth/login' with your CI4 login route
                        method: 'POST',
                        // headers: {
                        //     'Content-Type': 'application/json'
                        // },
                        //const formData = new FormData(myForm);
                        body: formData// Send your data as JSON
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status!==200) {
                                var err = data.data.errors;
                                Swal.fire({
                                        position: "center",
                                        icon: "error",
                                        title: JSON.stringify(err),
                                        showConfirmButton: false,
                                        timer: 2500
                                    });
                                }else{
                                    console.log(data);
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success Changed",
                                        text: data.message,
                                        showConfirmButton: false,
                                        timer: 2500,
                                        willClose: () => {
                                            window.location.replace('/'+data.data.redirect);
                                        }
                                    });
                                }
                        })
                        .catch(error => {
                        console.error('Error:', error.message);
                            try {
                                Swal.fire({
                                    position: "center",
                                    icon: "error",
                                    title: error.message,
                                    showConfirmButton: false,
                                    timer: 2500
                                    });
                            } catch (e) {
                                console.log('Error message is not JSON:', error.message);
                            }
                        });
                    }else if(result.dismiss === Swal.DismissReason.cancel){
                        Swal.fire({
                            position: "center",
                            icon: "info",
                            title: "Cancelled",
                            showConfirmButton: false,
                            timer: 2500
                });
            }        
        });
            }else{
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "Department must be filled in || Data tdak boleh kosong",
                    showConfirmButton: false,
                    timer: 2500
                    });            
            }
        });


        $(document).on("input", ".input_price_detail", function() {
            let row = $(this).closest("tr");
            // let stok = parseFloat(row.find(".stock-detail").text()) || 0;
            let Price = parseFloat($(this).val()) || 0;
            console.log("Price "+Price);
            let getQty = row.find(".jumlah").val();
            let QtyDetail = parseFloat(getQty.replace(/\./g, "").replace(/\./g, ""));
            let totalPrice = QtyDetail*Price;
            console.log("Price Detail "+QtyDetail);
            console.log("Total Price "+totalPrice);
            row.find(".total-price").text(numberFormat(String(totalPrice)));
            hitungTotal();
            
        });

        $(document).on("input", ".jumlah", function() {
            let row = $(this).closest("tr");
            let jumlah = parseFloat($(this).val()) || 0;
            console.log("Jumlah "+jumlah);
            let getPriceDetail = row.find(".input_price_detail").val();
            let priceDetail = parseFloat(getPriceDetail.replace(/\./g, "").replace(/\./g, ""));
            let totalPrice = priceDetail*jumlah;
            console.log("Price Detail "+getPriceDetail);
            console.log("Total Price "+totalPrice);
            row.find(".total-price").text(numberFormat(String(totalPrice)));
            hitungTotal();
            
        });

        discount_view.addEventListener('keyup', function(event) {
            if (event.which >= 37 && event.which <= 40) {
            event.preventDefault();
                return;
            }
            if (this.value.length > 2) {
                discount_view.value = numberFormat(this.value, 2, '.', '');
                document.getElementById("discount").value = parseFloat(this.value.replace(/\./g, "").replace(/\./g, ""));
            }else{
                if ($(this).val() == "") {
                        $(this).val('0');
                         document.getElementById("discount").value = 0;
                    }
            }
            hitungTotal();
            
        });

        delivery_charge_view.addEventListener('keyup', function(event) {
            if (event.which >= 37 && event.which <= 40) {
            event.preventDefault();
                return;
            }
            if (this.value.length > 2) {
                delivery_charge_view.value = numberFormat(this.value, 2, '.', '');
                document.getElementById("delivery_charge").value = parseFloat(this.value.replace(/\./g, "").replace(/\./g, ""));
            }else{
                if ($(this).val() == "") {
                        $(this).val('0');
                         document.getElementById("delivery_charge").value = 0;
                    }
            }
            hitungTotal();
            
        });

        document.getElementById("vat").addEventListener('input', function(event) {
        // Access the current value of the input field
            const currentValue = event.target.value;
            let subTotal = document.getElementById("sub_total").value;
            let subTotal_view = document.getElementById("sub_total_view").value;
            // let vatNominal = parseFloat(currentValue) || 0;
            // let percentVat = vatNominal/100;
            // let TotalVat = parseFloat(subTotal) + (parseFloat(subTotal)*percentVat);
            // let totalView = numberFormat(String(TotalVat));
            // const myInput = document.getElementById("total");
            // const myInput_view = document.getElementById("total_view");
            // myInput.setAttribute("value", TotalVat);
            // myInput_view.setAttribute("value", totalView);
            hitungTotal();
        });
        

        function hitungTotal() {
            let subtotal = 0;
            $(".total-price").each(function() {
            let price = parseFloat($(this).text().replace(/\./g, "").replace(/\./g, ""));
                //let harga = parseInt($(this).text().replace(/\D/g, "")) || 0;
            subtotal += price;
            });
            let subtotalView = numberFormat(String(subtotal));
            
            const myInput = document.getElementById("sub_total");
            const myInput_view = document.getElementById("sub_total_view");
            myInput.setAttribute("value", subtotal);
            myInput_view.setAttribute("value", subtotalView);
            // discount = 
            let valueDisc = parseFloat(document.getElementById("discount").value || 0);
            let totalafterDisc = 0;
            let totalViewafterDisc = 0;
            totalafterDisc = subtotal-valueDisc;
            totalViewafterDisc = numberFormat(String(totalafterDisc));
            console.log("TOTAL AFTER "+totalafterDisc);
            // end discount

            // Vat = 
            let valueDelv = parseFloat(document.getElementById("delivery_charge").value || 0);
            let totalafterDelv = 0;
            let totalViewafterDelv = 0;
            totalafterDelv = totalafterDisc+valueDelv;
            totalViewafterDelv = numberFormat(String(totalafterDelv));
            console.log(totalafterDelv);
            // end Vat

             // Vat = 
            let valuevAT = parseFloat(document.getElementById("vat").value || 0);
            let totalaftervAT = 0;
            let totalViewaftervAT = 0;
            let vat = parseFloat(valuevAT/100);
            totalaftervAT = totalafterDelv+(parseFloat(totalafterDelv)*vat);
            totalViewaftervAT = numberFormat(String(totalaftervAT));
            console.log(totalaftervAT);
            // end Vat
            // TOTAL = 
            document.getElementById("total").value = totalaftervAT;
            document.getElementById("total_view").value = totalViewaftervAT;
        }

        function checkSupplier(){
            fetch(base_url+'apis/get_supplier?keyword='+supplierId)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    console.log(data[0]);
                    const selectElement = $('#filter_supplier');
                    const option = new Option(data[0].name, data[0].id, true, true); 
                    selectElement.append(option).trigger('change');
                    selectElement.trigger({
                        type: 'select2:select',
                        params: {
                            data: data
                        }
                    });
                    document.getElementById("input_supplier").value=$('#filter_supplier').val();
                    document.getElementById("input_supplier_address").value = data[0].address;
                    document.getElementById("filter_supplier").disabled = true;
                    document.getElementById("input_supplier_address").disabled = true;
                    document.getElementById("taktikal_on").disabled = true;
                    document.getElementById("taktikal_on").disabled = true;
                    if(userData.taktikal ==="1"){
                        document.getElementById("taktikal_on").checked = true;
                        document.getElementById("taktikal_off").checked = false;
                        document.getElementById("filter_taktikal").disabled = true;
                        document.getElementById("input_taktikal_contract").value = userData.taktikal;
                        checkTaktikal(userData.taktikal);
                    }else{
                        document.getElementById("filter_taktikal").disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        };
        function checkTaktikal($id){
            fetch(base_url+'apis/get_taktikal_byid?keyword='+$id)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    console.log(data[0]);
                    const selectElement = $('#filter_taktikal');
                    const option = new Option(data[0].ref_no+" | "+data[0].supplier_name, data[0].id, true, true); 
                    selectElement.append(option).trigger('change');
                    selectElement.trigger({
                        type: 'select2:select',
                        params: {
                            data: data
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        };

        function removeItemPO($id,$transaction_id){
            fetch(base_url+'apis/post_removePOItem?keyword='+$id+'_'+$transaction_id)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        };
    });
    
});