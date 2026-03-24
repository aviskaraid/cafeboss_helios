"use strict";
let base_url = $("#baseUrl").val();
document.getElementById("loader-wrapper").style.visibility = "visible";
function showalert() {
    Swal.fire({
    position: "top-end",
    icon: "success",
    title: "Your work has been saved",
    showConfirmButton: false,
    timer: 1500
    });
}
function showLoader() {
  document.getElementById("loader-wrapper").style.visibility = "visible";
}
function hideLoader() {
    document.getElementById("loader-wrapper").style.visibility = "hidden";
}


// LOGIN //
document.getElementById('myForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const myData = {email: email,password : password};
    fetch(base_url +'authentication/login_process', { // Replace '/auth/login' with your CI4 login route
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(myData) // Send your data as JSON
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.status!==200) {
                    var err = data.data.errors;
                   Swal.fire({
                        position: "center",
                        icon: "error",
                        title: JSON.stringify(err),
                        showConfirmButton: false,
                        timer: 2500
                    });
                // for (let field in data.errors) {
                //     let errorElement = document.getElementById(`${field}-error`);
                //     if (errorElement) {
                //         errorElement.textContent = data.errors[field].join(', '); // Assuming multiple errors per field
                //     }
                // }
            }else{
                console.log(data.data.success);
                if(!data.data.success){
                      Swal.fire({
                        position: "center",
                        icon: "error",
                        title: data.message,
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
                            if ('redirect' in data.data) {
                                window.location.href = data.data.redirect;
//                                    window.location.replace('/'+data.data.redirect);
                            }else{
                                    window.location.replace('/beranda');
                            }
                        }
                    });
                }
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


document.addEventListener('DOMContentLoaded', (event) => {
    const loader = document.getElementById('loader-wrapper');
    const delayDuration = 2000; // 2000 milliseconds (2 seconds)

    // Use setTimeout to hide the loader after the specified duration
    setTimeout(() => {
        if (loader) {
            loader.style.display = 'none'; // Hide the loader
        }
    }, delayDuration);
});