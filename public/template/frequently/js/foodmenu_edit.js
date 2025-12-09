$(function() {
    "use strict";
    var exist = [];
       $(document).ready(function() {
        $('.item_category').select2({
            multiple: true,
            placeholder: 'Search for an Item Category',
            ajax: {
            url: base_url+'apis/get_foodmenu_category', // The URL of your API
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
                            text: item.label_name
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
        $('#item_category').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Item Category "+id);
            document.getElementById("input_category").value=$('#item_category').val();
        });
        $('#item_category').on('select2:unselect', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Item Category Delete "+id);
            document.getElementById("input_category").value=$('#item_category').val();
        });
        $('#foodmenu_edit').on('submit', function(e) {
             const myForm = document.querySelector('#foodmenu_edit');
            e.preventDefault();
            const foodMenuId = document.getElementById("id").value;
            const nameStatus = document.getElementById("nameInput").value.length;
            const descriptionStatus = document.getElementById("descriptionInput").value.length;
            const displayNameValue = document.getElementById("displaynameInput").value.length;
            const CodeValue = document.getElementById("items_code").value.length;
            console.log(nameStatus);
            console.log(descriptionStatus);
            console.log(displayNameValue);
            console.log(CodeValue);
            if(nameStatus===0 || descriptionStatus===0 || displayNameValue ===0 || CodeValue===0){
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
                    showLoader();
                    const formData = new FormData(myForm);
                    const data = Object.fromEntries(formData.entries());
                    fetch(base_url +'master/food_menu/changes/'+foodMenuId, { // Replace '/auth/login' with your CI4 login route
                        method: 'PATCH',
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
            }
            
            
        });
    });

    $(document).ready(function() {
        const selectElement = $('#item_category');
        let items_id = document.getElementById("id").value;
        fetch(base_url+'apis/get_foodmenu_category_bymenu?keyword='+items_id)
        .then(response => response.json())
        .then(data => {
            if(data.length>0){
                data.forEach(function(cat) {
                    const option = new Option(cat.label_name, cat.id, true, true); 
                    selectElement.append(option).trigger('change');
                    selectElement.trigger({
                        type: 'select2:select',
                        params: {
                            data: data
                        }
                    });
                    document.getElementById("input_category").value=$('#item_category').val();
                });
            }else{
                console.log("Tidak Ada Data "+data);
            }
        })
        .catch(error => {
            console.error('Error:', error.message);
        });
    });

});
