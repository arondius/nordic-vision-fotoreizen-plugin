<?php
/**
 * Plugin Name: Fotoreizen.net Custom Plugin
 * Description: Custom plugin for fotoreizen.net
 * Version: 0.1
 * Author: Arend Hosman
 * Author URI: http://arendhosman.nl
 */

namespace Webbb\FotoreizenPlugin;

if ( ! defined( 'ABSPATH' ) ) {
    die;
}

require_once('inc/register_custom_post_types.php');
require_once('inc/register_custom_fields.php');
require_once('inc/base.class.php');
require_once('inc/widget.class.php');
require_once('inc/table.class.php');
require_once('inc/form.class.php');
