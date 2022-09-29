<?php

namespace Group\Ptable\Admin;

class SelectTable{

    function __construct()
    {
        add_action('wpto_admin_configuration_form_top', [$this, 'selectTable'], 10, 2 );
    }

    public function selectTable( $settings,$current_config_value ){
        if( !isset( $settings['page'] ) || isset( $settings['page'] ) && $settings['page'] != 'configuration_page' ){
            return;
        }
        ?>
            <table class="ultraaddons-table">
                <tr id="wpt_group_table_on">
                    <th>
                        <label class="wpt_label wpt_group_table_on_off" for="wpt_group_table_on_off"><?php esc_html_e( 'Group Product Table', 'wpt_pro' );?></label>
                    </th>
                    <td>
                        <label class="switch">
                            <input name="data[group_table_on_of]" type="checkbox" id="wpt_group_table_on_off" <?php echo isset( $current_config_value['group_table_on_of'] ) ? 'checked="checked"' : ''; ?>>
                            <div class="slider round"><!--ADDED HTML -->
                                <span class="on">Hide</span><span class="off">Show</span><!--END-->
                            </div>
                        </label>
                        <p><?php echo esc_html( 'Turn on or off table on group product', 'wpt_pro' ); ?></p>

                    </td>
                </tr>
                <tr id="wpt_group_table">
                    <th>
                        <label class="wpt_label wpt_group_table " for="wpt_group_table"><?php esc_html_e( 'Select Group Table', 'wpt_pro' );?></label>
                    </th>
                    <td>
                        <select name="data[wpt_group_table]" class="wpt_fullwidth ua_input wpt_group_table">
                            <option value="none">None</option>
                            <?php 
                                $footer_cart_templates = [1,2,3,4,5,6,7,7,9,10,11,12,13,14,15,16,17,18,19,20,21,22];
                                foreach($footer_cart_templates as $template){
                                    $selected = isset( $current_config_value['wpt_group_table'] ) && $current_config_value['wpt_group_table'] == $template? 'selected' : '';
                                    echo '<option value="'. $template .'" ' . $selected . '>'."Template No " . $template . '</option>'; 
                                } 
                            ?>
                        </select>
                        <br>
                        <p><?php echo esc_html__( 'Select a Table for group products', 'wpt_pro' ); ?></p>
                    </td>
                </tr>
            </table>
            
        <?php
    }
}