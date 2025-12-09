$(function() {
    "use strict";
    const btnGenerate = document.getElementById("btnGenerateCode");
    btnGenerate.addEventListener("click", function() {
        $.ajax({
            url:base_url + 'master/employee/generate_employee_code',
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
        $('.item_department').select2({
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
        $('#item_department').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Item Category "+id);
            document.getElementById("input_department").value=$('#item_department').val();
        });
        $('#item_department').on('select2:unselect', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Item Department "+id);
            document.getElementById("input_department").value=$('#item_department').val();
        });
        $('.item_employeegroup').select2({
            placeholder: 'Search for an Group',
            ajax: {
            url: base_url+'apis/get_employeegroup', // The URL of your API
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
        $('#item_employeegroup').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Item item_employeegroup "+id);
            document.getElementById("input_employeegroup").value=$('#item_employeegroup').val();
        });
        $('#item_employeegroup').on('select2:unselect', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Item item_employeegroup "+id);
            document.getElementById("input_employeegroup").value=$('#item_employeegroup').val();
        });
        $('#employee_create').on('submit', function(e) {
                const myForm = document.querySelector('#employee_create');
                e.preventDefault();
                const nameStatus = parseInt(document.getElementById("firstnameStatus").value);
                const descriptionStatus = parseInt(document.getElementById("lastnameStatus").value);
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
                        const formData = new FormData(myForm);
                        const data = Object.fromEntries(formData.entries());
                        fetch(base_url +'master/employees/create_process', { // Replace '/auth/login' with your CI4 login route
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
});
