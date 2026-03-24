$(function() {
    "use strict";
    let base_url = $("#baseUrl").val();
    // UPLOAD IMAGE PROFILE
        $(document).ready(function() {
            $('#submit_btn').attr('disabled', true);
            $('#imageToUpload').bind('change', function() {
                if(this.files[0].size > 0){
                    $('#submit_btn').attr('disabled', false);
                }else{
                    $('#submit_btn').attr('disabled', true);
                    document.getElementById('message').textContent = 'No file selected.';
                }
            });
            $('.upload_Image').on('click',function() {
            var dataId = $(this).data('id');
            document.getElementById('user_id').value = dataId;
            });
            $('#fileUploadForm').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure you Want Proceed Upload ? ',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, submit Image Upload!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoader();
                        var formData = new FormData(this);
                        $.ajax({
                            url:base_url + 'settings/users/upload_image',
                            type: 'POST',
                            data: formData,
                            processData: false, 
                            contentType: false,
                            success: function(response) {
                                console.log(response);
                                Swal.fire({
                                        position: "top-end",
                                        icon: "success",
                                        title: "Successfully Uploaded",
                                        showConfirmButton: false,
                                        timer: 2500,
                                        willClose: () => {
                                            window.location.reload();
                                        }
                                    });
                            },
                            error: function(data, textStatus, errorThrown) {
                                var responseObj = JSON.parse(data.responseText);
                                    var messages = responseObj.messages.imageToUpload;
                                    if(messages === ""){
                                        messages = "Error in Image File, Try Again";
                                    }
                                Swal.fire({
                                        title: "Error Upload Image ",
                                        text:messages,
                                        icon: "error",
                                        draggable: true
                                    });
                            }
                        });
                    }
                });
            });
        });
});