$(function() {
    "use strict";
    let base_url = $("#baseUrl").val();
    const btnGenerate = document.getElementById("btnGenerateCode");
    btnGenerate.addEventListener("click", function() {
        fetch(base_url + 'taktikal/generate_code') // Replace with your actual API endpoint
        .then(response => response.json())
        .then(data => {
            document.getElementById('taktikal_code').value = data;
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
    $(document).ready(function(){
        $('.start_time').datepicker({
            format: 'yyyy-mm-dd', // Customize the date format
            autoclose: true,     // Automatically close after date selection
            todayHighlight: true // Highlight today's date
        });
        $('.end_time').datepicker({
            format: 'yyyy-mm-dd', // Customize the date format
            autoclose: true,     // Automatically close after date selection
            todayHighlight: true // Highlight today's date
        });
        $('.item_supplier').select2({
            placeholder: 'Search for an Supplier',
            ajax: {
            url: base_url+'apis/get_supplier', // The URL of your API
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
                            text: item.name,
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
        $('#item_supplier').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Supplier "+id);
            document.getElementById("input_supplier").value=id;
        });

        $('#taktikal_create').on('submit', function(e) {
            const myForm = document.querySelector('#taktikal_create');
            e.preventDefault();
            const descriptionStatus = parseInt(document.getElementById("descriptionInput").value.length);
            if(descriptionStatus === 0){
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
                    fetch(base_url +'taktikal/create_process', { // Replace '/auth/login' with your CI4 login route
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
                                        title: "Data Sucessfully Created",
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
});