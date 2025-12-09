$(function() {
    "use strict";
    let base_url = $("#baseUrl").val();
    const btnGenerate = document.getElementById("btnGenerateCode");
    btnGenerate.addEventListener("click", function() {
        $.ajax({
            url:base_url + 'master/stores/generate_stores_code',
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

    });
    $('#stores_create').on('submit', function(e) {
            const myForm = document.querySelector('#stores_create');
            e.preventDefault();
            const nameStatus = parseInt(document.getElementById("nameStatus").value);
            const descriptionStatus = parseInt(document.getElementById("descriptionStatus").value);
            if(nameStatus===0 || descriptionStatus===0){
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
                    //var formData = new FormData(this);
                    //const data = Object.fromEntries(formData.entries());
                    const formData = new FormData(myForm);
                    const data = Object.fromEntries(formData.entries());
                    fetch(base_url +'master/stores/create_process', { // Replace '/auth/login' with your CI4 login route
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
