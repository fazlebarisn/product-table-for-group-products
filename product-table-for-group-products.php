<?php

/**
 * Plugin Name: Product Table For Group Products
 * Requires Plugins: woocommerce, woo-product-table
 * Plugin URI: https://github.com/fazlebarisn/product-table-for-group-products
 * Description: An addon plugin of product table for WooCommerce. You can display a product table on woocommerce group product. 
 * Version: 1.2.2
 * Author: Fazle Bari
 * Author URI: https://www.chitabd.com/
 * Requires PHP:            7.3
 * Tested up to:            6.8
 * WC requires at least:    5.0
 * WC tested up to:         10.1
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:             product-table-for-group-products
 * @package grouptable
 */

defined('ABSPATH') or die('Nice Try!');

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

if( file_exists(dirname( __FILE__ ). '/functions.php')){
	require_once dirname( __FILE__ ). '/functions.php';
};

/**
 * The main class
 */

final class GroupProductTable
{

    /**
     * defien plugin version
     */
    const version = "1.2.2";

    /**
     * class constructor
     */
    private function __construct()
    {
        $this->defineConstants();

        register_activation_hook(__FILE__, [$this, 'activate']);
        add_action( 'before_woocommerce_init', [$this, 'group_product_table_hpos'] );
        add_action('plugins_loaded', [$this, 'initPlugin']);
    }

    /**
     * Declare compatibility with custom order tables for WooCommerce.
     * Support WooCommerce High-performance order storage
     * @since 1.1.0
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function group_product_table_hpos(){
		if (class_exists('\Automattic\WooCommerce\Utilities\FeaturesUtil')) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
		}
	}

    /**
     * initilize a singileton 
     *
     * @return \GroupProductTable class
     */
    public static function init()
    {

        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define plugin constants
     *
     * @return constants
     */
    public function defineConstants()
    {

        define('GROUP_PTABLE_VERSION', self::version);
        define('GROUP_PTABLE_FILE', __FILE__);
        define('GROUP_PTABLE_PATH', __DIR__);
        define('GROUP_PTABLE_URL', plugins_url('', GROUP_PTABLE_FILE));
        define('GROUP_PTABLE_ASSETS', GROUP_PTABLE_URL . '/assets');
        define('GROUP_PTABLE_BASENAME', plugin_basename(__FILE__));
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function initPlugin()
    {

        if (is_admin()) {
            new \Group\Ptable\Admin();
        } else {
            new \Group\Ptable\Frontend();
        }
    }

    /**
     * do stuff when plugin install
     *
     * @return void
     */
    public function activate()
    {

        // when first install
        $installed = get_option('group_ptable_installed');
        if (!$installed) {
            update_option('group_ptable_installed', time());
        }

        // what is the version number when first install
        update_option('group_ptable_version', GROUP_PTABLE_VERSION);
    }
}

/**
 * Initializes the main plugin
 *
 * @return \GroupProductTable class
 */
function fbsGroupProductTable()
{
    return GroupProductTable::init();
}

// kick-off the plugin
fbsGroupProductTable();
