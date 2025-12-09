"use strict";
document.getElementById("loader-wrapper").style.visibility = "visible";
let base_url = $("#baseUrl").val();
// // custom menu active
var path = location.pathname.split('/')
const pathSegments = location.pathname.split('/').filter(segment => segment !== ''); // Split and remove empty strings
if (pathSegments.length == 1) {
    var url = location.origin + '/' + path[1]
    $('ul.sidebar-menu li a').each(function() {
        if($(this).attr('href').indexOf(url) !== -1) {
            $(this).parent().addClass('active').parent().parent('li').addClass('active')
        }
    })
}
if (pathSegments.length >= 2) {
    var url = location.origin + '/' + path[1]+ '/' + path[2]
    $('ul.sidebar-menu li a').each(function() {
        if($(this).attr('href').indexOf(url) !== -1) {
            $(this).parent().addClass('active').parent().parent('li').addClass('active')
        }
    })
}


$("#check-all").change(function() {
        $(".checkboxGroup").prop("checked", $(this).prop("checked"));
    });

    $(".checkboxGroup").change(function() {
        if ($(".checkboxGroup:checked").length === $(".checkboxGroup").length) {
            $("#check-all").prop("checked", true);
        } else {
            $("#check-all").prop("checked", false);
        }
    });

function submitDel(id) {
    $('#del-'+id).submit()
}
function submitCancel(id) {
    $('#cancel-'+id).submit()
}
const formatRupiahDisplay = (number)=>{
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 2, // Ensure at least 2 decimal places
      maximumFractionDigits: 2, // Ensure no more than 2 decimal places
    }).format(number);
  }
$(document).ready(function() {
    const id = getCookie("user_login_id");
    if(getCookie('user_access')=== null && getCookie('user_menu')=== null){
        showLoader();
        $.ajax({
        url:'http://localhost:8080/apis/get_access_user_menu/'+id,
        method:"get",
        dataType:"json",
        success: function(response) {
            console.log(response.data.groups.access);
            console.log(response.data.groups.menu);
            setCookie("user_access",JSON.stringify(response.data.groups.access));
            setCookie("user_menu",JSON.stringify(response.data.groups.menu));
            window.location.href = base_url+"beranda";
        },
        error:function(xhr, status, error){
            console.error("AJAx Error : "+status+ " "+error);
        }
    });
    }
    
});

function showLoader() {
  document.getElementById("loader-wrapper").style.visibility = "visible";
}
function hideLoader() {
    document.getElementById("loader-wrapper").style.visibility = "hidden";
}
document.addEventListener('DOMContentLoaded', (event) => {
    const loader = document.getElementById('loader-wrapper');
    const delayDuration = 500;
    setTimeout(() => {
        if (loader) {
            loader.style.display = 'none'; // Hide the loader
        }
    }, delayDuration);
});

function numberFormat(number) {
        return (number || "")
          .toString()
          .replace(/^0|\./g, "")
          .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
      }