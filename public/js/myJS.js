$('.owl-carousel').owlCarousel({
    loop:true,
    items:4,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})

$('.product-quantity').change(function() {
    if($(this).val()<=0){
        $(this).val(1);
    }
        $('#cart-item-id').val($(this).parent().parent().find('.item_id').val());
        $('#cart-item-product-id').val($(this).parent().parent().find('.product_id').val());
        $('#cart-item-quantity').val($(this).val());
        $('#update-quantity-form').submit();

        $(this).parent().parent().find('.sub-total').text(parseFloat($(this).parent().parent().find('.unit-price').text())*parseFloat($(this).val()));

        let totalPrice = 0;
        $('.sub-total').each(function() {
            totalPrice += parseFloat($(this).text());
        });
        $('#total-price').text(totalPrice);

});

