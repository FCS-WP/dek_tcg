<?php

add_action('woocommerce_product_query', 'hide_uncategorized_and_outofstock');
function hide_uncategorized_and_outofstock($q)
{

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
/**
 * Add actionn bulk remove uncateogried
 */

// 1. Register bulk action
add_filter('bulk_actions-edit-product', function ($actions) {
    $actions['remove_uncategorized'] = __('Remove Uncategorized', 'woocommerce');
    return $actions;
});

// 2. Handle bulk action
add_filter('handle_bulk_actions-edit-product', function ($redirect, $action, $product_ids) {

    if ($action !== 'remove_uncategorized') {
        return $redirect;
    }

    $uncat_id = get_option('default_product_cat'); // Uncategorized ID

    foreach ($product_ids as $product_id) {
        $terms = wp_get_post_terms($product_id, 'product_cat', ['fields' => 'ids']);

        // Remove Uncategorized
        $terms = array_diff($terms, [$uncat_id]);

        // ⚠️ Must keep at least 1 category
        if (empty($terms)) {
            continue;
        }

        wp_set_post_terms($product_id, $terms, 'product_cat');
    }

    return add_query_arg('removed_uncategorized', count($product_ids), $redirect);
}, 10, 3);

// 3. Admin notice
add_action('admin_notices', function () {
    if (!empty($_GET['removed_uncategorized'])) {
        echo '<div class="notice notice-success"><p>';
        echo sprintf(
            __('Removed Uncategorized from %d products.', 'woocommerce'),
            intval($_GET['removed_uncategorized'])
        );
        echo '</p></div>';
    }
});
