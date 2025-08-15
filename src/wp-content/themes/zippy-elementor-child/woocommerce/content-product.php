<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;
$full_image_url = wp_get_attachment_image_src($product->get_image_id(), 'full')[0];
$regular_price = $product->get_regular_price();
$sale_price    = $product->get_sale_price();

// Ensure visibility.
if (empty($product) || ! $product->is_visible()) {
    return;
}

?>
<li <?php wc_product_class('custom-loop-product', $product); ?>>
    <div class="custom-product-card">
        <div class="product-featured">
            <a href="<?php the_permalink(); ?>">
                <img
                    src="<?php echo esc_url($full_image_url); ?>"
                    alt="<?php the_title_attribute(); ?>"
                    class="custom-product-thumbnail" />
            </a>
        </div>
        <div class="product-info">
            <h3 class="product-title">
                <a class="title-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
            <div class="product-short-desc">
                <?php echo apply_filters('woocommerce_short_description', $product->get_short_description()); ?>
            </div>
            <div class="product-price">
                <?php
                if ($product->is_on_sale() && $sale_price) {
                    echo '<span class="has-sale regular-price"' . wc_price($regular_price) . '</span> ';
                    echo '<span class="sale-price" style="color:red;font-weight:bold;">' . wc_price($sale_price) . '</span>';
                } else {
                    echo '<span class="regular-price">' . wc_price($regular_price) . '</span>';
                }
                ?>
            </div>

        </div>

        <div class="product-actions">
            <div>
                <?php woocommerce_template_loop_add_to_cart(); ?>
            </div>
        </div>
    </div>
</li>