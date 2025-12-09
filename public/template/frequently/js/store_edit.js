$(function() {
    "use strict";
    let base_url = $("#baseUrl").val();
    $(document).ready(function() {
        $('.item_category').select2({
            multiple: true,
            placeholder: 'Search for an Item Category',
            ajax: {
            url: base_url+'apis/get_foodmenu_category', // The URL of your API
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
                            text: item.label_name
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
        $('#item_category').on('select2:select', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Item Category "+id);
            document.getElementById("input_category").value=$('#item_category').val();
        });
         $('#item_category').on('select2:unselect', function (e) {
            var data = e.params.data;
            var id = data.id;
            console.log("Item Category "+id);
            document.getElementById("input_category").value=$('#item_category').val();
        });

    });
    $('#stores_edit').on('submit', function(e) {
        const myForm = document.querySelector('#stores_edit');
        e.preventDefault();
        let items_id = document.getElementById("store_id").value;
        const nameStatus = parseInt(document.getElementById("nameStatus").value);
        const descriptionStatus = parseInt(document.getElementById("descriptionStatus").value);
        if(nameStatus===0 || descriptionStatus===0){
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
                //var formData = new FormData(this);
                //const data = Object.fromEntries(formData.entries());
                const formData = new FormData(myForm);
                const data = Object.fromEntries(formData.entries());
                fetch(base_url +'master/stores/changes/'+items_id, { // Replace '/auth/login' with your CI4 login route
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
                                // Swal.fire({
                                //     position: "center",
                                //     icon: "success",
                                //     title: "Data Sucessfully Inserted",
                                //     text: data.message,
                                //     showConfirmButton: false,
                                //     timer: 2500,
                                //     willClose: () => {
                                //         window.location.replace('/'+data.data.redirect);
                                //     }
                                // });
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

   $(document).ready(function() {
        const selectElement = $('#item_category');
        let items_id = document.getElementById("store_id").value;
        fetch(base_url+'apis/get_foodmenu_category_bystore?keyword='+items_id)
        .then(response => response.json())
        .then(data => {
            if(data.length>0){
                data.forEach(function(cat) {
                    const option = new Option(cat.label_name, cat.id, true, true); 
                    selectElement.append(option).trigger('change');
                    selectElement.trigger({
                        type: 'select2:select',
                        params: {
                            data: data
                        }
                    });
                    document.getElementById("input_category").value=$('#item_category').val();
                });
            }else{
                console.log("Tidak Ada Data "+data);
            }
        })
        .catch(error => {
            console.error('Error:', error.message);
        });
    });
});
