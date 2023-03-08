<?php


add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    /*Chargement du style.css du thème parent Twenty Twenty*/
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/css/theme.css', array(), filemtime(get_stylesheet_directory() . '/css/theme.css'));
}



/*Remplacer le modèle de boucle et afficher les quantités à côté des boutons d'ajout au panier*/
add_filter( 'woocommerce_loop_add_to_cart_link', 'quantity_inputs_for_woocommerce_loop_add_to_cart_link', 10, 2 );
function quantity_inputs_for_woocommerce_loop_add_to_cart_link( $html, $product ) {
	$html = '<form action="' . esc_url( $product->add_to_cart_url() ) . '" class="cart" method="post" enctype="multipart/form-data">';
    $html .= woocommerce_quantity_input( array(), $product, false );
    $html .= '<div class="container-quantity"><div class="more">+</div><div class="less">-</div></div>';
    $html .= '<button type="submit" class="button alt">'.__('ok','woocommerce').'</button>';
    $html .= '</form>';
	return $html;
}
/*Suppression du H2*/
remove_action( 'woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title', 10 );



add_filter( 'wp_nav_menu_items', 'add_extra_item_to_nav_menu', 10, 2 );
function add_extra_item_to_nav_menu( $items, $args ) {
    if (is_user_logged_in() && $args->menu->term_id == 5) {
        $items .= '<li id="menu-admin"><a href="'. get_permalink( get_option('woocommerce_myaccount_page_id') ) .'">'.__('Admin','woocommerce').'</a></li>';
    }
    return $items;
}