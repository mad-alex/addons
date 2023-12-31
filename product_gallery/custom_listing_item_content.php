<?php

add_action('custom_listing_item_content','function_custom_listing_item_content');

function function_custom_listing_item_content(){
	
	
	global $product;
	
	$id = $product->get_id();
	
	 
	$name = $product->get_name();
    $img = get_product_image_src( $id );
	
	$s_price = $product->get_sale_price();
	$r_price = $product->get_regular_price();
	
	$price =  $product->get_price_html();
     $add_to_cart = do_shortcode("[add_to_cart id='$id']");
	
	$add_to_cart_html =  add_to_cart_button($id,$name,'Adauga in cos');
	$rating =   wc_get_rating_html( $product->get_average_rating() ); // WordPress.XSS.EscapeOutput.OutputNotEscaped.
    $onsale = '';
	
	if($product->is_on_sale()){
		$onsale = 'de vanzare';
	}
	 

?>


<div class='listing_item_content'> 
    
	<div class='on_sale_wrap'><?php echo $onsale;?></div>
	
	<div class='img_wrap'><img src='<?php echo $img; ?>'></div>
	
	 
	<div class='content_wrap'>
		<div class='product_name'><?php echo $name; ?></div>	
		<div class='rating_wrap'><?php echo $rating;?></div>
		 
		<div class='add_to_cart_button_wrap'><?php echo $add_to_cart;?></div>
		 
	</div>
</div>




<?php 
}


function get_product_image_src($product_id){
	 
// Get the product object
$product = wc_get_product($product_id);

// Get the product thumbnail ID
$thumbnail_id = $product->get_image_id();

// Get the thumbnail URL
$thumbnail_url = wp_get_attachment_image_src( $thumbnail_id , 'thumbnail' );

	// Check if the URL exists before using it
	if ($thumbnail_url) {
		$thumbnail_url = $thumbnail_url[0];
		return esc_url($thumbnail_url);
	} else {
	    return '';
	}
}

function add_to_cart_button($id,$nume,$text){
	
	return '<a href="?add-to-cart='.$id.'" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $id;?>" data-product_sku="" aria-label="Adauga “'.$nume.'” in cos" aria-describedby="" rel="nofollow">'.$text.'</a>';
	
}