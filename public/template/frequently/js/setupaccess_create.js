$(function() {
    "use strict";
  console.log(base_url);
  $('#modules').select2({
        placeholder: 'Select an Modules',
        allowClear : true,
  });
  let getModules = document.getElementById("getModules");
  getModules.classList.add("hidden");
  let getMainMenu = document.getElementById("getmain_menu");
  $('#as').on('select2:select', function (e) {
    var data = e.params.data;
    console.log("Choose "+data.id);
    if(data.id == "module"){
      console.log("Module");
      getModules.classList.add("hidden");
      getMainMenu.classList.remove("hidden");
      $('#parent_id').val(0);
    }
    if(data.id =="function"){
      console.log("Function");
      getModules.classList.remove("hidden");
      getMainMenu.classList.add("hidden");
      $("#main_module_id").val(0);
    }
  });

  $('#modules').on('select2:select', function (e) {
    var data = e.params.data;
      console.log(data.id);
    $('#parent_id').val(data.id);
  });
  $('#main_menu_state').on('select2:select', function (e) {
    var data = e.params.data;
    $('#main_module_id').val(data.id);
  });

});