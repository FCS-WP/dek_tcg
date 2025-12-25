<?php 

add_action('woocommerce_product_query', 'hide_uncategorized_and_outofstock');
function hide_uncategorized_and_outofstock($q) {

    if (is_admin()) return;

    $tax_query = (array) $q->get('tax_query');

    // Hide Uncategorized
    $tax_query[] = [
        'taxonomy' => 'product_cat',
        'field'    => 'slug',
        'terms'    => ['uncategorized'],
        'operator' => 'NOT IN'
    ];

    $q->set('tax_query', $tax_query);

    // Hide out of stock
    $meta_query = (array) $q->get('meta_query');

    $meta_query[] = [
        'key'     => '_stock_status',
        'value'   => 'outofstock',
        'compare' => '!='
    ];

    $q->set('meta_query', $meta_query);
}
