const input_sell_price = document.getElementById('sell_price');

input_sell_price.addEventListener('keyup', function(event) {
    if (event.which >= 37 && event.which <= 40) {
       event.preventDefault();
        return;
    }
    input_sell_price.value = numberFormat(this.value);
});

