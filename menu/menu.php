<?php 
return; // anulat
require_once('mobile_menu.php');
add_action('wp_body_open','vdvdv' );


define('CM_MENU_WIDTH','800px');





function vdvdv(){
	
	// echo 'fwef<br>rerg<br>fewf';
	//print_r(get_registered_nav_menus());
	
//print_r( wp_nav_menu(wp_get_nav_menu_items(get_registered_nav_menus()['max_mega_menu_1'])) );

// ACTIVE CODE
      echo do_shortcode('[mobile_menu]'); 
     echo do_shortcode('[_main_menu_html]'); 

	 
//  echo do_shortcode("[maxmegamenu location=max_mega_menu_1]");
//echo   do_shortcode(get_post(204)->post_content);  

/*
[logo] the_custom_logo()
[search] - > [fibosearch]
[menu_icons] 
[contact_icons si sociale] 
	wc_get_cart_url()
	<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account',''); ?>"><?php _e('My Account',''); ?></a>

*/
 // $logo       =  the_custom_logo();
  $menu_icons =  "";
  $search     =  do_shortcode('[fibosearch]');
  
  //echo wc_get_account_endpoint_url('dashboard');
  $cont       =  get_permalink( get_option('woocommerce_myaccount_page_id') );
}

/*
 
pentru 

// scos lupa de la galerie
function remove_image_zoom_support_webtalkhub() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'wp', 'remove_image_zoom_support_webtalkhub', 100 )

*/


/*
hooks 

wp_head
wp_body_open

*/




add_shortcode('min_menu_home_1',function(){
	    echo do_shortcode('[_main_menu_html]');  
});

add_shortcode('_main_menu_html',function(){
	?>
	
	
	
<style type="text/css"> 
 

@media(max-width:<?php  echo CM_MENU_WIDTH;?>){
.main_custom_menu,.relative_custom_menu{
  display:none
}
}
 

</style>

<?php 
$img = 'https://wpbakery.softbricks.ro/wp-content/uploads/2023/10/cropped-logo.jpg';

?>
<div class='main_custom_menu' id='main_custom_menu_id'>
    <div class='wrap'>
	<div class='icon'>
	
		<img src="<?php echo $img; ?>">
	</div>
	
	<div class='search'>
	<?php echo do_shortcode("[fibosearch]");?>
	</div>
	<div class='main_custom_menu_regular_content'>
		<div class='list'>
			<div class='item'>
				<div class='item_wrap'>
					<div class='icon'>icon</div>
				    <div class='text_content'>Conten etwe we</div>
				</div>
				<div class='icon_sub_content_items'>
					<div class='icon_sub_content_wrap'>
						<div class='icon_sub_content_content'>
							eef<br>
							 ef<br>
							icon_sudb_content<br>
							icon_sub_content<br>
						</div>
					</div>
				</div>
			</div>
			<div class='item'>
				<div class='item_wrap'>
					<div class='icon'>icon</div>
				    <div class='text_content'>Conte wefwef nt</div>
				</div>
				<div class='icon_sub_content_items'>
					<div class='icon_sub_content_wrap'>
						<div class='icon_sub_content_content'>
							icon_sudb_content<br>
							icon_sudb_content<br>
							eee<br>
							icon_sub_content<br>
						</div>
					</div>
				</div>
			</div>
			<div class='item'>
				<div class='item_wrap'>
					<div class='icon'>icon</div>
				    <div class='text_content'>Content cu full</div>
				</div> 
				<div class='main_custom_menu_absolute'>
					<div class='content_absolute_wrap' id=''>
						<div class='content_absolute' id=''>
							content_absolute
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	</div>	
</div>

<?php 

	if(is_home()){
	?>  <?php	
	}
?>

<style>

@media(min-width:<?php  echo CM_MENU_WIDTH;?>){
	.relative_custom_menu{
	height:140px;
	width:100%;
	display:table; 
}
}

#main_custom_menu_id{
	position:sticky !important;
}
</style>

 
<div class='relative_cu stom_menu' id='main_custom_menu_rel_id'></div>
  
<script>

  $(window).scroll(function() {
	  
	  if( $(window).width() > 800){
	  
    var top_of_element = $("#main_custom_menu_rel_id").offset().top;
    var bottom_of_element = $("#main_custom_menu_rel_id").offset().top + $("#main_custom_menu_rel_id").outerHeight();
    var bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
    var top_of_screen = $(window).scrollTop();

    if ( !((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element))){
        // the element is visible, do something
		//$('#main_custom_menu_id').fadeOut().hide();
		$('#main_custom_menu_id').addClass('fixed');
    } else {
        // the element is not visible, do something else
		//$('#main_custom_menu_id').fadeIn().show();
	    $('#main_custom_menu_id').removeClass('fixed');
    }
	  }else{
		  $('#main_custom_menu_id').hide()
	  }
});
  

</script>
<script type="text/javascript">
	console.log(' ')
	
	
	
	

<?php echo '//'.__FILE__;?>
</script>
	
	<?php 
});