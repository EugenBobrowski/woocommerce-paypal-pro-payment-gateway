<?php
/**
 * Plugin Name: WooCommerce PayPal Pro
 * Plugin URI: https://wp-ecommerce.net/paypal-pro-payment-gateway-for-woocommerce
 * Description: Easily adds PayPal Pro payment gateway to the WooCommerce plugin so you can allow customers to checkout via credit card.
 * Version: 1.7
 * Author: wp.insider
 * Author URI: https://wp-ecommerce.net/
 * Requires at least: 3.0
 * License: GPL2 or Later
 */

if (!defined('ABSPATH')) {
    //Exit if accessed directly
    exit;
}

//Slug - wcpprog

if (!class_exists('WC_Paypal_Pro_Gateway_Addon')) {

    class WC_Paypal_Pro_Gateway_Addon {

        var $version = '1.6';
        var $db_version = '1.0';
        var $plugin_url;
        var $plugin_path;

        function __construct() {
            $this->define_constants();
            $this->includes();
            $this->loader_operations();
            //Handle any db install and upgrade task
            add_action('init', array(&$this, 'plugin_init'), 0);
        }

        function define_constants() {
            define('WC_PP_PRO_ADDON_VERSION', $this->version);
            define('WC_PP_PRO_ADDON_URL', $this->plugin_url());
            define('WC_PP_PRO_ADDON_PATH', $this->plugin_path());
        }

        function includes() {
            include_once('woo-paypal-pro-utility-class.php');
        }

        function loader_operations() {
            add_action('plugins_loaded', array(&$this, 'plugins_loaded_handler')); //plugins loaded hook		
        }

        function plugins_loaded_handler() {
            //Runs when plugins_loaded action gets fired
            include_once('woo-paypal-pro-gateway-class.php');
            add_filter('woocommerce_payment_gateways', array(&$this, 'init_paypal_pro_gateway'));
        }

        function do_db_upgrade_check() {
            //NOP
        }

        function plugin_url() {
            if ($this->plugin_url)
                return $this->plugin_url;
            return $this->plugin_url = plugins_url(basename(plugin_dir_path(__FILE__)), basename(__FILE__));
        }

        function plugin_path() {
            if ($this->plugin_path)
                return $this->plugin_path;
            return $this->plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
        }

        function plugin_init() {//Gets run when WP Init is fired
            //wp_enqueue_style('addon.style', WC_Paypal_Pro_Gateway_Addon_URL.'/addon-style.css');
            //add_shortcode('shortcode_name', array(&$this,'shcd_handler'));
            //add_action('action_name_goes_here', array(&$this,'custom_action_function_handler'));
            //add_filter('filter_name_goes_here',array(&$this,'custom_filter_function_handler'),10,2);
        }

        function init_paypal_pro_gateway($methods) {
            array_push($methods, 'WC_PP_PRO_Gateway');
            return $methods;
        }

    }

    //End of plugin class
}//End of class not exists check

$GLOBALS['WC_Paypal_Pro_Gateway_Addon'] = new WC_Paypal_Pro_Gateway_Addon();
