<?php
/*
 * wc_remove_related_products
 * 
 * Clear the query arguments for related products so none show.
 * Add this code to your theme functions.php file.  
 */
function wc_remove_related_products( $args ) {
	return array();
}
add_filter('woocommerce_related_products_args','wc_remove_related_products', 10); 

add_filter( 'woocommerce_product_tabs', 'sb_woo_remove_reviews_tab', 98);
function sb_woo_remove_reviews_tab($tabs) {

 unset($tabs['reviews']);
 unset( $tabs['additional_information'] );  	// Remove the additional information tab

 return $tabs;
}

// Override theme default specification for product # per row
function loop_columns() {
return 4; // 5 products per row
}
add_filter('loop_shop_columns', 'loop_columns', 999);

function woo_wc_get_sidebar() {
		global $woo_options, $post;
 
		// Display the sidebar if full width option is disabled on archives
		if ( ! is_product() ) {
			if ( isset( $woo_options['woocommerce_archives_fullwidth'] ) && 'false' == $woo_options['woocommerce_archives_fullwidth'] ) {
				get_sidebar('shop');
			}
		} else {
			$single_layout = get_post_meta( $post->ID, '_layout', true );
			if ( $woo_options[ 'woocommerce_products_fullwidth' ] == 'false' ) {
				get_sidebar('shop');
			}
		}
 
	} // End woo_wc_get_sidebar()

//makes it so that I can actually adjust the sizing on the catalog single product pages.
remove_action( 'init', 'woo_woocommerce_image_dimensions', 1 );	


/**
 * Add the field to the checkout
 **/
add_action('woocommerce_after_order_notes', 'my_custom_checkout_field');

function my_custom_checkout_field( $checkout ) {
	
	echo '<div id="my_custom_checkout_field">';
				
	/**
	 * Output the field. This is for 1.4.
	 **/
	woocommerce_form_field( 'marketing_source', array( 
		'type' 			=> 'text', 
		'class' 		=> array('notes'), 
		'label' 		=> __('How did you hear about Rythmatix?'), 
		'placeholder' 	=> __('Examples: Google search, Facebook, a friend, in-person, etc.'),
		), $checkout->get_value( 'marketing_source' ));
	
	echo '</div>';
}

/**
* Process the checkout
**/
add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

/*  makes the new field a required field
function my_custom_checkout_field_process() {
global $woocommerce;

// Check if set, if its not set add an error.
if (!$_POST['marketing_source'])
$woocommerce->add_error( __('Please tell us how you came to our humble website to help us understand our customers better.') );
}
*/

/**
* Update the order meta with field value
**/
add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');

function my_custom_checkout_field_update_order_meta( $order_id ) {
if ($_POST['marketing_source']) update_post_meta( $order_id, 'Marketing Source', esc_attr($_POST['marketing_source']));
}


/* Register Subheader widget area */
	register_sidebar( array(
		'name' => __( 'SubHeader Widget', 'skeleton' ),
		'id' => 'subheader-widget',
		'description' => __( 'used for searches or connect area.', 'skeleton' ),
		'before_widget' => '<div id="%1$s" class="subheader right">',
		'after_widget' => '</div>',
		'before_title' => '<h1>',
		'after_title' => '</a></h1><div class="box">',
	) );	


/* Include Google Fonts */
    function load_fonts() {
            wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Alef:400,700|PT+Sans:r,b,i,bi|Play:r,b');
            wp_enqueue_style( 'googleFonts');
        }
    
    add_action('wp_print_styles', 'load_fonts');

function google_webmaster() {
    echo '<meta name="google-site-verification" content="ygxXsi9Kd3FTG-H6VDVykAFoJhrLhoHl8SDnzg7mUhQ" />';
}
// Add hook for front-end <head></head>
add_action('wp_head', 'google_webmaster');


//This code will allow you to add a custom URL field to posts that can be used to link the slide title to a custom internal or external URl.
function woo_metaboxes_add($woo_metaboxes) {
 
	$woo_metaboxes[] = array( 
	"name" => "url",
	"label" => "Custom Slider URl",
	"type" => "text",
	"desc" => "Enter a custom URL for the slide title here"
	);
 
return $woo_metaboxes;
 }

/* if I wanted the woocommerce pages to say something different

add_filter( 'woocommerce_page_title', 'custom_woocommerce_page_title');
function custom_woocommerce_page_title( $page_title ) {
  if( $page_title == 'Shop' ) {
    return "WooCommerce Demo Products";
  }
}
*/

?>