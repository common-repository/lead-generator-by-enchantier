<?php
/*
  Plugin Name: Générateur de leads - EnChantier
  Plugin URI: http://www.enchantier.com/info/wordpress.php
  Description: générer des leads et les vendre directement à EnChantier.
  Version: 1.1.2
  Author: osCSS Team
  Author URI: http://oscss-shop.fr
  License: GPL2
 */

define( 'CD_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'CD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'ENCHANTIER_REGISTER_KEY', "BFB423BB8E83D493A5ECCB2728885");
// library for markdown files
require_once CD_PLUGIN_PATH . 'includes/PHP_Markdown_1.0.1o/markdown.php';

// init enchantier
require_once( CD_PLUGIN_PATH . 'includes/notify.php' );
require_once( CD_PLUGIN_PATH . 'includes/library.php' );
require_once( CD_PLUGIN_PATH . 'includes/get_placeholder.php' );
require_once( CD_PLUGIN_PATH . 'includes/widget.php' );
require_once( CD_PLUGIN_PATH . 'includes/init.php' );
