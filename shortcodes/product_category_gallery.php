<?php 

add_action('init','init_gal_cat');
// [galerie_set id='33' cols='3']
function init_gal_cat(){
	add_shortcode('galerie_set','galerie_set_function');
}

function galerie_set_function($atts){	
	
	   $shData = shortcode_atts(array(
            'id' => '',   
			'cols'=>'3',
			'titlu'=>'',
		// ??	'limit' 
            
        ) , $atts);
	  
	$tiltu_html = '';// 16325
	  
	if( $shData['titlu'] =='da' ){
		$tiltu_html = do_shortcode("[continut_post id='16325']");
	}
	  
	if( $shData['id']!=''){ 
	
	//echo $shData['id'].'>>';
	///  print_r( get_post( $shData['id'] ) );
			  
				//echo "<hr>";
				//
				// exista Lista categorii , in obiect  cu id $shData['id']
				$vals = get_field( 'lista_categorii',$shData['id'] ) ;
				
				 /// print_r( $vals  );
				
				$cats_ids = array() ;
				
				if( is_array($vals )){
					if(count($vals )>0){
						foreach( $vals as $cat ){
							$cats_ids[] =  $cat ;
						} 
					}
					
				}
				 $ids = implode(',',$vals);
						
		  return $tiltu_html.
		      do_shortcode( "[galerie_categorii ids='$ids' cols='{$shData['cols']}']" )   ; 
				 
					 
				 
	} 
}

///////////////////////////////////////////
///////////////////////////////////////////
///////////////////////////////////////////
  
//imagine_galerie_categorii

function product_cat_gallery_function( $atts ) {
	
	$rand_uni = rand(11111,999999);
	
	
	
	$in = shortcode_atts( array(
		'tip' => 'normal',
		'ids'=>'',
		'cols'=>'4' 
		//'bar' => 'something else',
	), $atts );
	 
	 $id_string = $in['ids'];
	  
	 /////////////////////////////////
	if( $id_string!=='' ){ // daca din sh nu are iduri
	  	
	}else{
		if(is_tax( 'product_cat' )){ // daca sh este pe pagina categ
			 $id_string =  get_queried_object()->term_id.'' ;
		}
	}
 // echo $id_string  ;
	// daca inca nu are iduri
	  if($id_string  === ''){return '';}
	
	 /////////////////////
	  
	 
	if($in['cols']===''){
		$in['cols'] = 3;
	}
		 $cols =$in['cols']; 
	$date_categorii = array();
	 $id_array =  explode( ',', $id_string  ) ;
	
	
		// echo $in['tip'];
	 if($in['tip'] == 'normal'){  
	 
			$date_categorii =  get_date_categorii_dupa_id_simplu($id_array)   ;
		} 
  
	
	
	///////////////
	
	if( $in['tip'] == 'parinte' ){
		if( $id_array  > 0 ){
			$id_parinte = $id_array[0];
			// echo $id_parinte;
			$date_categorii = get_date_categorii_dupa_parinte( $id_parinte ) ; 
		}  
	} 
     if( $in['tip'] == 'bunic'){
	 
		if( $id_array> 0 ){
			$id_parinte = $id_array[0];
			$date_categorii = get_date_categorii_dupa_bunic(  $id_parinte  ) ;
		} 
	} 

  
 
  if( ! is_countable( $date_categorii ) ){ return '';  }

	if(count($date_categorii)>0){
		 //print_r($row_data_2);		
		$row_data_2 = array_chunk($date_categorii , $cols);
  
		$html = ''; 
		 
		$class_rand = '';      
 //print_r($row_data_2);		
		foreach($row_data_2 as $nr_rand => $data_row){ 
			   
			foreach($data_row as $nr_item => $data){
				//	print_r($data);
				$title=$data->name; 
				$img_html = '';
				$meta_img = get_term_meta($data->term_id,'imagine_galerie_categorii',true)  ;
			
			//  print_r($meta_img);
			
			$name = $data->name;
				$link = get_term_link($data);
			 
			$nume_meta = get_term_meta($data->term_id,'nume_in_galerie',true)  ;
			 //print_r($nume_meta ); 
			if($nume_meta !==''){
				$name = $nume_meta ;
			}
			//$name = "<div class='title'><a href='$link'>".$nume_galerie."</a></div>";
			
			$meta_img_url ='';
		if($meta_img !==''){
			 $meta_img_url = wp_get_attachment_url( $meta_img );
			 $img_html = "<div class='image'><a href='$link'><img src='$meta_img_url'/></a></div>";
			 
		}
		 
			$mess = "<div class='inner_product_galery_item'>".$img_html.$name."</div>"; 
	
		///	$class_rand  
			   $html .= div_cell($title,$name,$meta_img_url,$link,$cols,$nr_item, $nr_rand,$rand_uni); //cat_cel_fusion($mess ,$in['cols']);
			}
		}
		return    "<div class='fusion-builder-row fusion-row galerie_categorii'>".$html ."</div>";// do_shortcode(cat_row($html)); 
	}else{
		return '';
	} 
}


