<?php

namespace Group\Ptable\Frontend;

class DisplayTable{

    public $config;
    public $table_id;
    public $table_on_of;
    public $table_position;
    
    function __construct()
    {
        $this->config = get_option( 'wpt_configure_options' ); 

        $this->table_on_of = isset( $this->config['group_table_on_of'] ) ? $this->config['group_table_on_of'] : false;
        $this->table_id = isset( $this->config['group_table_id'] ) ? $this->config['group_table_id'] : false;

        $this->table_position = isset( $this->config['group_table_position'] ) ? $this->config['group_table_position'] : false;

        add_filter('wpto_table_query_args' , [$this, 'tableQuery'] );
        add_filter('wpt_query_args' , [$this, 'tableQuery'] );
        
        if( $this->table_position  == 'woocommerce_single_product_summary' ){
            add_action('woocommerce_single_product_summary', [ $this, 'displayTable' ] );
        }elseif( $this->table_position  == 'woocommerce_product_meta_start'){
            add_action('woocommerce_product_meta_start', [ $this, 'displayTable' ] );
        }elseif( $this->table_position  == 'woocommerce_product_meta_end'){
            add_action('woocommerce_product_meta_end', [ $this, 'displayTable' ] );
        }elseif( $this->table_position  == 'woocommerce_after_single_product_summary'){
            add_action('woocommerce_after_single_product_summary', [ $this, 'displayTable'] );
        }elseif( $this->table_position  == 'woocommerce_product_after_tabs'){
            add_action('woocommerce_product_after_tabs', [ $this, 'displayTable'] );
        }

        /**
         * if group table option is on then hide the add to cart button
         * @since 1.0.4
         * @author Fazle Bari
         */
        if( ! empty( $this->config['group_table_id']) && false == $this->table_on_of ){
            add_action('wp', [$this, 'remove_grouped_add_to_cart']);
        }
        
    }

    /**
     * This function will pull the table id from database
     *  That's id is already save in database by the main plugin
     * @return $table_id
     * @author Fazle Bari
     */

    public function getTableId(){

        if( 'on' == $this->table_on_of ) return;

        $this->table_id= apply_filters( 'wpto_default_group_table_id', $this->table_id);
        $this->table_id = is_numeric( $this->table_id ) ? (int) $this->table_id : false;
        
        $id = get_queried_object_id();
        $taxo_table_id = get_term_meta( $id, 'table_id', true );
        
        if( ! empty( $taxo_table_id ) && is_numeric( $taxo_table_id ) ){
            $this->table_id = $taxo_table_id;
        }
        
        return $this->table_id;
    }

    /**
     * Here we are changining the default argument of the table
     * If the table is displying is group product page on then we will chenge the argument
     * @param [array] $args
     * @return $args
     * @author Fazle Bari
     */
    public function tableQuery( $args ){

        if ( is_product() ){
            global $product;

            $grouped = $product->is_type( 'grouped' );
            if( !$grouped ) return;
    
            $product_id = $product->get_id();
            $product    = wc_get_product( $product_id );
            $children   = $product->get_children();
            $args['post__in'] = $children;
            return $args;
        }
        // if not group product page then return the default argument
        return $args;
    }

    /**
     * finially display the table only if it is a group product page
     *
     * @return void
     * @author Fazle Bari
     */
    public function displayTable(){

        if ( !is_product() ) return;

        global $product;
        $grouped = $product->is_type( 'grouped' );

        if( !$grouped ) return;

        $this->table_id = $this->getTableId();
        
        if( $this->table_id ){  
            echo do_shortcode( "[Product_Table id='{$this->table_id}']" );
        }

    }

    /**
     * if group table option is on then hide the add to cart button
     * @since 1.0.2
     * @author Fazle Bari
     */
    public function remove_grouped_add_to_cart(){
        if ( is_product() && ! is_ajax()  && !$this->table_on_of ) {
            remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
          }
    }
}
