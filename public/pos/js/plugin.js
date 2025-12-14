"use strict";
$(document).ready(function() {
        $('.choose_branch').select2({
            placeholder: "Select a Store",
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

function getCookie(naming){
    const nameEQ = naming + "=";
    const ca = document.cookie.split(";");
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0)=== ' ') {
        c = c.substring(1,c.length);
        }
        if (c.indexOf(nameEQ)===0){
        return decodeURIComponent(c.substring(nameEQ.length,c.length));
        }
    }
    return null;
}
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); // Calculate future date in milliseconds
    expires = "; expires=" + date.toUTCString(); // Format to UTC string
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getBaseDate(){
const now = new Date();
// Extract individual components
const year = now.getFullYear();
const month = (now.getMonth() + 1).toString().padStart(2, '0'); // Month is 0-indexed, add 1
const day = now.getDate().toString().padStart(2, '0');
const hours = now.getHours().toString().padStart(2, '0');
const minutes = now.getMinutes().toString().padStart(2, '0');
const seconds = now.getSeconds().toString().padStart(2, '0');
const customDateTimeString = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
return customDateTimeString;
}

function numberFormat(number) {
    return (number || "")
        .toString()
        .replace(/^0|\./g, "")
        .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
}

function numberFormatDisplay(number) {
    return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 2, // Ensure at least 2 decimal places
    maximumFractionDigits: 2, // Ensure no more than 2 decimal places
    }).format(number);
}
function getTimer(stringDate){
const now = new Date().getTime();
const bookingTime = new Date(stringDate).getTime();
const distance = now - bookingTime;
const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
const seconds = Math.floor((distance % (1000 * 60)) / 1000);
const formattedHours = String(hours).padStart(2, '0');
const formattedMinutes = String(minutes).padStart(2, '0');
const formattedSeconds = String(seconds).padStart(2, '0');
const timeCount = `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
return timeCount;
}
function splitString(sparat,string){
    const sentence = string;
    const words = sentence.split(sparat);
    return words;
}
function dateFormat(date) {
        const formatter = new Intl.DateTimeFormat('id', { dateStyle: 'short', timeStyle: 'short'});
        return formatter.format(date);
}