<?php
/**
* Plugin Name: AAA Learn WooCommerce hooks
* Plugin URI: https://github.com/fazlebarisn/woo-product-faq
* Description: Learn WooCommerce hooks
* Version: 1.0.0
* Author: Fazle Bari
* Author URI: https://www.chitabd.com/
* Requires PHP: 7.2
* Tested up to:         6.0.5
* WC requires at least: 3.0.0
* WC tested up to: 	 6.8.2
* Licence: GPL Or leater
* Text Domain: fbshooks
* Domain Path: /languages/
* @package fbshooks
*/

add_action('woocommerce_before_add_to_cart_form', 'woocommerce_before_add_to_cart_form_callback');

function woocommerce_before_add_to_cart_form_callback(){
    global $product;

    // $product_id = 8; // ID of parent product

    // wpt_query_args
    // wpt_load
    $grouped       = $product->is_type( 'grouped' );

    add_filter('wpt_query_args' , 'wpt_query_args_callback');

    function wpt_query_args_callback($args){
        // echo "<pre>";
        // var_dump($args);
        // echo "</pre>";
        global $product;
        $product_id = $product->get_id();
        $product    = wc_get_product( $product_id );
        $children   = $product->get_children();
        
        // var_dump($children);

        $args['post__in'] = $children;
        return $args;
    }

    if ($grouped){
        echo do_shortcode("[Product_Table id='60' name='one']");
    }
}

