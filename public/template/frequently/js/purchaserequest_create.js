$(function() {
    "use strict";
    let base_url = $("#baseUrl").val();
    const prevBtn = document.getElementById("prev_btn");
    const nextBtn = document.getElementById("next_btn");
    const createBtn = document.getElementById("create_btn");
    createBtn.disabled = true;
    let currentPage = 0;
    let totalPages = 0;
    let rowsPerPage = 8;
    let dataReq = null;
    $(document).ready(function() {
        let totalData = 0;
        prevBtn.addEventListener("click", prevPage);
        nextBtn.addEventListener("click", nextPage);
        createBtn.addEventListener("click", ClickCreatePurchaseReques);
        function ClickCreatePurchaseReques() {
            checkStockRequest($('#stock_request').val());
        };
        $('.stock_request').select2({
            multiple: false,
            placeholder: 'Search Request ID',
            ajax: {
            url: base_url+'apis/get_StockRequestHeader', // The URL of your API
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
                            text: item.ref_code + ' || '+item.ref_no,
                            raw: item
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
        $('#stock_request').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("request_id "+id);
            document.getElementById("request_id").value=$('#stock_request').val();
            document.getElementById("raw_sr").value = JSON.stringify(data.raw);
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
                                    <td>${data.index_id}</td>
                                    <td>${data.warehouse_name}</td>
                                    <td class="name-detail">${data.item_name}</td>
                                    <td class="parstock-detail">${data.par_stock}</td>
                                    <td class="stock-detail">${data.stock_on_hand}</td>
                                    <td style="width: 12%">
                                        <input type="number" name="qty[${data.index_id}_${data.item_id}_${data.warehouse_id}_${data.par_stock}_${data.stock_on_hand}]" class="form-control jumlah" value="${numberFormat(parseFloat(data.request_stock).toString())}" step="any">
                                    </td>
                                    <td>${data.main_unit}</td>
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
           // removeItemPR();
        });
       
        function checkStockRequest($id,$supplier = null){
            fetch(base_url+'apis/get_StockRequestLines?keyword='+$id+'&supplier='+$supplier+'&selected='+0)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    console.log(data.length);
                    totalData = parseFloat(data.length);
                    dataReq = data;
                    initialData(data);
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
                    //const data = Object.fromEntries(formData.entries());
                    fetch(base_url +'purchase/purchaserequest/create_process', { // Replace '/auth/login' with your CI4 login route
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
            console.log("Supplier "+id);
            document.getElementById("input_supplier").value=id;
            checkStockRequest($('#stock_request').val(),id);
        });
    });
    
});