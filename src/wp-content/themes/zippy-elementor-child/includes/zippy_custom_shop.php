<?php

add_action('woocommerce_before_shop_loop', 'add_wrapper_control_box', 29);

function add_wrapper_control_box()
{
?>
    <div class="ordering-and-view">

    <?php
}

add_action('woocommerce_before_shop_loop', 'my_custom_icons_after_sort', 31);

function my_custom_icons_after_sort()
{
    $current_url = home_url(add_query_arg(null, null));

    // Build grid view link
    $grid_url = add_query_arg('data-type', 'grid', $current_url);

    // Build list view link
    $list_url = add_query_arg('data-type', 'list', $current_url);
    ?>
        <div class="shop-view-toggle">
            <a href="<?php echo esc_url($grid_url); ?>" class="toggle-data-type elementor-icon <?php echo $_REQUEST['data-type'] == 'grid' || !$_REQUEST['data-type'] ? 'active' : '' ?>" href="" data-view="grid">
                <svg aria-hidden="true" class="e-font-icon-svg e-fas-th" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    <path d="M149.333 56v80c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24V56c0-13.255 10.745-24 24-24h101.333c13.255 0 24 10.745 24 24zm181.334 240v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm32-240v80c0 13.255 10.745 24 24 24H488c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24zm-32 80V56c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm-205.334 56H24c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24zM0 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zm386.667-56H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zm0 160H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zM181.333 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24z"></path>
                </svg>
            </a>
            <a href="<?php echo esc_url($list_url); ?>" class="toggle-data-type elementor-icon <?php echo $_REQUEST['data-type'] == 'list' ? 'active' : '' ?>" data-view="list">
                <svg aria-hidden="true" class="e-font-icon-svg e-fas-th-list" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    <path d="M149.333 216v80c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24v-80c0-13.255 10.745-24 24-24h101.333c13.255 0 24 10.745 24 24zM0 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zM125.333 32H24C10.745 32 0 42.745 0 56v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24zm80 448H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zm-24-424v80c0 13.255 10.745 24 24 24H488c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24zm24 264H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24z"></path>
                </svg>
            </a>
        </div>
    </div>
<?php
}

add_filter('woocommerce_product_loop_start', 'my_custom_loop_start', 10, 1);
function my_custom_loop_start($html)
{
    // Check query param `data-type`
    $view_type = isset($_GET['data-type']) ? sanitize_text_field($_GET['data-type']) : 'grid';

    if ($view_type === 'list') {
        // Replace default class with custom one
        $html = '<ul class="products display-list">';
    }

    return $html;
}
