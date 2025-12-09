$(function() {
    "use strict";
let base_url = $("#baseUrl").val();
 $('#category').select2({
        placeholder: 'Select an Category',
        allowClear : true,
 });
let getCategory = document.getElementById("getCategory");
getCategory.classList.add("hidden");
$('#as').on('select2:select', function (e) {
  var data = e.params.data;
  if(data.id == "main"){
    getCategory.classList.add("hidden");
    $('#parent_id').val(0);
  }
  if(data.id =="sub"){
    getCategory.classList.remove("hidden");
  }
});

$('#category').on('select2:select', function (e) {
  var data = e.params.data;
    console.log(data.id);
  $('#parent_id').val(data.id);
});
  $('#itemCategory_Create').on('submit', function(e) {
            const myForm = document.querySelector('#itemCategory_Create');
          e.preventDefault();
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
                    fetch(base_url +'master/itemcategory/create_process', { // Replace '/auth/login' with your CI4 login route
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
                                console.log(data);
                                  Swal.fire({
                                      position: "center",
                                      icon: "success",
                                      title: "Data Sucessfully Inserted",
                                      text: data.message,
                                      showConfirmButton: false,
                                      timer: 2500,
                                      willClose: () => {
                                          window.location.replace("/master/itemcategory");
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

                  } else if (result.isDenied) {
                  }
              });
      });

});