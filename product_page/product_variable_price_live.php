<?php
///////////////////////
// https://stackoverflow.com/questions/18259241/proper-way-to-link-ajax-url
// https://stackoverflow.com/questions/18259241/proper-way-to-link-ajax-url
//

  new AjaxPaginaProdusPret22();

class AjaxPaginaProdusPret22
{
    public function __construct()
    {

         

        add_action('wp', array($this, 'pretttt')); // inlociureste pretul cu html
	    add_shortcode('custom_price',array($this, 'pretttt'));
        add_action('wp', array($this, 'detect_product_for_js_footer')); // inlociureste pretul cu html

       add_action('woocommerce_single_product_summary', function () {
		  echo $this->pretttt();
		  
		   //echo 'test';
            //// return 'test';
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);

            //remove_action('woocommerce_template_single_price');
        
		// inainte de pret
		add_action('woocommerce_single_product_summary', function(){
			$this->content_eticheta_sub_pret() ;
			//echo '<div>.</div>';
		},7);
		  
			}, 9);

        // add_action('wp_footer', array($this, 'load_script_to_remove_arrow'));

    }
    public function detect_product_for_js_footer()
    {
        if (get_post_type() == 'product') {
            add_action('wp_footer', array($this, 'detect_attributes_js'));
        }
    }

    public function pretttt()
    {
        //global $post;print_r( $post  );
 
        
            global $post;
			///print_r($post);
            if (is_a($post, 'WP_Post')) {  
                if ($post->post_type == 'product') {
					//echo 'efwef';
                    $product = wc_get_product(get_the_id());

                    $html = '';
                    if ($product->is_type('simple')) {
                        // SIMPLU
                        //  echo 'rr';
                        //print_r($product);
                        $pret = $this->wpglorify_simple_price_format($product);
                        if ($pret != false) {
                            $html = "<div id='pret_initial'>" . $pret . "</div>";
                        } else {
                            $html = "<style>#price_wrap{display:none}</style>";
                            // nu are pret
                        }
                    }
                    //
                    if ($product->is_type('variable')) {
// VARIABIL
 

                        $html = '';

                        $init_pret = $this->wpglorify_variation_price_format($product);

                        if ($init_pret != '' && $init_pret !== false) {
                            $html .= "<div style='' id='pret_initial'>" . $init_pret . "</div>";
                        } else {
                            // $min_var =  $this->min_variation( $product);
                            // $pret_min = $this->get_var_product_html_price($product->ID,$min_var );
                            $html .= "<div style='' id='pret_initial'> " . "</div>";
                        }

                        $html .= "<div id='stiva_pret' style='display:none'>" . $this->html_price_list($post->ID) . "</div>";

                    }
                    //https://stackoverflow.com/questions/63133918/display-tax-status-on-woocommerce-admin-product-list?rq=1

                    $class_tip_afisare_pret = $this->price_display_type($html);

                    $arez =  "<div class='$class_tip_afisare_pret' id='price_wrap'>";
                    $arez .= $html;
                 //   echo "<div id='tva_inclus'>" . get_option('woocommerce_price_display_suffix') . "</div>";

                    $arez .= "</div>";
					
					$stil = '
					<style>
					/* ascunde pretul de sub select produs variabil*/
					.single_variation_wrap .woocommerce-variation.single_variation{display:none !important}
					</style>
					';
					
					return  $arez . $stil;
					// are echo
					// dupa pret
					 // $this->content_eticheta_sub_pret() ;
                }
            }
           
    }
	
	function content_eticheta_sub_pret(){
		 global $product;
		 global $post;
		 if( has_term('produse_vrac','product_tag',$post) && $product->product_type == 'variable'){
			  
			  echo "<div class='eticheta__sub_pret'>". wc_price($product->get_price()).'/100g' ."</div>";
		  }
		 
	}

    public function price_display_type($html)
    {
        if (strpos($html, 'html_sale_price') !== false
            && strpos($html, 'html_regular_price') !== false) {
            return 'mixt';
        }
        if (strpos($html, 'html_regular_price') !== false
            && !(strpos($html, 'html_sale_price') !== false)) {
            return 'simplu';
        }
        if (!(strpos($html, 'html_regular_price') !== false)
            && !(strpos($html, 'html_sale_price') !== false)) {
            return 'no_price';
        }
    }

    public function wpglorify_simple_price_format($product)
    {
        if (is_a($product, 'WC_Product_Simple')) {
            $r_price = $product->get_price();
            $s_price = $product->get_regular_price();
            ///echo 'prtet detect'.$s_price.'-' .$r_price.'--';
            if ((floatval($r_price) + floatval($s_price)) == 0) {return false;}

            if ($r_price == '' && $s_price == '') {
                return false;
            }
            // echo 'prtet 2';
            $price = '';
            //echo "$r_price, $s_price";

            if ($r_price === $s_price && $s_price == 0) {
                return false;
            }
            // return $r_price.'--'. $s_price;

            if ($r_price !== $s_price && $s_price != '') {
                $price = $this->format_prices($r_price, $s_price);
            } else {
                $price = $this->format_prices($s_price, '');
            }
            return $price;
        }
        return false;
    }
    /////////////////////////////////
    public function min_key($assoc)
    {
        if ($this->countable($assoc)) {
            $key = array_keys($assoc, min($assoc));
            if ($this->countable($key)) {
                return $key[0];

            }}
        return false;
    }

    public function countable($ar)
    {
        if (is_array($ar)) {
            if (count($ar) > 0) {
                return true;
            }
        }
        return false;
    }

