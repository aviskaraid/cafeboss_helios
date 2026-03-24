"use strict";
$("#select_all_access").change(function() {
    $(".checkboxAccess").prop("checked", $(this).prop("checked"));
    $(".checkboxFunction").prop("checked", $(this).prop("checked"));
});

document.querySelectorAll('.checkboxAccess').forEach(parentCheckbox => {
    parentCheckbox.addEventListener('change', function() {
        const func = this.value;
        console.log("Access "+func);
            const childCheckboxes = this.closest('.parentAccess'+func).querySelectorAll('.checkboxFunction');
            childCheckboxes.forEach(childCheckbox => {
                childCheckbox.checked = this.checked;
            });
    });
});

document.querySelectorAll('.checkboxFunction').forEach(childCheckBox => {
    childCheckBox.addEventListener('change', function() {
        const func = this.value;
        const words = func.split(";");
        const module = words[0];
        const fungsi = words[1];
        console.log(module +" "+fungsi);
            const parentCheckbox = this.closest('.parentAccess'+module).querySelectorAll('.checkboxAccess');
            parentCheckbox.forEach(parentCheckbox => {
                const checkboxes = this.closest('.parentAccess'+module).querySelectorAll('.checkboxFunction');
                const numberOfCheckboxes = checkboxes.length;
                const checkeds = this.closest('.parentAccess'+module).querySelectorAll('.checkboxFunction:checked');
                let totalChecked = checkeds.length;
                console.log(totalChecked);
                console.log(numberOfCheckboxes);
                 if (totalChecked === (numberOfCheckboxes)) {
                    $("#customCheckAccess"+module).prop("checked", true);
                 } 
                 if (totalChecked < (numberOfCheckboxes)) {
                    $("#customCheckAccess"+module).prop("checked", false);
                 }
                
            });
    });
});
