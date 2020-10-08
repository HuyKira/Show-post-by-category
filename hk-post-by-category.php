<?php
/*
Plugin Name: Show post by category
Plugin URI: https://huykira.net
Description: Plugin widget show post by category
Author: Huy Kira
Version: 1.0
Author URI: http://www.huykira.net
*/
if ( !function_exists( 'add_action' ) ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}

define('HK_POSTCAT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('HK_POSTCAT_PLUGIN_RIR', plugin_dir_path(__FILE__));

// add css
wp_enqueue_style( 'postcat', HK_POSTCAT_PLUGIN_URL . 'css/postcat.css',false, '1.0','all');

require_once(HK_POSTCAT_PLUGIN_RIR . 'include/widget.php');