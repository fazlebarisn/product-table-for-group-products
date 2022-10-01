<?php

namespace Group\Ptable\Admin;

class SelectTable{

    function __construct()
    {
        add_action('wpto_admin_configuration_form_top', [$this, 'selectTable'], 10, 2 );
    }

    /**
     * Here we loop though all table and display as a dropdown menu
     * Also will add show hide option
     *
     * @param [array] $settings
     * @param [array] $current_config_value
     * @return void
     */
    public function selectTable( $settings,$current_config_value ){
        if( !isset( $settings['page'] ) || isset( $settings['page'] ) && $settings['page'] != 'configuration_page' ){
            return;
        }
        ?>
            <table class="ultraaddons-table">
                <tr id="wpt_group_table_on">
                    <th>
                        <label class="wpt_label wpt_group_table_on_off" for="wpt_group_table_on_off"><?php esc_html_e( 'Group Product Table', 'product-table-for-group-products' );?></label>
                    </th>
                    <td>
                        <label class="switch">
                            <input name="data[group_table_on_of]" type="checkbox" id="wpt_group_table_on_off" <?php echo esc_html(isset( $current_config_value['group_table_on_of'] )) ? 'checked="checked"' : ''; ?>>
                            <div class="slider round"><!--ADDED HTML -->
                                <span class="on">Hide</span><span class="off">Show</span><!--END-->
                            </div>
                        </label>
                        <p><?php echo esc_html( 'Turn on or off table on group product', 'product-table-for-group-products' ); ?></p>

                    </td>
                </tr>
                <tr id="wpt_group_table">
                    <th>
                        <label class="wpt_label wpt_group_table " for="wpt_group_table"><?php esc_html_e( 'Select Group Table', 'product-table-for-group-products' );?></label>
                    </th>
                    <td>
                        <?php 
                        $product_tables = get_posts( array(
                            'post_type' => 'wpt_product_table',
                            'numberposts' => -1,
                            ) );
                            if(!empty($product_tables)){
                                ?>
                                <select name="data[group_table_id]" class="wpt_fullwidth ua_input wpt_table_on_archive">
                                    <option value="">Select a Table</option>
                                    <?php 
                                    
                                        foreach ($product_tables as $table){
                                            $selected = isset( $current_config_value['group_table_id'] ) && $current_config_value['group_table_id'] == $table->ID ? 'selected' : '';
                                            echo '<option value="'. $table->ID .'" ' . $selected . '>' . $table->post_title . '</option>'; 
                                        }
                                    ?>
                                </select>
                                <?php
                        } else { 
                            echo esc_html( 'Seems you have not created any table yet. Create a table first!', 'product-table-for-group-products' );
                        } ?>
                        <br>
                        <p><?php echo esc_html__( 'Select a Table for group products', 'product-table-for-group-products' ); ?></p>
                    </td>
                </tr>
            </table>
            
        <?php
    }
}