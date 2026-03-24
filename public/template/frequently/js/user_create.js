$(function() {
    "use strict";
    let base_url = $("#baseUrl").val();
    const btnGenerate = document.getElementById("btnGenerateCode");
    btnGenerate.addEventListener("click", function() {
        $.ajax({
            url:base_url + 'settings/users/generate_user_code',
            method:"get",
            dataType:"json",
            success: function(response) {
                document.getElementById('user_code').value = response;
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
        $('.group_user').select2({
            placeholder: 'Search for an Groups User',
            ajax: {
            url: base_url+'apis/get_user_groups', // The URL of your API
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
            minimumInputLength: 1 // Only start searching after the user types 1 character
        });
        $('#userGroup').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Groups "+id);
            document.getElementById("input_group").value=id;
        });
        $('#user_create').on('submit', function(e) {
             const myForm = document.querySelector('#user_create');
            e.preventDefault();
            const usernameStatus = parseInt(document.getElementById("usernameStatus").value);
            const emailStatus = parseInt(document.getElementById("emailStatus").value);
            const fullnameStatus = parseInt(document.getElementById("fullnameStatus").value);
            const groupValue = document.getElementById("input_group").value.length;
            const userCodeValue = document.getElementById("user_code").value.length;
            console.log(usernameStatus);
            console.log(emailStatus);
            console.log(fullnameStatus);
            console.log(groupValue);
            if(userCodeValue===0 || usernameStatus===0 || emailStatus ===0 || fullnameStatus ===0 || groupValue===0){
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
                    //var formData = new FormData(this);
                    //const data = Object.fromEntries(formData.entries());
                    const formData = new FormData(myForm);
                    const data = Object.fromEntries(formData.entries());
                    fetch(base_url +'settings/users/create_process', { // Replace '/auth/login' with your CI4 login route
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
                                        title: "Success Log In",
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
