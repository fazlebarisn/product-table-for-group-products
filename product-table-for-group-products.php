<?php
/**
* Plugin Name: Product table for group products
* Plugin URI: https://github.com/fazlebarisn/product-table-for-group-products
* Description: Learn WooCommerce hooks
* Version: 1.0.0
* Author: Fazle Bari
* Author URI: https://www.chitabd.com/
* Requires PHP: 7.2
* Tested up to:         6.0.5
* WC requires at least: 3.0.0
* WC tested up to: 	 6.8.2
* Licence: GPL Or leater
* Text Domain: product-table-for-group-products
* Domain Path: /languages/
* @package grouptable
*/

defined('ABSPATH') or die('Nice Try!');

if( file_exists( dirname(__FILE__) . '/vendor/autoload.php') ){
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}


/**
 * The main class
 */

final class GroupProductTable{

    /**
     * defien plugin version
     */
    const version = "1.0.0";

    /**
     * class constructor
     */
    private function __construct()
    {
        $this->defineConstants();

        register_activation_hook( __FILE__ , [ $this , 'activate'] );

        add_action( 'plugins_loaded' , [ $this , 'initPlugin'] );
    }

    /**
     * initilize a singileton 
     *
     * @return \GroupProductTable class
     */
     public static function init(){

         static $instance = false;

         if( !$instance ){
             $instance = new self();
         }

         return $instance;
     }

     /**
      * Define plugin constants
      *
      * @return constants
      */
     public function defineConstants(){

         define( 'GROUP_PTABLE_VERSION' , self::version );
         define( 'GROUP_PTABLE_FILE' , __FILE__ );
         define( 'GROUP_PTABLE_PATH' , __DIR__ );
         define( 'GROUP_PTABLE_URL' , plugins_url( '' , GROUP_PTABLE_FILE ) );
         define( 'GROUP_PTABLE_ASSETS' , GROUP_PTABLE_URL . '/assets' );
         define( 'GROUP_PTABLE_BASENAME' , plugin_basename( __FILE__ ) );

     }

     /**
      * Initialize the plugin
      *
      * @return void
      */
     public function initPlugin(){

        if( is_admin() ){
            new \Group\Ptable\Admin();
        }else{
            new \Group\Ptable\Frontend();
        }
        
     }

     /**
      * do stuff when plugin install
      *
      * @return void
      */
     public function activate(){

        // when first install
        $installed = get_option( 'group_ptable_installed' );
        if( !$installed ){
            update_option( 'group_ptable_installed' , time() );
        }

        // what is the version number when first install
        update_option( 'group_ptable_version' , GROUP_PTABLE_VERSION ); 

     }

 }

 /**
  * Initializes the main plugin
  *
  * @return \GroupProductTable class
  */
 function roupProductTable(){
     return GroupProductTable::init();
 }

 // kick-off the plugin
 roupProductTable();

// add_action('woocommerce_before_add_to_cart_form', 'woocommerce_before_add_to_cart_form_callback');

// function woocommerce_before_add_to_cart_form_callback(){
//     global $product;

//     // $product_id = 8; // ID of parent product

//     // wpt_query_args
//     // wpt_load
//     $grouped       = $product->is_type( 'grouped' );

//     add_filter('wpt_query_args' , 'wpt_query_args_callback');

//     function wpt_query_args_callback($args){
//         // echo "<pre>";
//         // var_dump($args);
//         // echo "</pre>";
//         global $product;
//         $product_id = $product->get_id();
//         $product    = wc_get_product( $product_id );
//         $children   = $product->get_children();
        
//         // var_dump($children);

//         $args['post__in'] = $children;
//         return $args;
//     }

//     if ($grouped){
//         echo do_shortcode("[Product_Table id='60' name='one']");
//     }
// }

