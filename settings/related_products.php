<?php 

 
add_filter( 'woocommerce_output_related_products_args', 'bbloomer_change_number_related_products', 9999 );
 
function bbloomer_change_number_related_products( $args ) {
 $args['posts_per_page'] = 4; // # of related products
 $args['columns'] = 4; // # of columns per row
 return $args;
}