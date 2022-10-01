<?php

namespace Group\Ptable\Frontend;

class DisplayTable{

    function __construct()
    {
        add_filter('wpt_query_args' , [$this, 'tableQuery'] );
        add_action('woocommerce_before_add_to_cart_form', [$this, 'displayTable'] );
    }

    /**
     * This function will pull the table id from database
     *  That's id is already save in database by the main plugin
     * @return $table_id
     */
    public function getTableId(){

        $config = get_option( 'wpt_configure_options' ); 

        $table_on_of = isset( $config['group_table_on_of'] ) ? $config['group_table_on_of'] : false;

        if('on' == $table_on_of) return;
        
		$table_id = isset( $config['group_table_id'] ) ? $config['group_table_id'] : false;
        $table_id = apply_filters( 'wpto_default_group_table_id', $table_id );
        $table_id = is_numeric( $table_id ) ? (int) $table_id : false;
        
        $id = get_queried_object_id();
        $taxo_table_id = get_term_meta( $id, 'table_id', true );
        
        if( ! empty( $taxo_table_id ) && is_numeric( $taxo_table_id ) ){
            $table_id = $taxo_table_id;
        }
        
        return $table_id;
    }

    /**
     * Here we are changining the default argument of the table
     * If the table is displying is group product page on then we will chenge the argument
     * @param [array] $args
     * @return $args
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
     */
    public function displayTable(){

        if ( !is_product() ) return;

        global $product;
        $grouped = $product->is_type( 'grouped' );

        if( !$grouped ) return;

        $table_id = $this->getTableId();
        
        if( $table_id ){
            echo do_shortcode( "[Product_Table id='{$table_id}']" );
        }

    }
}