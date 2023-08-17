<?php

/**
 * Plugin Name: Product Table For Group Products
 * Plugin URI: https://github.com/fazlebarisn/product-table-for-group-products
 * Description: An addon plugin of product table for WooCommerce. You can display a product table on woocommerce group product. 
 * Version: 1.0.5
 * Author: Fazle Bari
 * Author URI: https://www.chitabd.com/
 * Requires PHP:            7.2
 * Tested up to:            6.3
 * WC requires at least:    3.0.0
 * WC tested up to:         8.8.2
 * Licence:                 GPL Or leater
 * Text Domain:             product-table-for-group-products
 * Domain Path:             /languages/
 * @package grouptable
 */

defined('ABSPATH') or die('Nice Try!');

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

/**
 * Only for developer
 * @author Fazle Bari <fazlebarisn@gmail.com>
 */
if( ! function_exists('dd') ){
	function dd( ...$vals){
		if( ! empty($vals) && is_array($vals) ){
			foreach($vals as $val ){
				echo "<pre>";
				var_dump($val);
				echo "</pre>";
			}
		}
	}
}

/**
 * The main class
 */

final class GroupProductTable
{

    /**
     * defien plugin version
     */
    const version = "1.0.5";

    /**
     * class constructor
     */
    private function __construct()
    {
        $this->defineConstants();

        register_activation_hook(__FILE__, [$this, 'activate']);

        add_action('plugins_loaded', [$this, 'initPlugin']);
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
