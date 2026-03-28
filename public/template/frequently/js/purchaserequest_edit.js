$(function() {
    "use strict";
    let base_url = $("#baseUrl").val();
    const prevBtn = document.getElementById("prev_btn");
    const nextBtn = document.getElementById("next_btn");
    let currentPage = 0;
    let totalPages = 0;
    let rowsPerPage = 8;
    let dataReq = null;
    $(document).ready(function() {
        checkPurchaseRequest();
        let totalData = 0;
        var submitButton = document.getElementById("btn_submit");
        
        if(document.getElementById("status").value === 'Approved'){
            submitButton.style.visibility = "hidden";
        }
        var resetButton = document.getElementById("btn_reset");
        resetButton.disabled = true;
        resetButton.style.visibility = "hidden";
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
                                    `<tr id="detail-${runningIndex}" ${data.deleted==1 ?`class="disabled-cell"`:``}>
                                    <td>${runningIndex}</td>
                                    <td>${data.item_sku}</td>
                                    <td>${data.index_id}</td>
                                    <td>${data.sr_line_id}</td>
                                    <td>${data.warehouse_name}</td>
                                    <td class="name-detail">${data.item_name}</td>
                                    <td class="parstock-detail">${data.par_stock}</td>
                                    <td class="stock-detail">${data.stock_on_hand}</td>
                                    <td style="width: 12%">
                                        <input type="number" name="qty[${data.index_id}_${data.item_id}_${data.warehouse_id}_${data.par_stock}_${data.stock_on_hand}]" class="form-control jumlah" value="${numberFormat(parseFloat(data.request_stock).toString())}" step="any">
                                    </td>
                                    <td>${data.main_unit}</td>
                                    <td class="date-stock">${getDate}</td>
                                    <td><button type="button" class="btn btn-danger btn-sm remove-detail" data-id="${runningIndex}" data-item="${data.item_id_stock}" data-index_id="${data.index_id}">Remove</button></td>
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
            removeItemPR(index_id,trans_id);
        });
       
        function checkStockRequest($id){
            fetch(base_url+'apis/get_StockRequestLines?keyword='+$id)
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

        $('#purchaserequest_form_changes').on('submit', function(e) {
            const myForm = document.querySelector('#purchaserequest_form_changes');
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
                    fetch(base_url +'purchase/purchaserequest/changes', { // Replace '/auth/login' with your CI4 login route
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
                                        title: "Success Updated",
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

        function checkPurchaseRequest(){
            fetch(base_url+'apis/get_PurchaseRequestLines?keyword='+document.getElementById("transaction_id").value)
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

        function removeItemPR($id,$transaction_id){
            fetch(base_url+'apis/post_removePRItem?keyword='+$id+'_'+$transaction_id)
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