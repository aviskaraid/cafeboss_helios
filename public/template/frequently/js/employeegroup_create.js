$(function() {
    "use strict";
    let base_url = $("#baseUrl").val();
    const btnGenerate = document.getElementById("btnGenerateCode");
    btnGenerate.addEventListener("click", function() {
        $.ajax({
            url:base_url + 'master/employee_group/generate_employeegroup_code',
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
    $('#employeegroup_create').on('submit', function(e) {
             const myForm = document.querySelector('#employeegroup_create');
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
                    fetch(base_url +'master/employee_group/create_process', { // Replace '/auth/login' with your CI4 login route
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
