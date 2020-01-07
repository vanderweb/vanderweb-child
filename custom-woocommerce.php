<?php
////////////////////////////////////////////////////////////////////
// WooCommerce
////////////////////////////////////////////////////////////////////
add_filter('request', function( $vars ) {
	global $wpdb;
	if( ! empty( $vars['pagename'] ) || ! empty( $vars['category_name'] ) || ! empty( $vars['name'] ) || ! empty( $vars['attachment'] ) ) {
		$slug = ! empty( $vars['pagename'] ) ? $vars['pagename'] : ( ! empty( $vars['name'] ) ? $vars['name'] : ( !empty( $vars['category_name'] ) ? $vars['category_name'] : $vars['attachment'] ) );
		$exists = $wpdb->get_var( $wpdb->prepare( "SELECT t.term_id FROM $wpdb->terms t LEFT JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id WHERE tt.taxonomy = 'product_cat' AND t.slug = %s" ,array( $slug )));
		if( $exists ){
			$old_vars = $vars;
			$vars = array('product_cat' => $slug );
			if ( !empty( $old_vars['paged'] ) || !empty( $old_vars['page'] ) )
				$vars['paged'] = ! empty( $old_vars['paged'] ) ? $old_vars['paged'] : $old_vars['page'];
			if ( !empty( $old_vars['orderby'] ) )
	 	        	$vars['orderby'] = $old_vars['orderby'];
      			if ( !empty( $old_vars['order'] ) )
 			        $vars['order'] = $old_vars['order'];	
		}
	}
	return $vars;
});
//add_filter( 'woocommerce_product_subcategories_hide_empty', '__return_false' );

function product_subcategories( $args = array() ) {
    $parentid = get_queried_object_id();
    $args = array(
        'parent' => $parentid,
        'hide_empty' => false
    );
    $terms = get_terms( 'product_cat', $args );
    if ( $terms ) {
        echo '<div class="vanderweb-catloop-row row">';
        foreach ( $terms as $term ) {
            $thumbnail_id = get_woocommerce_term_meta($term->term_id, 'thumbnail_id', true);
            $image = wp_get_attachment_url($thumbnail_id);
            $acf_woocat_icon = get_field('acf_woocat_icon', 'product_cat_'.$term->term_id);
            $icon = wp_get_attachment_url($acf_woocat_icon);
            echo '<a href="'.esc_url( get_term_link( $term ) ).'" class="vanderweb-subcat '.$term->slug.' col-12 col-sm-6">';
                echo "<div class='vanderweb-catloop-bg h-100 container-fluid' style='background-image: url(&#039;".$image."&#039;);'>";
                    echo '<div class="vanderweb-catloop-overlay h-100 row">';
                        echo '<div class="vanderweb-catloop-image col-4">';
                         echo '<img src="'.$icon.'" alt="'.$term->name.'" />';
                        echo '</div>';
                        echo '<div class="vanderweb-catloop-title col-8">';
                            echo '<h3>';
                            echo $term->name;
                            echo '</h3>';
                            if($term->count == 1){
                                $counttext = 'auktion';
                            }else{
                                $counttext = 'auktioner';
                            }
                            echo '<span class="count">'.$term->count.' '.$counttext.'</span>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</a>';
        }
        wp_reset_postdata();
        echo '</div>';
    }
    if (is_shop()): ?>
        <style>
            .products {
                display: none;
            }
        </style>
    <?php endif;
}
add_action( 'woocommerce_before_shop_loop', 'product_subcategories', 50 );

function vander_woo_setup() {
 //add_theme_support( 'wc-product-gallery-zoom' );
 //add_theme_support( 'wc-product-gallery-lightbox' );
 add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'vander_woo_setup' );

function custom_proddetails_start() {
	echo '<div class="prod-details-row row">';
	echo '<div class="prod-details-left col-12 col-sm-6">';
	?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
	 jQuery( ".woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image a" ).addClass( "fancybox" );
	 jQuery( ".woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image a" ).attr('rel','lightframe-<?php echo get_the_id(); ?>');
	});
	</script>
	<?php
}
add_action( 'woocommerce_before_single_product_summary' , 'custom_proddetails_start', 12 );
function custom_proddetails_middle() {
    echo '</div>';
    echo '<div class="prod-details-right col-12 col-sm-6">';
}
add_action( 'woocommerce_before_single_product_summary' , 'custom_proddetails_middle', 50 );
function custom_proddetails_end() {
    echo '</div>';
    echo '</div>';
}
add_action( 'woocommerce_after_single_product_summary' , 'custom_proddetails_end', 2 );
?>