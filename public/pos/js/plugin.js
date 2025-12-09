"use strict";
$(document).ready(function() {
        $('.choose_branch').select2({
            placeholder: "Select a Branch",
            allowClear: true
        });
         $('#choose_branch').on('select2:select', function (e) {
            e.target.dispatchEvent(new Event("change"));
        });
        $('.choose_shift').select2({
            placeholder: "Select a Shift",
            allowClear: true
        });
         $('#choose_shift').on('select2:select', function (e) {
            e.target.dispatchEvent(new Event("change"));
        });
        $('.choose_paymethod').select2({
            placeholder: "Select a Method for Payment",
            allowClear: true
        });
         $('#choose_paymethod').on('select2:select', function (e) {
            e.target.dispatchEvent(new Event("change"));
        });
        $('.choose_bank').select2({
            placeholder: "Choos a Bank",
            allowClear: true
        });
        $('#choose_bank').on('select2:select', function (e) {
            e.target.dispatchEvent(new Event("change"));
        });
        $('.choose_bank_2').select2({
            placeholder: "Choos a Bank",
            allowClear: true
        });
        $('#choose_bank_2').on('select2:select', function (e) {
            e.target.dispatchEvent(new Event("change"));
        });
    });