function div_cell($title='',$text,$url,$link,$cols,$ordine_item,$rand,$rand_num ){
	if($url==''){
		$url = 'https://stef.ro/wp-content/uploads/2021/04/carti-de-vizita.png';
	}
	$ordine_item++;
	$m_right_nr  = 1;
$w_perce = 100/intval($cols) - 	$m_right_nr ;

$m_right =	$m_right_nr .'%';
if($ordine_item==$cols){
	$m_right='0px';
}

// procesare titlu
$text = $text. strlen( $title  );
if( strlen($text  )>35){
			//	$text = substr($text,  0,  35).'...';
			}
			
	return <<<EOL
	
<div data-uni="$rand_num" data-cols='$cols' data-row='$rand' class="cell_$cols casuta_categorie">
    <div class="wrap_galerry_cell">
        <div class='img_frame'><a href='$link'><img src="$url" width="130" height="130" alt="$title"></a></div>
        
        <div >
            <h3 class=" " style="margin: 0px; font-size: 14px;" data-inline-fontsize="true" data-fontsize="14" data-lineheight="19"><a class='titlu_casuta' title="$title" href="$link">$text</a></h3>
        </div> 
    </div>
</div>
EOL;
}
function cat_cel_fusion($title='',$text,$url,$link,$cols,$ordine_item,$rand,$rand_num){
	if($url==''){
		$url = 'https://stef.ro/wp-content/uploads/2021/04/carti-de-vizita.png';
	}
	$ordine_item++;
	$m_right_nr  = 1;
$w_perce = 100/intval($cols) - 	$m_right_nr ;

$m_right =	$m_right_nr .'%';
if($ordine_item==$cols){
	$m_right='0px';
}
	return <<<EOL

<div data-uni="$rand_num" data-cols='$cols' data-row='$rand' class=" casuta_categorie fusion-layout-column fusion_builder_column fusion_builder_column_1_$cols fusion-builder-column-$cols fusion-one-fifth fusion-column-last coloana_subcategorie 1_$cols" style="margin-top:5px;margin-bottom:5px;margin-right:$m_right;width:{$w_perce}%;max-width:{$w_perce}%">
    <div class="fusion-column-wrapper" style="  background-position: left top; background-repeat: no-repeat; background-size: cover; min-height: 212px; height: auto;" data-bg-url="">
        <span style="width:100%;max-width:130px;" class="fusion-imageframe imageframe-none imageframe-5 hover-type-none img_coloana_subcategorie"><a class="fusion-no-lightbox" href="$link" target="_self" aria-label="pensule-pictura"><img src="$url" width="130" height="130" alt="$title" class="img-responsive wp-image-16448"></a></span>
        <style type="text/css">
        @media only screen and (max-width:750px) {
            .fusion-title.fusion-title-7 {
                margin-top: 5px !important;
                margin-bottom: 5px !important
            }
        } 
        </style>
        <div class="fusion-title title fusion-title-7 fusion-sep-none fusion-title-center fusion-title-size-three fusion-border-below-title" style="font-size:14px;margin-top:5px;margin-bottom:5px;">
            <h3 class="title-heading-center" style="margin: 0px; font-size: 14px;" data-inline-fontsize="true" data-fontsize="14" data-lineheight="19"><a title="$title" href="$link">$text</a></h3>
        </div> 
    </div>
</div>
EOL;
} 

function div_row($x){
	return "<div class='set_category_row'>$x</div>";
}

function cat_row($x){
 return '[fusion_builder_container hundred_percent="no" hundred_percent_height="no" hundred_percent_height_scroll="no" hundred_percent_height_center_content="yes" equal_height_columns="yes" menu_anchor="" hide_on_mobile="small-visibility,medium-visibility,large-visibility" status="published" publish_date="" class="" id="" background_color="" background_image="" background_position="center center" background_repeat="no-repeat" fade="no" background_parallax="none" enable_mobile="no" parallax_speed="0.3" video_mp4="" video_webm="" video_ogv="" video_url="" video_aspect_ratio="16:9" video_loop="yes" video_mute="yes" video_preview_image="" border_size="" border_color="" border_style="solid" margin_top="" margin_bottom="" padding_top="" padding_right="" padding_bottom="" padding_left=""][fusion_builder_row]'
  .$x.'[/fusion_builder_row][/fusion_builder_container]';
}
 

