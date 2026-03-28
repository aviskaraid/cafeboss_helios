$(function() {
    "use strict";
    let base_url = $("#baseUrl").val();
    const createBtn = document.getElementById("create_btn");
    const form_gudang = document.getElementById("form_gudang");
    const btnSave = document.getElementById("btnSave");
    btnSave.disabled = true;
    form_gudang.classList.add('card-disabled');
        let currentPage = 0;
    let totalPages = 0;
    let rowsPerPage = 8;
    let dataReq = null;
    $(document).ready(function() {
        let totalData = 0;
       $('.transaction_date').datepicker({
            format: 'yyyy-mm-dd', // Customize the date format
            autoclose: true,     // Automatically close after date selection
            todayHighlight: true // Highlight today's date
        });

        $('.purchase_order').select2({
                placeholder: 'Search for an Gudang',
                ajax: {
                url: base_url+'apis/get_PurchaseOrderHeader', // The URL of your API
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
                                text: item.ref_code +' || '+item.ref_no,
                                raw:item
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
        $('#purchase_order').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            document.getElementById("po_id").value = id; 
            document.getElementById("raw_po").value = JSON.stringify(data.raw);
            
        });

        $('.filter_gudang').select2({
                placeholder: 'Search for an Gudang',
                ajax: {
                url: base_url+'apis/get_warehouse', // The URL of your API
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
                                text: item.name
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
        $('#filter_gudang').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            input_gudang.value=id;
            checkPO(document.getElementById("po_id").value,id);
            
        });

        createBtn.addEventListener("click", ClickCreatePurchaseOrder);
        function ClickCreatePurchaseOrder() {
            checkPO($('#purchase_order').val());
        };

        function checkPO($id,$warehouse = null){
            fetch(base_url+'apis/get_PurchaseOrderLines?keyword='+$id+'&warehouse='+$warehouse+'&selected='+0)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    totalData = parseFloat(data.length);
                    console.log("TOTAL "+totalData);
                    dataReq = data;
                    initialData(data);
                    if(totalData > 0){
                        form_gudang.classList.remove('card-disabled');
                        btnSave.disabled = false;
                    }else{
                        form_gudang.classList.add('card-disabled');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        };

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
                                    <td class="price-detail" style="display:none;"><input type="text" class="form-control input_price_detail" name="pricedetail[${data.index_id}_${data.item_id}_${data.warehouse_id}_${data.par_stock}_${data.stock_on_hand}]" value="${Math.trunc(data.price)}"></td>
                                    <td style="width: 12%;">
                                        <input type="number" name="qty[${data.index_id}_${data.item_id}_${data.warehouse_id}_${data.par_stock}_${data.stock_on_hand}]" class="form-control jumlah" 
                                        value="${Math.trunc(data.purchase_stock)}" step="any">
                                    </td>
                                    <td style="width: 12%;">
                                        <input type="number" name="received[${data.index_id}_${data.item_id}_${data.warehouse_id}_${data.par_stock}_${data.stock_on_hand}]" class="form-control received" 
                                        value="${Math.trunc(data.purchase_stock)}" step="any">
                                    </td>
                                    <td>${data.main_unit}</td>
                                    <td class="total-price">${numberFormat(Math.trunc(data.purchase_stock) * data.price)}</td>
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
        
    });
});