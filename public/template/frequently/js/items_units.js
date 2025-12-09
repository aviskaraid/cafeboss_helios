$(function() {
    "use strict";
    const btnGenerate = document.getElementById("btnAddUnits");
    btnGenerate.addEventListener("click", function() {
            let items_id = document.getElementById("items_id").value;
            console.log("Add Units");
            console.log("Items Id = "+items_id);
            const table = document.getElementById('myTable'); // Replace 'myTable' with your table's ID
            const tbody = table.getElementsByTagName('tbody')[0];
            const newRowId = `${tbody.children.length+1}`;
            $("#detail_list").append(`
                <tr id="detail-${newRowId}">
                    <td style="width: 10%;display:none" style="display:none;">
                        <input type="hidden" name="item_id_${newRowId}" value="${items_id}">
                        <input type="hidden" name="unit_source_${newRowId}" id="source_id-${newRowId}">
                        <input type="hidden" name="unit_dest_${newRowId}" id="dest_id-${newRowId}">
                    </td>
                    <td style="width: 25%"> 
                        <select class="units_source-${newRowId} form-control " id="units_source-${newRowId}"></select>
                    </td>
                    <td style="width: 20%">
                    <input type="number" name="value_source_${newRowId}" class="form-control value_source" value="1" step="any">
                    </td>
                    <td style="width: 25%"> 
                        <select class="units_destination-${newRowId} form-control " id="units_destination-${newRowId}"></select>
                    </td>
                    <td style="width: 20%">
                        <input type="number" name="value_dest_${newRowId}" class="form-control value_destination" value="1" step="any">
                    </td style="width: 10%">
                    <td><button type="button" class="btn btn-danger btn-sm remove-detail" data-id="${newRowId}">Remove</button></td>
                </tr>
`       );
            var newSelect=$("#detail_list").find(".units_source-"+newRowId).last();
            var newSelect2=$("#detail_list").find(".units_destination-"+newRowId).last();
            //var input1=$("#detail_list").find("#source_id-"+newRowId).last();
            //var input2=$("#detail_list").find("#dest_id-"+newRowId).last();
            var input1 = document.getElementById("source_id-"+newRowId);
            var input2 = document.getElementById("dest_id-"+newRowId);;
            initializeSelect2(newSelect,input1,null,null);
            initializeSelect2(newSelect2,input2,null,null);
        });

    $(document).on("click", ".remove-detail", function() {
        let detailID = $(this).data("id");
        $("#detail-" + detailID).remove();
    });

    function initializeSelect2(selectElementObj,inputData, idkey, idSelect) {
       selectElementObj.select2({
            placeholder: 'Search for an Item Units',
            ajax: {
            url: base_url+'apis/get_item_units', // The URL of your API
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
                        text: item.description, // Adjust 'name' to whatever property holds the display text
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
            minimumInputLength: 0 // Only start searching after the user types 1 character
        });
        selectElementObj.on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            inputData.value=id
        });
    }
    
     $('#itemUnits_create').on('submit', function(e) {
            const myForm = document.querySelector('#itemUnits_create');
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure you Want Proceed Form ? ',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit Form!'
                }).then((result) => {
                showLoader();
                const formData = new FormData(myForm);
                const data = Object.fromEntries(formData.entries());
                fetch(base_url +'master/items/setup_units_process', { // Replace '/auth/login' with your CI4 login route
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

                });

     });
    
    $(document).ready(function() {
        let items_id = document.getElementById("items_id").value;
        fetch(base_url+'apis/get_itemunits_byItemId?id='+items_id)
        .then(response => response.json())
        .then(data => {
            if(data.length>0){
                console.log("Exist Units "+data.length );
                for (let index = 0; index < data.length; index++) {
                    const item = data[index];
                    const table = document.getElementById('myTable'); // Replace 'myTable' with your table's ID
                    const tbody = table.getElementsByTagName('tbody')[0];
                    const newRowId = `${tbody.children.length+1}`;
                    $("#detail_list").append(`
                        <tr id="detail-${newRowId}">
                            <td style="width: 10%;display:none" style="display:none;">
                                <input type=" " name="item_id_${newRowId}" value="${items_id}">
                                <input type="hidden" name="unit_source_${newRowId}" id="source_id-${newRowId}" value="${item.unit_source}">
                                <input type="hidden" name="unit_dest_${newRowId}" id="dest_id-${newRowId}" value="${item.unit_dest}">
                            </td>
                            <td style="width: 25%"> 
                                <select class="units_source-${newRowId} form-control " id="units_source-${newRowId}"></select>
                            </td>
                            <td style="width: 20%">
                            <input type="number" name="value_source_${newRowId}" class="form-control value_source" value="${item.value_source}" step="any">
                            </td>
                            <td style="width: 25%"> 
                                <select class="units_destination-${newRowId} form-control " id="units_destination-${newRowId}"></select>
                            </td>
                            <td style="width: 20%">
                                <input type="number" name="value_dest_${newRowId}" class="form-control value_destination" value="${item.value_dest}" step="any">
                            </td style="width: 10%">
                            <td><button type="button" class="btn btn-danger btn-sm remove-detail" data-id="${newRowId}">Remove</button></td>
                        </tr>
        `           );
                     var newSelect=$("#detail_list").find(".units_source-"+newRowId).last();
                    var newSelect2=$("#detail_list").find(".units_destination-"+newRowId).last();
                    var newSelectID1=$("#detail_list").find("#units_source-"+newRowId).last();
                    var newSelectID2=$("#detail_list").find("#units_destination-"+newRowId).last();
                    var input1 = document.getElementById("source_id-"+newRowId);
                    var input2 = document.getElementById("dest_id-"+newRowId);;
                    initializeSelect2(newSelect,input1,item.unit_source,newSelectID1);
                    initializeSelect2(newSelect2,input2,item.unit_dest,newSelectID2);
                    var newOption = new Option(item.unit_source_desc, item.unit_source, true, true);
                    newSelect.append(newOption).trigger('change');
                    var newOption2 = new Option(item.unit_dest_desc, item.unit_dest, true, true);
                    newSelect2.append(newOption2).trigger('change');
                }
            }else{
                console.log("Tidak Ada Data "+data);
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
    });
});
