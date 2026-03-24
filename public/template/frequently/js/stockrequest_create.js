$(function() {
    "use strict";
    let base_url = $("#baseUrl").val();
    const button = document.getElementById("create_btn");
    const prevBtn = document.getElementById("prev_btn");
    const nextBtn = document.getElementById("next_btn");
    let currentPage = 0;
    let totalPages = 0;
    let rowsPerPage = 8;
    let dataReq = null;
    let totalData = 0;
    $(document).ready(function() {
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
        button.addEventListener("click", handleClick);
        prevBtn.addEventListener("click", prevPage);
        nextBtn.addEventListener("click", nextPage);
        function handleClick() {
            console.log("Button clicked!");
            checkParStock();
        };

        function checkParStock(){
            fetch(base_url+'apis/get_CheckParStock')
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
                                    <td style="width: 12%">
                                        <input type="number" name="qty[${data.item_id}_${data.warehouse_id}_${data.par_stock}_${data.stock_on_hand}]" class="form-control jumlah" value="0" step="any">
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
            //let jsonData = JSON.parse(dataReq);
            const indexToRemove = dataReq.findIndex(item => item.item_id_stock === itemId.toString());
            //console.log(indexToRemove);
            if (indexToRemove !== -1) {
                // Remove 1 element starting from the found index
                dataReq.splice(indexToRemove, 1);
                
            }
            console.log(dataReq);
        });

        $('#stockrequest_form').on('submit', function(e) {
            const myForm = document.querySelector('#stockrequest_form');
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
                    const data = Object.fromEntries(formData.entries());
                    fetch(base_url +'purchase/stockrequest/create_process', { // Replace '/auth/login' with your CI4 login route
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        //const formData = new FormData(myForm);
                        body: JSON.stringify(data)// Send your data as JSON
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

        function extractTableData(tableId) {
            const table = document.getElementById(tableId);
            if (!table) return null;

            const data = [];
            // Get all rows from the table body
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const rowData = [];
                // Get all cells (td) in the row
                const cells = row.querySelectorAll('td');
                cells.forEach(cell => {
                    // Check if the cell contains form elements (input, select, textarea)
                    const inputElement = cell.querySelector('input, select, textarea');
                    if (inputElement) {
                        rowData.push(inputElement.value);
                    } else {
                        // Otherwise, get the plain text content
                        rowData.push(cell.textContent.trim());
                    }
                });
                data.push(rowData);
            });
            return data;
        }

        function getTableData(tableId) {
            const table = document.getElementById(tableId);
            const rows = table.rows; // Get all <tr> elements
            const data = [];
            
            // Assuming the first row is a header, start from index 1
            for (let i = 1; i < totalPages.length; i++) {
                for (let i = 1; i < rows.length; i++) {
                    const row = rows[i];
                    const rowData = {};
                    // Iterate through cells (<td>)
                    for (let j = 0; j < row.cells.length; j++) {
                        const cell = row.cells[j];
                        // Use cell index or some other logic to assign a key (e.g., "columnName_j")
                        // For simplicity, using a generic key here
                        rowData[`col_${j}`] = cell.textContent.trim();
                    }
                    data.push(rowData);
                }
            }
            return data; // This will be an array of objects
        }

    });
    
});