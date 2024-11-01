<?php
/*
Plugin Name: WDU Inquiry Form
Plugin URI: http://plugins.akramul.com/plugin/woocommerce-product-inquiry-form/
Description: This plugin will replace Add to Cart button and place a new button with popup inquiry form.
Version: 1.0.0
Author: Akramul Hasan
Author URI: https://www.akramul.com
License: GPLv2 or later
Text Domain: wdu-product-inquiry
Domain Path: /languages/
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*Text domain loading*/

function wdu_load_textdomain() {
    load_plugin_textdomain( 'wdu-product-inquiry', false, dirname( __FILE__ ) . "/languages" );
}
add_action( "plugins_loaded", 'wdu_load_textdomain' );

function wdu_inquiryform_init(){

//remove add to cart from single page
remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);

//remove add to cart from shop page
remove_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart',10);
}
add_action( "plugins_loaded", 'wdu_inquiryform_init' );


/********************************
 ***Including all required files***
 ********************************/

//Check Woocommerce is on or off
require_once(plugin_dir_path(__FILE__).'wdu-check-woocommerce.php');

//Include Bootstrap if it allowed from setting page
$bootswitch = get_option('wdu_inquiryform_boot_switch');

if($bootswitch != 1){
    require_once(plugin_dir_path(__FILE__).'wdu-scripts.php');
}

//Include button and modal and their connection
require_once(plugin_dir_path(__FILE__).'wdu-button-modal-config.php');

//Include popup form
require_once(plugin_dir_path(__FILE__).'wdu-form.php');

//Include Plugin Settings page
require_once(plugin_dir_path(__FILE__).'wdu-settings.php');