function get_date_categorii_dupa_id_simplu( $id_array , $nr = ''  ){
	   
	 $args_term = array(
    'taxonomy' => 'product_cat',
	'limit'=>-1,
	 
    'include' => $id_array, 
    'hide_empty' => false,
);
	  
	  
  $terms = get_terms($args_term);    return $terms ;
  /////////
  ////////
if(    count($terms)>0){

	$new_term = array();
	  //  print_r( $id_array );  
	foreach(  $id_array as $id ){
			
	    //    echo "<pre>"; 
			$data = term_array_item(   $terms, $id);

			if( $data != '' ){
				
				// de modificat 
				 
				 $new_term[ $id ] = $data;   
			}
	}
		 // print_r($new_term);
		
	  //sort($new_term); 
	 $terms = $new_term;
} 

 //print_r( $terms ); 
if( count($terms)>0 ){return $terms;}else{
		return array();
	} 
}

function get_date_categorii_dupa_id(    $id_array,$nr = '', $tip_ordine='id'){
	  
	
	   
	  
	 $args_term = array(
    'taxonomy' => 'product_cat',
	'limit'=>-1,
	 
    'include' => $id_array, 
    'hide_empty' => false,
);
	  
	  
  $terms = get_terms($args_term);
if( $tip_ordine =='id' &&   count($terms)>0){

	$new_term = array();
	
	foreach(  $id_array as $id ){
			//print_r( $id );  
	    //    echo "<pre>"; 
			$data = term_array_item(   $terms, $id);

			if( $data != '' ){
				
				// de modificat 
				
				$taxonomy ='product_cat';
				$term_id = $data->term_id;
				$ordine = $ordine = get_field('field_6065b2696f456', $taxonomy . '_' . $term_id) ;
				  
				 $new_term[  cm_letter($ordine).''.$id ] = $data;   
			}
	}
		// print_r($new_term);
		
	  ksort($new_term);
	 //print_r($new_term);
	$terms = $new_term;
	
}

	if(count($terms)>0){return $terms;}else{
		return array();
	} 
}

///////////
global $letter_list;
$a = array();
function cm_letter_list(){
foreach (range('a','z') as  $l1) {
	foreach (range('a','z') as  $l2) {
	 	//foreach (range('a','z') as  $l3) {
          $a[]= $l1.$l2;
//}
	}}
return $a; }

$letter_list = cm_letter_list();

 function cm_letter($i){
	 global $letter_list;
	 if(isset($letter_list[$i])){return $letter_list[$i];}else{return '';}
 }
 
 
function term_array_item($arr,$id){
	foreach($arr as $i){ 
		if($i->term_id == $id){
			return $i;
		}
	}
	return '';
}
///////////////


function get_date_categorii_dupa_parent_id(    $id , $nr = 3333){
 
	 // if(is_tax( 'product_cat', $parinte )){
	  $terms = get_terms([
		'taxonomy' => 'product_cat',
		'parent'=>$id ,
		 'number'=>5, 
		'hide_empty' => false,
		  ]);
		  //print_r($terms);
	 // }
 
	if(count($terms)>0){ $o= array();
		foreach($terms as $t){$o[]=$t->term_id;}
		return $o;}else{
		return array();
	} 
}

function get_date_categorii_dupa_bunic(    $parinte = '',$nr =''){
	$terms = get_term_children( $parinte,'product_cat');
	if(count($terms)>0){
		   $data = get_date_categorii_dupa_id( $terms , $nr ); 
//echo "<pre>";		
		  //print_r( $data);
		   return $data;
	}else{
		  return array();
	}
} 

function get_date_categorii_dupa_parinte(    $parinte = '',$nr =''){
 
  //get_term_children( $parinte,'product_cat');
	//if(is_tax( 'product_cat', $parinte )){
		$data = get_date_categorii_dupa_parent_id( $parinte,'product_cat');
	
		$data  = get_date_categorii_dupa_id($data ,$nr);
	  
if(count($data)>0){		  
		 return $data;  
	}else{
		  return array();
	}
} 

/*
[galerie_categorii cols='3' ids='' tip='']
*/
add_shortcode('galerie_categorii', 'product_cat_gallery_function');
 