//echo min_key(array(2 => 34, 5 => 4));
    public function compare_assoc_min($assoc1, $assoc2)
    {
        if ($this->countable($assoc1) && $this->countable($assoc2)) {} else {

            if ($this->countable($assoc1)) {
                return $this->min_key($assoc1);
            }
            if ($this->countable($assoc2)) {
                return $this->min_key($assoc2);
            }
            return false;}
        // echo 'caza 1';
        if (min($assoc1) < min($assoc2)) {

            return $this->min_key($assoc1);
        } else {
            return $this->min_key($assoc2);
        }
    }

    public function min_variation($product)
    {
        ///print_r($product);
        if (is_object($product)) {
            $available_variations = $product->get_available_variations();
            $regular              = array();
            $sale                 = array();

            foreach ($available_variations as $item) {

                if ($item['display_price'] != $item['display_regular_price']) {
                    $regular[$item['variation_id'] . ''] = $item['display_price'];
                    $sale[$item['variation_id'] . '']    = $item['display_regular_price'];
                } else {
                    $regular[$item['variation_id'] . ''] = $item['display_price'];
                }}
            // echo 'sale';
            //  print_r($sale); echo 'reg<br>';
            // print_r($regular);
            $if_selectat = $this->compare_assoc_min($sale, $regular);
            //   print_r( $if_selectat);
            // echo '--'.  $if_selectat .'==';
            if ($if_selectat == 0) {return false;}
            return $if_selectat;
        } else {
            return false;
        }
    }
    /////////////////////////////////////

    public function default_price_of_variable_products($product)
    {
        //echo 'DEFAULT';
        $available_variations = $product->get_available_variations();
        $selectedPrice        = '';
        $dump                 = '';

        $variation_default_id = '';

        foreach ($available_variations as $variation) {
            // $dump = $dump . '<pre>' . var_export($variation['attributes'], true) . '</pre>';

            $isDefVariation  = false;
            $array_default   = array();
            $array_variation = array();
            foreach ($product->get_default_attributes() as $key => $val) {
                // $dump = $dump . '<pre>' . var_export($key, true) . '</pre>';
                // print_r(  $val  ); echo '--';
                // echo  $variation['attributes']['attribute_'.$key];
                //  echo '--||';
                if ($variation['attributes']['attribute_' . $key] == $val) {
                    $array_default   = array($val);
                    $array_variation = array($variation['attributes']['attribute_' . $key]);
                    $isDefVariation  = true;
                    //echo $variation['variation_id'] ;
                    $variation_default_id = $variation['variation_id'];

                }
            }

            if ($array_variation == $array_default && count($array_variation) > 0) {

                return $this->get_var_product_html_price($product, $variation_default_id);
            }

        }

        return false;
    }

    ////////////////////////////////////
    //https://wpglorify.com/show-lowest-price-woocommerce-variable-products/
    public function wpglorify_variation_price_format($product)
    {

        $def_price = $this->default_price_of_variable_products($product);

        if ($def_price) {return $def_price;}

        if (is_object($product)) {

            $id = $this->min_variation($product);

            if (!$id) {} else {

                $product = wc_get_product($id);
                //print_r($product);
                $saleprice = $product->get_sale_price();
                $price1    = $product->get_regular_price();

                //echo $price1 . '--' . $saleprice.'==';
                //if($saleprice== $price1 && $saleprice==0){ return false;}
                //echo "LIBE";
                //  echo $price1 . '--' . $saleprice.'==';
                $html = $this->format_prices($saleprice, $price1);

                return $html;

            }}return '';
    }

    public function get_var_product_html_price($parent_id, $product_id)
    {
        // echo $product_id .']]';
        $variation_price = $this->get_variation_price_by_id($parent_id, $product_id);

        if (!is_object($variation_price)) {
            return false;
        }

//     print_r($variation_price);

        $price_reg =  $variation_price->display_regular_price ;

        $saleprice =  $variation_price->display_price ;

        $price = '';
        if ($price_reg !== $saleprice && $saleprice != '') {

            $price = $this->format_prices($saleprice, $price_reg);
        } else {
            $price = $this->format_prices($price_reg, '');
        }

        return $price; // . $price_reg;

    }

    public function format_prices($sale_1, $regular_1, $id_variatiune = '')
    {

        $regular =  $this->local_number_format( max(array($sale_1, $regular_1)) );
        $sale    = $this->local_number_format( min(array($sale_1, $regular_1)) );

        if (floatval($regular) == 0) {
            ///$regular = 'test';
        }
    

        // $regular = number_format( $regular,2);
        // $sale = number_format( $sale, 2);
        if (floatval($sale) == 0 && floatval($regular) != 0) {
            $sale    = $regular;
            $regular = '';
            //echo "$sale = $regular;";
        }

        $display     = '';
        $addes_class = 'start_price';

        $id_html = " id='pret_html' ";

        if ($id_variatiune !== '') {
            $addes_class = ' custom_variation_price ';
            $display     = ' disply:none '; // de facut cu
            $id_html     = " id='v_$id_variatiune' ";
        }
        $html_reg = '';
        if ($regular == 0) {} else { 
                 
/* exceptie - doar pt herbalrom , pt ca se stie ca formatarea se face la 1 zecimala*/			 $regular = str_replace(',0','',$regular);
			if($regular!=''){
				$regular = $regular . '&nbsp;<span class="woocommerce-Price-currencySymbol">'.get_woocommerce_currency_symbol().'</span>';
			}
            $html_reg = '<del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi id="html_sale_price">' . $regular . ' <span class="woocommerce-Price-currencySymbol"></span></bdi></span></del>';

        }

        /// $regular = number_format( $regular,2);
        /// $sale = number_format( $sale, 2);
 
        //$sale = str_replace('.',',',$sale);
		 $sale = str_replace(',0','',$sale);
        $sale = $sale . '&nbsp;<span class="woocommerce-Price-currencySymbol">'.get_woocommerce_currency_symbol().'</span>';

        return '<p style="' . $display . '" ' . $id_html . ' class="' . $addes_class . ' price"  > '
            . $html_reg
            . '<ins><span class="woocommerce-Price-amount amount"><bdi id="html_regular_price">' . $sale . '</bdi></span></ins></p>';
    }
    public function get_tax()
    {
        global $post, $product;

        // Excluding variable and grouped products
        if (is_a($product, 'WC_Product')) {

///////////
            /*
            Afiseaza taxa aplicata la produs
            $tax_rates = WC_Tax::get_rates( $product->get_tax_class() );
            if (!empty($tax_rates)) {
            $tax_rate = reset($tax_rates);
            print_r( $tax_rate );
            return  sprintf(_x('Price without %.2f %% tax', 'Text for tax rate. %.2f =
            tax rate', 'wptheme.foundation'), $tax_rate['rate']);
            }
             */
/////////////
            /*
        Semnalizeaza daca produsul este impozitabil
        $args =  array(
        'taxable'  => __( 'Taxable', 'woocommerce' ),
        'shipping' => __( 'Shipping only', 'woocommerce' ),
        'none'     => _x( 'None', 'Tax status', 'woocommerce' ),
        );
        return  $args[$product->get_tax_status()];
         */
        }
        return false;
    }
    //////////////////////////////////////////

    public function detect_attributes_js()
    {

        ?>
			<script>

// Lista atributelor conform formularului
function get_attr_data_array() {
    var form_data = $('.variations_form.cart').data('product_variations')
    var form_attr_list = Object.keys(form_data[0].attributes)
    return form_attr_list.sort()
}
// rezerva - nu se foloseste aici
function nr_attr() {
    var form_data = $('.variations_form.cart').data('product_variations')
    var form_attr_list = Object.keys(form_data[0].attributes)
    return form_attr_list.length
}
// Lista atributelor conform selectiei de catre utilizator
function get_attr_select_elem() {
    var attr_selectori = []
    $('.avada-select-parent select').each(function() {
        attr_selectori.push($(this).attr('name'))
    })
    return attr_selectori.sort()
}
// functie pt testes de egalitate array
function arrayEquals(a, b) {
    return Array.isArray(a) && Array.isArray(b) && a.length === b.length && a.every((val, index) => val === b[index]);
}
// rezerva - nu se foloseste : verifica corespondenta dintre formuar si selecturi
function checkVariationAndSelect() {
    var form_attr_list = get_attr_data_array();
    // culege selectori din selecturi
    var attr_selectori = get_attr_select_elem()
    if (arrayEquals(attr_selectori, form_attr_list)) {
        return true
    } else {
        return false;
    }
}
///////////////////////
// Alcatuieste lista atribute din selecturi verificare  variatie selectata
function getSelectedAttributeValuesFromForm() {
    var attr_selectate_name = [];
    var attr_selectate_vals = [];
    // selecturi cu valroi
    $('.avada-select-parent > select').each(function() {
        /// attr_selectate.push($(this).attr('name'))
        var current_val = $(this).val()
        //  console.log( current_val )
        //  console.log(  $(this).attr('name') )
        if (current_val !== '') {
            attr_selectate_name.push($(this).attr('name'))
            attr_selectate_vals.push(current_val)
        }
    })
    return {
        name: attr_selectate_name,
        vals: attr_selectate_vals
    }
}
Array.prototype.hasMin = function(attrib) {
    return (this.length && this.reduce(function(prev, curr) {
        return prev[attrib] < curr[attrib] ? prev : curr;
    })) || null;
}
/////////////
///////////////
// Returneaza id variatie.
function get_id_of_variation() {
    // Fiecare variatie
    var variations_out = []
	var all_data = $('.variations_form.cart').data('product_variations')
	if(all_data.length>0){}else{return}
   all_data.forEach(checkFunction)
    ///////////////
    // Verificare potrivire o variatie din formular cu selectia
    function checkFunction(item, index, arr) {
        var variatie_obj = arr[index].attributes;
        var var_name = Object.keys(variatie_obj); // nume atribute din formular
        var var_vals = Object.values(variatie_obj); // valori atribute din formualr
        //  console.log(var_vals)
        var nr_attr_de_verificat = 0;
        var nr_attr_corespondente = 0;
        var current_selected = getSelectedAttributeValuesFromForm()
        var attr_selectate_name = current_selected.name // nume atribute din select
        //console.log(attr_selectate_name)
        var attr_selectate_vals = current_selected.vals // valori atribute din select
        //console.log(attr_selectate_vals)
        // pp. ca ordine atributelor este identica in lista atribute formular si lista atribute select
        // si lista atributelor formular si lista atributelor select au acelasi nr de elemente
        for (var i = attr_selectate_name.length - 1; i >= 0; i--) {
            //attr_selectate_name[i]
            //  attr_selectate_vals[i]
            if (var_vals[i] !== '') {
                nr_attr_de_verificat++
                //console.log(attr_selectate_vals[i] + ' ' + var_vals[i])
                if (attr_selectate_name[i] == var_name[i] && attr_selectate_vals[i] == var_vals[i]) {
                    nr_attr_corespondente++
                }
            }
        }
        // console.log(nr_attr_corespondente +' '+nr_attr_de_verificat)
        if (nr_attr_corespondente == nr_attr_de_verificat) {
            var out_obj = {}
            out_obj.id = arr[index].variation_id
            $pret_1 = arr[index].display_price
            if (parseFloat($pret_1) > 0) {
                out_obj.pret = Math.min($pret_1, arr[index].display_regular_price)
            } else {
                out_obj.pret = arr[index].display_regular_price
            }
            // global  variations_out
            variations_out.push(out_obj)
            //console.log( arr[index] )
            // de scos id din variatie_obj
        }
    }
    ///////////////
    console.log(variations_out)
    if (variations_out.length > 0) {
        return variations_out.hasMin('pret').id
    } else {
        return false;
    }
}

//console.log(get_id_of_variation())

function afisare_preturi( ) {
	$ = jQuery;
    //   console.log( get_id_of_variation() );
    var id = get_id_of_variation()

if( $('#v_' + id).length > 0 && id!==false )// exista pretul aferentu udului
{
    $('#pret_initial').hide()
    $('#start_price').hide()

    $('#start_price').show()
    $('.custom_variation_price').hide()
    $('#stiva_pret').show()
    $('#v_' + id).show()

}else{ // nu a fost gasit sau id este false
   $('#pret_initial').show()
    $('#start_price').show()

    $('#start_price').hide()
    $('.custom_variation_price').hide()
    $('#stiva_pret').hide()
    $('#v_' + id).hide()
}

}
/////////////////////////////////////////////
// scanare atribute select
// scanare atribute formular
// la select change
// se verifica
/////////////////////////////////
///////////////////////////////////////////

// La select pe select Avada
$ = jQuery;
$('.variations  select').change(function() {
    detect_on_click()
})
// Selectori pentru butoane, imagini si culori Avada
var selector='.avada-select-wrapper  .avada-button-select,'
selector += ' .avada-select-wrapper   .avada-image-select,'
selector += ' .avada-select-wrapper   .avada-color-select '
// La click
$(selector).click(function() {
	///////////////
	//
    //	 trebuie dublu click pentru a folos selectul,
	//	 din spatele fiecarui atribut
    //	 fiecare attribut are valori, care la click , muta un select
    //
	///////////////
    setTimeout(function(){
        detect_on_click()
    },50)
    //},12)
})

// Eveniment comun, click si select care initiaza detectia de id variatie
function detect_on_click() {
    var val_cules = get_id_of_variation()
    console.log('cules:' + val_cules);
    afisare_preturi();
}

		</script>
	<?php
}

    public function get_products_by_attr_values($parent_id, $assoc)
    {
        //print_r($parent_id);
        $args = array(
            'post_type'      => array('product'),
            'post_status'    => 'publish',
            'posts_per_page' => 2,
            'parent_id'      => $parent_id,
            /*'meta_query'     => array( array(
        'key' => '_visibility',
        'value' => array('catalog', 'visible'),
        'compare' => 'IN',
        ) ),*/

        );

        $args['tax_query'] = array();

        if (count($assoc) > 0) {
            foreach ($assoc as $attr => $vals) {
                $args['tax_query'][] = array(
                    'taxonomy' => $attr,
                    'field'    => 'name',
                    'terms'    => array($vals),
                    'operator' => 'IN',
                );
            }
        }

        $products = new WP_Query($args);
        //print_r($products->posts);
        // The Loop
        //$product_obsj = array();
        if ($products->have_posts()): while ($products->have_posts()):

                $a             = $products->the_post();
                $product_ids[] = $products->post->ID;
                //$product_obsj[] = $products->post->ID;
                //print_r($a );
                //echo 'rrr' ;
            endwhile;
            wp_reset_postdata();
        endif;

        return $product_ids;
    }
