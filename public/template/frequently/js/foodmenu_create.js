$(function() {
    "use strict";
    let base_url = $("#baseUrl").val();
    const btnGenerate = document.getElementById("btnGenerateCode");
    btnGenerate.addEventListener("click", function() {
        fetch(base_url + 'master/items/generate_items_code') // Replace with your actual API endpoint
        .then(response => response.json())
        .then(data => {
            document.getElementById('items_code').value = data;
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            Swal.fire({
                        title: "Error",
                        text:error.message,
                        icon: "error",
                        draggable: true
                    });
        });
    });

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
            console.log("Item Category "+id);
            document.getElementById("input_category").value=$('#item_category').val();
        });
        $('#foodmenu_create').on('submit', function(e) {
             const myForm = document.querySelector('#foodmenu_create');
            e.preventDefault();
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
                    fetch(base_url +'master/food_menu/create_process', { // Replace '/auth/login' with your CI4 login route
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

});
