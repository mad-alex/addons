<?php 
 
add_filter(
	'loop_shop_columns', 
	function( $columns ) {
		return is_shop() ? 5 : 4;
	},
	30 
);