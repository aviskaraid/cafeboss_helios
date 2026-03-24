$(function() {
    "use strict";
    let base_url = $("#baseUrl").val();
    if(document.getElementById('total_data').value>0){
        document.getElementById('no_cursor').style.cursor = 'none';
        const btn_approved = document.getElementById("btn_approved");
        const btn_declined = document.getElementById("btn_declined");
        btn_approved.addEventListener("click", function() {
        const SRID = this.getAttribute("data-id");
        const SRRefNo = this.getAttribute("data-refno");
                 Swal.fire({
                  title: 'Are you sure you Want Approve Purchase '+ SRRefNo +'? ',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, submit Form!'
              }).then((result) => {
                  if (result.isConfirmed) {
                    showLoader();
                    const data = {
                            id: SRID
                        };
                   fetch(base_url +'apis/post_PRApprove', { // Replace '/auth/login' with your CI4 login route
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                         console.log(data);
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Data Sucessfully Approved",
                            text: data.message,
                            showConfirmButton: false,
                            timer: 2500,
                            willClose: () => {
                                window.location.replace("/purchase/purchaserequest");
                            }
                        });
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

                  } else if (result.isDenied) {
                  }
              });
        });

        btn_declined.addEventListener("click", function() {
            const SRID = this.getAttribute("data-id");
            const SRRefNo = this.getAttribute("data-refno");
                    Swal.fire({
                    title: 'Are you sure you Want Decline Purchase '+ SRRefNo +'? ',
                    text: "You won't be able to revert this!",
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, submit Form Declined Number!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoader();
                        const data = {
                                id: SRID
                            };
                    fetch(base_url +'apis/post_PRDecline', { // Replace '/auth/login' with your CI4 login route
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Data Sucessfully Declined",
                                text: data.message,
                                showConfirmButton: false,
                                timer: 2500,
                                willClose: () => {
                                    window.location.replace("/purchase/purchaserequest");
                                }
                            });
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

                    } else if (result.isDenied) {
                    }
                });
        });
    }
});