// https://www.majas-lapu-izstrade.lv/get-woocommerce-product-variation-price-and-sale-price-for-your-pricing-table/
    public function get_variation_price_by_id($product_id, $variation_id)
    {
        $currency_symbol = get_woocommerce_currency_symbol();
        $product         = new WC_Product_Variable($product_id);
        $variations      = $product->get_available_variations();
        $var_data        = [];
        foreach ($variations as $variation) {
            //print_r($variation);
            if ($variation['variation_id'] == $variation_id) {
                $display_regular_price = $variation['display_regular_price'];
                $display_price         = $variation['display_price'];
            }
        }

        //Check if Regular price is equal with Sale price (Display price)
        if ($display_regular_price == $display_price && $display_price !== '') {
            $display_price = 0;
        }

        if (floatval($display_regular_price) == 0 && floatval($display_price) == 0) {
            return false;
        }

        $priceArray = array(
            'display_regular_price' => $display_regular_price,
            'display_price'         => $display_price,
        );
        $priceObject = (object) $priceArray;
        return $priceObject;
    }

    public function price_of_attributes_html($parent_id, $attr_assoc_array)
    {

        // perechi de atribute si valori
        if (count($attr_assoc_array) > 0) {
            // iduri de variatii cu atributele alese
            $prod__vals = $this->get_products_by_attr_values($parent_id, $attr_assoc_array);
            /// echo 'tsest->';
            /// print_r( $prod__vals );
            if ($prod__vals) {
                if (count($prod__vals) > 0) {
                    // pret formatat
                    //print_r($prod__vals);     // parent,        variation
                    echo $this->get_var_product_html_price($parent_id, $prod__vals[0]);
                    // echo'wef';
                }
            }
        }
    }

    public function get_variations_id($parent_id)
    {
        $o         = array();
        $product_s = wc_get_product($parent_id);
        if ($product_s->product_type == 'variable') {
            $variations = $product_s->get_available_variations();
            // echo "VARIATII: ";
            // print_r(  $variations );
            foreach ($variations as $item) {
                $o[] = array('v_id' => $item['variation_id']
                    , 'display_regular_price' => $item['display_regular_price']
                    , 'display_price' => $item['display_price'],
                );
            }
        }
        return $o;
    }

    public function html_price_list($parent_id)
    {

        $ids = $this->get_variations_id($parent_id);

        $h = '';
        foreach ($ids as $rand_info) {
            $reg_p = '';
            $sel_p = '';

            $sel_p =  $rand_info['display_price'] ;
            if ($rand_info['display_price'] != $rand_info['display_regular_price']) {
				
				$s  = min($rand_info['display_price'],$rand_info['display_regular_price']);
				$p  = max($rand_info['display_price'],$rand_info['display_regular_price']);
               $sel_p =  $s ;
			   $reg_p =  $p  ;
            }
            $price = $this->format_prices($sel_p
                , $reg_p
                , $rand_info['v_id']);

            $h .= $price;
        }
        return $h;
    }

    public function local_number_format($x) { /// $out = '';
	 /// if( floatval($x)- intval($x) ==   0 ){
	///	   $out =  intval($x);
	 // }else{
		  
	  $out  =   number_format(  floatval($x)	  ,1, ',' , '.' );
	  //}
	  return $out;
	return  str_replace(',0','',$out);
	}

}
