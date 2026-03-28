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
        let totalData = 0;
        var submitButton = document.getElementById("btn_submit");
        
        if(document.getElementById("status").value === 'Approved'){
            submitButton.style.visibility = "hidden";
        }
        var resetButton = document.getElementById("btn_reset");
        resetButton.disabled = true;
        resetButton.style.visibility = "hidden";
        checkDepartment();
        $('.department').select2({
            multiple: false,
            placeholder: 'Search for an Department',
            ajax: {
            url: base_url+'apis/get_department', // The URL of your API
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
        $('#department').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Warehouse "+id);
            document.getElementById("input_department").value=$('#department').val();
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
            const paginatedItems = data;

            // Buat Baris <tr>
            paginatedItems.forEach((data,index) => {
                let selected = data.selected;
                console.log("selected "+selected);
                const runningIndex = start + index + 1;
                tableBody.innerHTML += 
                                    `<tr id="detail-${runningIndex}">
                                    <td>${runningIndex}</td>
                                    <td>${data.item_sku}</td>
                                    <td>${data.warehouse_name}</td>
                                    <td class="name-detail">${data.item_name}</td>
                                    <td class="parstock-detail">${data.par_stock}</td>
                                    <td class="stock-detail">${data.stock_on_hand}</td>
                                    <td style="width: 12%">
                                        <input type="number" name="qty[${data.index_id}_${data.item_id}_${data.warehouse_id}_${data.par_stock}_${data.stock_on_hand}]" class="form-control jumlah" value="${numberFormat(parseFloat(data.request_stock).toString())}" step="any">
                                    </td>
                                    <td>${data.main_unit}</td>
                                    <td class="date-stock">${getDate}</td>
                                    <td >
                                    ${selected==1 ? '<span class="badge border border-success text-primary"><i class="fas fa-check"></i>' : `
                                    <button type="button" class="btn btn-danger btn-sm remove-detail" data-id="${runningIndex}" data-item="${data.item_id_stock}">Remove</button>`}</td>
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
            //let jsonData = JSON.parse(dataReq);
            const indexToRemove = dataReq.findIndex(item => item.item_id_stock === itemId.toString());
            //console.log(indexToRemove);
            if (indexToRemove !== -1) {
                // Remove 1 element starting from the found index
                dataReq.splice(indexToRemove, 1);
                
            }
            console.log(dataReq);
        });

        $('#stockrequest_form_changes').on('submit', function(e) {
            const myForm = document.querySelector('#stockrequest_form_changes');
            e.preventDefault();
            if (totalData > 0 &  document.getElementById("input_department").value.length >0) {
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
                    fetch(base_url +'purchase/stockrequest/changes', {
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

        function checkDepartment(){
            fetch(base_url+'apis/get_department?keyword='+document.getElementById("input_department").value)
                .then(response => response.json())
                .then(data => {
                     checkStockRequest();
                    console.log(data);
                    console.log(data[0]);
                    const selectElement = $('#department');
                    const option = new Option(data[0].name, data[0].id, true, true); 
                    selectElement.append(option).trigger('change');
                    selectElement.trigger({
                        type: 'select2:select',
                        params: {
                            data: data
                        }
                    });
                    document.getElementById("input_department").value=$('#department').val();
                   
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        };

        function checkStockRequest(){
            fetch(base_url+'apis/get_StockRequestLines?keyword='+document.getElementById("transaction_id").value)
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
    });
    
});