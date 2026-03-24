$(function() {
    "use strict";
    let base_url = $("#baseUrl").val();
    $('#supplier_edit').on('submit', function(e) {
        const myForm = document.querySelector('#supplier_edit');
        e.preventDefault();
        let items_id = document.getElementById("supplier_id").value;
        const name = document.getElementById("nameInput").value.length;
        const description = document.getElementById("descriptionInput").value.length;
        if(name===0 || description===0){
            console.log(nameStatus);
            console.log(descriptionStatus);
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
                fetch(base_url +'master/supplier/changes/'+items_id, { // Replace '/auth/login' with your CI4 login route
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
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "Data Sucessfully Updated",
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
