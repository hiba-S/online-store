var BASE_URL = $('meta[name="base-url"]').attr('content');
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': CSRF_TOKEN
        // 'Accept': 'application/json'
    }
});
$(document).ready(function(){

    updateCartCount();

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

    $('.add-to-cart-btn').click(function(e) {
        e.preventDefault();

        var productId = $(this).data('product-id');

        $.ajax({
            url: BASE_URL + "/add-to-cart/" + productId,
            type: "POST",
            success: function(response, status, xhr) {
                if (xhr.status === 200) {
                    updateCartCount();
                } else {
                    alert('Unexpected status code: ' + xhr.status);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred. Please try again.');
            }
        });
    });
});

function updateCartCount() {
    $.ajax({
        url: BASE_URL + "/cart/count",
        type: "GET",
        success: function(response) {
            $('#cart-count').text(response.cart_count);
        },
        error: function(xhr) {
            console.error('Error fetching cart count:', xhr.responseText);
        }
    });
}

