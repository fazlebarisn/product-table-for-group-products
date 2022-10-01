<?php

namespace Group\Ptable\Admin;

class AdminNotice{
    public function __construct(){

        if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            add_action( 'admin_notices', [ $this, 'woocommercePluginMissing' ] );
        } 

        if ( !in_array( 'woo-product-table/woo-product-table.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            add_action( 'admin_notices', [ $this, 'productTablePluginMissing' ] );
        } 
    }

    public function woocommercePluginMissing(){
        $class = 'notice notice-error';
        $message = __( "Product Table For Group Products Requires WooCommerce to be Activated", "product-table-for-group-products" );
     
        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
    }

    public function productTablePluginMissing(){
        $class = 'notice notice-error';
        $message = __( "Product Table For Group Products Plugin Requires Woo Product Table Plugin to be Activated", "product-table-for-group-products" );
     
        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
    }
}
