$(function() {
    "use strict";
    let base_url = $("#baseUrl").val();
    const prevBtn = document.getElementById("prev_btn");
    const nextBtn = document.getElementById("next_btn");
    const createBtn = document.getElementById("create_btn");
    const input_supplier = document.getElementById("input_supplier");
    const form_supplier = document.getElementById("form_supplier");
     form_supplier.classList.add('card-disabled');
    const input_taktikal_contract = document.getElementById("input_taktikal_contract");
    const switchTaktikal = document.querySelector(".custom-switches-stacked");
    createBtn.disabled = true;
    let currentPage = 0;
    let totalPages = 0;
    let rowsPerPage = 8;
    let dataReq = null;
    $(document).ready(function() {
        let totalData = 0;
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
        switchTaktikal.addEventListener("change", (event) => {
            const selectedValue = event.target.value;
            document.getElementById('taktikal_status').value=selectedValue;
            //getTaktikalBySupplier();
            if(selectedValue==0){
                $('.filter_taktikal').prop('disabled', true);
                input_taktikal_contract.value = 0;
                console.log("Disable True");

            }else{
                $('.filter_taktikal').prop('disabled', false);
                input_taktikal_contract.value = selectedValue;
                console.log("Disable False");
            }
        });
        prevBtn.addEventListener("click", prevPage);
        nextBtn.addEventListener("click", nextPage);
        createBtn.addEventListener("click", ClickCreatePurchaseOrder);
        function ClickCreatePurchaseOrder() {
            checkPurchaseRequest($('#purchase_request').val());
        };
        $('.purchase_request').select2({
            multiple: false,
            placeholder: 'Search Request ID',
            ajax: {
            url: base_url+'apis/get_PurchaseRequestHeader', // The URL of your API
            dataType: 'json',
            delay: 250, // Wait 250ms after user stops typing to make the request
            data: function(params) {
                return {
                keyword: params.term, // Query parameter name (e.g., 'q' for search term)
                page: params.page
                };
            },
            processResults: function(data, params) {
                const formattedData =  data.map(function(item){ // Assuming apiData has an 'items' array   
                    return {
                            id: item.id,
                            text: item.ref_no
                        };
                    });
                return {
                results: formattedData,
                pagination: {
                    more: (params.page * 30) < data.total_count // Example pagination logic
                }
                };
            },
            cache: true
            },
            minimumInputLength: 0 // Only start searching after the user types 1 character
        });
        $('#purchase_request').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Purchase_Request_id "+id);
            document.getElementById("pr_id").value=$('#purchase_request').val();
            createBtn.disabled = false;
        });
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
                                    <td class="price-detail"><input type="text" class="form-control input_price_detail" name="pricedetail[${data.item_id}_${data.warehouse_id}_${data.par_stock}_${data.stock_on_hand}]" value="${data.purchase_price}"></td>
                                    <td style="width: 12%">
                                        <input type="number" name="qty[${data.item_id}_${data.warehouse_id}_${data.par_stock}_${data.stock_on_hand}]" class="form-control jumlah" value="${data.request_stock}" step="any">
                                    </td>
                                    <td>${data.main_unit}</td>
                                    <td class="total-price">0</td>
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
            let itemId = $(this).data("item");
            console.log(detailID+" "+itemId);
            $("#detail-" + detailID).remove();
            const indexToRemove = dataReq.findIndex(item => item.item_id_stock === itemId.toString());
            if (indexToRemove !== -1) {
                dataReq.splice(indexToRemove, 1);
            }
        });
       
        function checkPurchaseRequest($id,$supplier = null){
            fetch(base_url+'apis/get_PurchaseRequestLines?keyword='+$id+'&supplier='+$supplier+'&selected='+0)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    console.log(data.length);
                    totalData = parseFloat(data.length);
                    dataReq = data;
                    initialData(data);
                    if(totalData > 0){
                         form_supplier.classList.remove('card-disabled');
                    }else{
                        form_supplier.classList.add('card-disabled');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        };

        function getTaktikalBySupplier(){
            fetch(base_url+'apis/get_taktikal_bysupplier?keyword='+input_supplier.value)
                .then(response => response.json())
                .then(data => {
                    if(data.length > 0 ){
                        const selectElement = $('#filter_taktikal');
                        const option = new Option(data[0].ref_no+" | "+data[0].supplier_name, data[0].id, true, true);
                        selectElement.append(option).trigger('change');
                        selectElement.trigger({
                            type: 'select2:select',
                            params: {
                                data: data
                            }
                        });
                        document.getElementById("input_taktikal_contract").value = data[0].id;
                    }else{
                        document.getElementById("input_taktikal_contract").value = 0;
                        const selectElement = $('#filter_taktikal');
                        selectElement.val(null).trigger('change');
                    }
                   
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        };

        $('#purchaserequest_form').on('submit', function(e) {
            const myForm = document.querySelector('#purchaserequest_form');
            e.preventDefault();
            if (totalData > 0 &  document.getElementById("request_id").value.length >0) {
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
                    const data = Object.fromEntries(formData.entries());
                    fetch(base_url +'purchase/purchaserequest/create_process', { // Replace '/auth/login' with your CI4 login route
                        method: 'POST',
                        body: new FormData(myForm)
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
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Success Created",
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

        $('.filter_supplier').select2({
            placeholder: 'Search for an Supplier',
            ajax: {
            url: base_url+'apis/get_supplier', // The URL of your API
            dataType: 'json',
            delay: 250, // Wait 250ms after user stops typing to make the request
            data: function(params) {
                return {
                keyword: params.term, // Query parameter name (e.g., 'q' for search term)
                page: params.page
                };
            },
            processResults: function(data, params) {
                const formattedData =  data.map(function(item){ // Assuming apiData has an 'items' array   
                    return {
                            id: item.id,
                            text: item.name,
                            addressAttr: item.address 
                        };
                    });
                return {
                results: formattedData,
                pagination: {
                    more: (params.page * 30) < data.total_count // Example pagination logic
                }
                };
            },
            cache: true
            },
            minimumInputLength: 0 // Only start searching after the user types 1 character
        });
        $('#filter_supplier').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            var address = data.addressAttr;
            console.log("Supplier "+id);
            console.log("address " +address);
            input_supplier.value=id;
            getTaktikalBySupplier(id);
            checkPurchaseRequest(document.getElementById("pr_id").value,id);
            document.getElementById("input_supplier_address").value = address;
          
        });
        $('.filter_taktikal').select2({
            
            placeholder: 'Search for an Taktikal Contract',
            ajax: {
            url: base_url+'apis/get_taktikal_bysupplier',
            dataType: 'json',
            delay: 250, // Wait 250ms after user stops typing to make the request
            data: function(params) {
                return {
                keyword: input_supplier.value, // Query parameter name (e.g., 'q' for search term)
                page: params.page
                };
            },
            processResults: function(data, params) {
                console.log(data);
                const formattedData =  data.map(function(item){ // Assuming apiData has an 'items' array   
                    return {
                            id: item.id,
                            text: item.ref_no+" | "+item.supplier_name,
                        };
                    });
                return {
                results: formattedData,
                pagination: {
                    more: (params.page * 30) < data.total_count // Example pagination logic
                }
                };
            },
            cache: true
            },
            minimumInputLength: 0 // Only start searching after the user types 1 character
        });
        $('#filter_taktikal').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            document.getElementById("input_taktikal_contract").value=id;
        });

        $(document).on("input", ".jumlah", function() {
            let row = $(this).closest("tr");
            let stok = parseFloat(row.find(".stock-detail").text()) || 0;
            let jumlah = parseFloat($(this).val()) || 0;
            console.log("Jumlah "+jumlah);
            let cekPrice = row.find(".price-detail").text();
            let getPriceDetail = row.find(".input_price_detail").val();
            let priceDetail = parseFloat(getPriceDetail.replace(/\./g, "").replace(/\./g, ""));
            let totalPrice = priceDetail*jumlah;
            console.log("Price Detail "+getPriceDetail);
            console.log("Total Price "+totalPrice);
            row.find(".total-price").text(numberFormat(String(totalPrice)));
            hitungTotal();
            
        });

        document.getElementById("vat").addEventListener('input', function(event) {
        // Access the current value of the input field
            const currentValue = event.target.value;
            let subTotal = document.getElementById("sub_total").value;
            let subTotal_view = document.getElementById("sub_total_view").value;
            let vatNominal = parseFloat(currentValue) || 0;
            let percentVat = vatNominal/100;
            let TotalVat = parseFloat(subTotal) + (parseFloat(subTotal)*percentVat);
            let totalView = numberFormat(String(TotalVat));
            const myInput = document.getElementById("total");
            const myInput_view = document.getElementById("total_view");
            myInput.setAttribute("value", TotalVat);
            myInput_view.setAttribute("value", totalView);

        });

        function hitungTotal() {
            let total = 0;
            $(".total-price").each(function() {
            let price = parseFloat($(this).text().replace(/\./g, "").replace(/\./g, ""));
                //let harga = parseInt($(this).text().replace(/\D/g, "")) || 0;
            total += price;
            });
            let totalView = numberFormat(String(total));
            const myInput = document.getElementById("sub_total");
            const myInput_view = document.getElementById("sub_total_view");
            myInput.setAttribute("value", total);
            myInput_view.setAttribute("value", totalView);
            const myInputTotal = document.getElementById("total");
            const myInput_viewTotal = document.getElementById("total_view");
            myInputTotal.setAttribute("value", total);
            myInput_viewTotal.setAttribute("value", totalView);
        }
    });
    
});