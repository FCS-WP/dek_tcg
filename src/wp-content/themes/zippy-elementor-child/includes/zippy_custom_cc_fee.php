<?php

/**
 * Add 3% Credit Card fee when the selected payment method is Credit Card
 */
add_action('woocommerce_cart_calculate_fees', 'zippy_add_credit_card_fee');
function zippy_add_credit_card_fee()
{
    if (is_admin() && ! defined('DOING_AJAX')) return;

    // Ensure payment method is selected
    if (empty($_POST['payment_method'])) return;

    $payment_method = sanitize_text_field($_POST['payment_method']);
    // var_dump($payment_method);

    // Replace "credit_card" with your payment gateway ID
    $credit_card_gateway_id = 'zippy_antom_payment';

    if ($payment_method === $credit_card_gateway_id) {

        $cart = WC()->cart;
        $cart_total = $cart->get_subtotal() + $cart->get_subtotal_tax();

        // 3% fee
        $fee_amount = $cart_total * 0.03;

        $cart->add_fee('Credit Card Fee (3%)', $fee_amount, true);
    }
}

/**
 * Add custom JS to refresh checkout when payment method changes
 */
add_action('wp_enqueue_scripts', 'zippy_refresh_checkout_on_payment_change');
function zippy_refresh_checkout_on_payment_change()
{

    if (! is_checkout() || is_order_received_page()) {
        return;
    }

    wp_add_inline_script(
        'wc-checkout', // Ensures WooCommerce checkout JS is loaded first
        "
        jQuery(function($){
            $('form.checkout').on('change', 'input[name=\"payment_method\"]', function(){
                $(document.body).trigger('update_checkout');
            });
        });
        "
    );
}
