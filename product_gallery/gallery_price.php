<?php 


function custom_modify_product_price_html($price, $product) {
    // Your custom price modification logic here
	
	$s_price = '';
    $r_price ='';
 
	$r_price = $product->get_regular_price();
	$s_price = $product->get_sale_price();
	 
//////////////
	
// Check the product type
$product_type = $product->get_type();

 
if($product_type=='variable'){ 

	$product = wc_get_product($product->get_id());
    $main_prod_id = $product->get_id();
 
    $products = wc_get_products(array(
		'status' => 'publish',
		'type'=>'variation',
		'parent_id'=> $main_prod_id ,
		'limit' => -1,
	));
	
  $sale_prices = array();
  $reg_prices = array();
  
foreach($products as $prod){
	
	if($prod->get_parent_id() == $main_prod_id  ){
		  
		$sale_prices[] = $prod->get_sale_price();
		$reg_prices[] = $prod->get_regular_price(); 
	} 
}
 
	if( ! empty( $sale_prices ) ){
		if(min( $sale_prices ) != 0  ){
			$key = array_search( min($sale_prices), $sale_prices );
			$s_price = min($sale_prices);
			$r_price = $reg_prices[$key];
		}
	}else{
		
	}
	
}

	if($s_price ){
		$rez = '<del class="reg_sale">'.$r_price.'lei</del>'    .  $s_price .'lei'  ;
	}else{
		$rez =  $r_price .'lei';
	}
	
    return     "<div class='price_wrap'>".$rez.'</div>'  ;
}

 add_filter('woocommerce_get_price_html', 'custom_modify_product_price_html', 10, 2);
 