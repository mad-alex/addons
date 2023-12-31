<?php 


function custom_onsale_message($html, $post, $product) {
    // Customize the "On Sale" text here
    $sale_text = 'Special Offer';

    // Check if the product is on sale
    if ($product->is_on_sale()) {
        // Output the custom sale text
        $html = '<span class="onsale">' . esc_html($sale_text) . '</span>';
    }

    return $html;
}

add_filter('woocommerce_sale_flash', 'custom_onsale_message', 10, 3);