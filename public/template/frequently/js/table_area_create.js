$(function() {
    "use strict";
    let base_url = $("#baseUrl").val();

    $(document).ready(function() {
        $('.item_store').select2({
            placeholder: 'Search for an Store',
            ajax: {
            url: base_url+'apis/get_store', // The URL of your API
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
                            text: item.description
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
        $('#item_store').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Item Category "+id);
            document.getElementById("input_store").value=$('#item_store').val();
        });
         $('#item_store').on('select2:unselect', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Item Store "+id);
            document.getElementById("input_store").value=$('#item_store').val();
        });

    });
    $('#table_area_create').on('submit', function(e) {
            const myForm = document.querySelector('#table_area_create');
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
                    fetch(base_url +'master/table/area/create_process', { // Replace '/auth/login' with your CI4 login route
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
                                    console.log(data);
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
