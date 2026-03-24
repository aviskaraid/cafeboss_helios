$(function() {
    "use strict";
    const btnGenerate = document.getElementById("btnGenerateCode");
    btnGenerate.addEventListener("click", function() {
        $.ajax({
            url:base_url + 'master/rnd/generate_rnd_code',
            method:"get",
            dataType:"json",
            success: function(response) {
                document.getElementById('department_code').value = response;
            },
            error: function(data, textStatus, errorThrown) {
                Swal.fire({
                        title: "Error",
                        text:textStatus,
                        icon: "error",
                        draggable: true
                    });
            }
        });
    });
    function hitungTotal(price,qty,total){
        let fPrice = parseFloat(price.value.replace(/[^0-9]+/g, "")) || 0;
        let fqty =  parseFloat(qty.value) || 0;
        let ftotalPrice =  parseFloat(total.value.replace(/[^0-9]+/g, "")) || 0;
        console.log(fPrice);
        console.log(fqty);
        console.log(ftotalPrice);
        total.value = numberFormat(fPrice*fqty);
    }
    function initializeSelect2(selectElementObj,inputData,unit,price,idkey, idSelect) {
       selectElementObj.select2({
            placeholder: 'Search for an Item Units',
            ajax: {
            url: base_url+'apis/get_item_ingredient', // The URL of your API
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
                   item.selected = undefined;
                    if(idkey!==null){
                        if (item.id === idkey) {
                                item.selected = true; // Mark this item as selected
                            }
                    }
                    return {
                        id: item.id,
                        text: item.description,
                        units: item.main_unit, 
                        sell_price: item.sell_price,
                        selected: item.selected // Pass the selected property
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
            minimumInputLength: 0,
            templateSelection: function (data, container) {
            $(data.element).attr("data-units", data.units);
            $(data.element).attr("data-sellprice", data.sell_price);
            
            return data.text;
        },
        });
        selectElementObj.on('select2:select', function (e) {
            let selected = $(this).find(":selected");
            let itemId = selected.val();
            let units = selected.attr("data-units");
            let sellprice = selected.attr("data-sellprice");
            inputData.value = itemId
            unit.value = units 
            price.value = parseFloat(sellprice)
            console.log("itemID "+itemId);
            console.log("units " +units);
        });
    }
    const btnAddIngredient = document.getElementById("btnAddIngredient");
    btnAddIngredient.addEventListener("click", function() {
        let items_id = document.getElementById("rnd_id").value;
        console.log("Add Ingredient");
        console.log("RND Id = "+items_id);
        const table = document.getElementById('myTable'); // Replace 'myTable' with your table's ID
        const tbody = table.getElementsByTagName('tbody')[0];
        const newRowId = `${tbody.children.length+1}`;
        $("#detail_list").append(`
            <tr id="detail-${newRowId}">
                <td style="width: 2%;display:none" style="display:none;">
                    <input type="hidden" name="rnd_id_${newRowId}" value="${items_id}">
                    <input type="text" name="item_id_${newRowId}" id="item_id-${newRowId}">
                </td>
                <td style="width: 20%"> 
                    <select class="ingredient-${newRowId} form-control " id="ingredient_-${newRowId}"></select>
                </td>
                <td style="width: 10%">
                    <input type="text" name="unit_ingredient_${newRowId}" class="form-control unit_ingredient_${newRowId}" id="unit_ingredient-${newRowId}" readonly>
                </td>
                <td style="width: 20%">
                    <input type="number" name="consumption_${newRowId}" class="form-control value_consumption" value="0" step="0.01" id="consumption_ingredient-${newRowId}">
                </td>
                <td style="width: 20%"> 
                    <input type="text" name="price_${newRowId}" class="form-control value_price" value="0" id="price_ingredient-${newRowId}">
                </td>
                <td style="width: 20%">
                    <input type="text" name="total_${newRowId}" class="form-control value_total" value="0" id="total_ingredient-${newRowId}" readonly>
                </td>
                <td style="width: 10%"><button type="button" class="btn btn-danger btn-sm remove-detail" data-id="${newRowId}">Remove</button></td>
            </tr>
`       );
        var newSelect=$("#detail_list").find(".ingredient-"+newRowId).last();
        var input = document.getElementById("item_id-"+newRowId);
        var unit = document.getElementById("unit_ingredient-"+newRowId);
        var price = document.getElementById("price_ingredient-"+newRowId);
        var qty = document.getElementById("consumption_ingredient-"+newRowId);
        var total = document.getElementById("total_ingredient-"+newRowId);
        price.addEventListener('keyup', function(event) {
            if (event.which >= 37 && event.which <= 40) {
            event.preventDefault();
                return;
            }
            price.value = numberFormat(this.value);
            hitungTotal(price,qty,total);
        });
        qty.addEventListener('input', function(e) {
            let value = e.target.value;
            // Replace comma with dot for internal processing, or vice-versa depending on desired standard
            value = value.replace(/,/g, '.'); 
            // Further validation to ensure it's a valid number format
            if (!isNaN(parseFloat(value)) && isFinite(value)) {
                // Valid number
                 qty.value = this.value;
                hitungTotal(price,qty,total);
            } else {
                // Invalid number
                console.log("Invalid number");
            }
        });
        total.addEventListener('keyup', function(event) {
            if (event.which >= 37 && event.which <= 40) {
            event.preventDefault();
                return;
            }
            total.value = numberFormat(this.value);
            hitungTotal(price,qty,total);
        });
        initializeSelect2(newSelect,input,unit,price,null,null);
    });
    $(document).ready(function() {
        $('.item_employee').select2({
            placeholder: 'Search for an Employee',
            ajax: {
            url: base_url+'apis/get_employee', // The URL of your API
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
                    var name = item.first_name +" "+item.last_name
                    return {
                            id: item.id,
                            text: name
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
        $('#item_employee').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Item Employee "+id);
            document.getElementById("input_employee").value=$('#item_employee').val();
        });
        $('#item_employee').on('select2:unselect', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Item Employee "+id);
            document.getElementById("input_employee").value=$('#item_employee').val();
        });
        $('#rnd_create').on('submit', function(e) {
                const myForm = document.querySelector('#rnd_create');
                e.preventDefault();
                const descriptionStatus = parseInt(document.getElementById("descriptionInput").value);
                const employeeStatus = parseInt(document.getElementById("input_employee").value);
                if(descriptionStatus===0 || employeeStatus===0){
                    Swal.fire({
                        title: "Form Not Completed",
                        icon: "error",
                        draggable: true
                    });
                }else{
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
                        fetch(base_url +'rnd/create_process', { // Replace '/auth/login' with your CI4 login route
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(data) // Send your data as JSON
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
                                            title: "Data Sucessfully Inserted",
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
                        }

                    });
                }
        });
    });

    $(document).on("click", ".remove-detail", function() {
        let detailID = $(this).data("id");
        $("#detail-" + detailID).remove();
    });
});
