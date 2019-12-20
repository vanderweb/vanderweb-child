<?php
get_header();
$contentype = 'shop';
if(woocommerce_product_subcategories()){
    $contentype = 'subcategory';
}
elseif(is_product_category()){
    $contentype = 'products';
}
elseif(is_product()){
    $contentype = 'product';
}
echo '<div class="vanderweb-woocommerce vanderweb-woocommerce-'.$contentype.'">';
woocommerce_content();
echo '</div>';
get_footer();
?>