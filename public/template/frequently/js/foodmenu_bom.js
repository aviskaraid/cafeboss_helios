$(function() {
    "use strict";
    let base_url = $("#baseUrl").val();
    let input_warehouse = "";
    let input_bom_item = "";
    const button = document.getElementById("add_btn");   
    $(document).ready(function() {
        const foodmenu_id = document.getElementById("foodmenu_id").value;
        input_warehouse =  $("#input_warehouse").length > 0 ? document.getElementById("input_warehouse").value : 1;
        checkBomExist();
        //   window.onload = checkBomExist; 
        $('.warehouse').select2({
            multiple: false,
            placeholder: 'Search for an Warehouse',
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
        $('#warehouse').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Warehouse "+id);
            input_warehouse = $('#warehouse').val();
            document.getElementById("input_warehouse").value=$('#warehouse').val();
            loadBom(input_warehouse);
        });

        function loadBom(warehouse_id){
            $('.bom').select2({
                multiple: false,
                placeholder: 'Search for an Item Bill Of Material',
                ajax: {
                url: base_url+'apis/get_itemByLocation?keyword='+warehouse_id, // The URL of your API
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
                                id: item.item_id,
                                text: item.item_name+" ## Stock ("+item.stock+") ##"
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
            $('#bom').on('select2:select', function (e) {
                var data = e.params.data;
                var id = data.id;
                console.log("BOM "+id);
                input_bom_item = $('#bom').val();
                document.getElementById("input_bom").value=$('#bom').val();
            });
        }

        button.addEventListener("click", handleClick);
        function handleClick() {
            console.log("Button clicked!");
            console.log("Selected Warehouse: " + input_warehouse);
            console.log("Selected BOM Item: " + input_bom_item);
            getBomCode();
        }

        function getBomCode(){
            fetch(base_url+'apis/get_ItemDetail?keyword='+input_bom_item+"_"+input_warehouse)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if ($("#detail-" + data.item_id).length == 0) {
                        $("#detail_list").append(`
                            <tr id="detail-${data.item_id}">
                                <td>${data.item_id}</td>
                                <td>${data.item_name}</td>
                                <td class="stock-detail">${data.stock}</td>
                                <td class="price-detail">${numberFormat(parseFloat(data.item_sell_price).toString())}</td>
                                <td style="width: 16.66%">
                                    <input type="number" name="qty[${data.item_id}]" class="form-control jumlah" value="0" step="any">
                                </td>
                                <td>${data.main_unit}</td>
                                <td class="total-price">0</td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-detail" data-id="${data.item_id}">Remove</button></td>
                            </tr>
                `       );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        };

        $(document).on("input", ".jumlah", function() {
            let row = $(this).closest("tr");
            let stok = parseFloat(row.find(".stock-detail").text()) || 0;
            let jumlah = parseFloat($(this).val()) || 0;
            console.log("Jumlah "+jumlah);
            // if (jumlah < 0) {
            //     $(this).val(0);
            //     jumlah = 0;
            // } else if (jumlah > stok) {
            //     Swal.fire({
            //         icon: 'warning',
            //         title: 'Stok Tidak Cukup!',
            //         text: 'Jumlah yang dimasukkan melebihi stok tersedia!',
            //     });
            //     $(this).val(stok);
            //     jumlah = stok;
            // }
            let cekPrice = row.find(".price-detail").text();
            let priceDetail = parseFloat(cekPrice.replace(/\./g, "").replace(/\./g, ""));
            let totalPrice = priceDetail*jumlah;
            console.log("Price Detail "+cekPrice);
            console.log("Total Price "+totalPrice);
            row.find(".total-price").text(numberFormat(String(totalPrice)));
            hitungTotal();
            
        });

        function hitungTotal() {
            let total = 0;
            $(".total-price").each(function() {
            let price = parseFloat($(this).text().replace(/\./g, "").replace(/\./g, ""));
                //let harga = parseInt($(this).text().replace(/\D/g, "")) || 0;
            total += price;
            });
            const table = document.getElementById('myTable'); 
            const tfoot = table.querySelector('tfoot');
            if (tfoot) {
                const thElement = tfoot.querySelector("th.total_bomPrice"); 
                thElement.textContent = numberFormat(String(total));
            }
            const myInput = document.getElementById("totalBomPrice");
            myInput.setAttribute("value", total);
        }

        $(document).on("click", ".remove-detail", function() {
            let detailID = $(this).data("id");
            $("#detail-" + detailID).remove();
            hitungTotal();
        });

        $('#foodmenu_bom').on('submit', function(e) {
            const myForm = document.querySelector('#foodmenu_bom');
            e.preventDefault();
            if (parseFloat(document.getElementById("totalBomPrice").value) > 0) {
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
                    fetch(base_url +'master/food_menu/bom_process', { // Replace '/auth/login' with your CI4 login route
                        method: 'POST',
                        // headers: {
                        //     'Content-Type': 'application/json'
                        // },
                        //const formData = new FormData(myForm);
                        body: new FormData(myForm)// Send your data as JSON
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
                console.log("Total BOM Price must be greater than 0");
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "Total BOM Price must be greater than 0",
                    showConfirmButton: false,
                    timer: 2500
                    });            
            }
        });

        function checkBomExist(){
            fetch(base_url+'apis/CheckBomFoodMenu?keyword='+foodmenu_id)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    console.log(data[0]);
                    const selectElement = $('#warehouse');
                    const option = new Option(data[0].warehouse_name, data[0].warehouse_id, true, true); 
                    selectElement.append(option).trigger('change');
                    selectElement.trigger({
                        type: 'select2:select',
                        params: {
                            data: data
                        }
                    });
                    document.getElementById("input_warehouse").value=$('#warehouse').val();
                    data.forEach(data => {
                        if ($("#detail-" + data.item_id).length == 0) {
                            $("#detail_list").append(`
                                <tr id="detail-${data.item_id}">
                                    <td>${data.item_id}</td>
                                    <td>${data.item_name}</td>
                                    <td class="stock-detail">${data.stock}</td>
                                    <td class="price-detail">${numberFormat(parseFloat(data.item_sell_price).toString())}</td>
                                    <td style="width: 16.66%">
                                        <input type="number" name="qty[${data.item_id}]" class="form-control jumlah" value="${parseFloat(data.consumption)}" step="any">
                                    </td>
                                    <td>${data.main_unit}</td>
                                    <td class="total-price">${numberFormat(parseFloat(data.total_cost).toString())}</td>
                                    <td><button type="button" class="btn btn-danger btn-sm remove-detail" data-id="${data.item_id}">Remove</button></td>
                                </tr>
                    `       );
                        }
                    });
                    hitungTotal();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        };
    });
  
});
