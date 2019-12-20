<?php

////////////////////////////////////////////////////////////////////
// Theme Information
////////////////////////////////////////////////////////////////////

$themename = "Vander Web Child";
$shortname = "vanderweb-child";
$version = '1.0.0';

function vanderwebchild_responsivcss (){
    wp_deregister_style( 'stylesheet', get_stylesheet_directory_uri().'/style.css', array() );    
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/style.css', array() );
    wp_enqueue_style( 'vanderwebchild_responsiv', get_stylesheet_directory_uri() . '/style-responsive.css' );
    wp_enqueue_script( 'vanderwebchild_scripts', get_stylesheet_directory_uri().  '/custom-scripts.js', array('jquery') );
    //wp_enqueue_style( 'leafletcss', '//unpkg.com/leaflet@1.6.0/dist/leaflet.css', array(), null );
    //wp_enqueue_script( 'leafletjs', '//unpkg.com/leaflet@1.6.0/dist/leaflet.js', array(), null ); 
    //wp_enqueue_style( 'google-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:300,400,700', array() , null);
}
add_action( 'wp_enqueue_scripts', 'vanderwebchild_responsivcss', 999 );

////////////////////////////////////////////////////////////////////
// Translation
////////////////////////////////////////////////////////////////////
function custom_translate_text($translated) {
	$translated = str_ireplace('Old string', 'New string', $translated);
	return $translated;
}
//add_filter('gettext', 'custom_translate_text');
//add_filter('ngettext', 'custom_translate_text');

////////////////////////////////////////////////////////////////////
// Hook overwrites
////////////////////////////////////////////////////////////////////
function child_remove_parent_function() {
	
} 
add_action( 'wp_loaded', 'child_remove_parent_function' );
function add_action_filterfunction() {
    
}
//add_action( 'template_redirect', 'add_action_filterfunction' );

////////////////////////////////////////////////////////////////////
// WooCommerce
////////////////////////////////////////////////////////////////////
function vanderwebchild_woocommerce_support() {
	add_theme_support( 'woocommerce' );
 require_once(get_stylesheet_directory().'/custom-woocommerce.php');
}
//add_action( 'after_setup_theme', 'vanderwebchild_woocommerce_support' );

////////////////////////////////////////////////////////////////////
// Functions
////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////
// Hooks
////////////////////////////////////////////////////////////////////
function custom_woo_postheader() {
	if ( is_product()) {
		echo '<div class="product-header-title"><h1 class="product-title">';
		echo the_title();
		echo '</h1></div>';
	}
}
//add_action( 'vanderweb_single_postcontent_above' , 'vanderweb_postheader', 5 );
function breadcrumbs_aboveloop() {
 if( !is_front_page() ){
  echo '<div class="aboveloop-meta row">';
   if ( function_exists('yoast_breadcrumb') ) {
       yoast_breadcrumb( '<div class="breadcrumbs col"><p id="breadcrumbs">','</p></div>' );
   }
  echo '</div>';
 }
}
//add_action( 'vanderweb_above_loop' , 'breadcrumbs_aboveloop', 2 );
?>