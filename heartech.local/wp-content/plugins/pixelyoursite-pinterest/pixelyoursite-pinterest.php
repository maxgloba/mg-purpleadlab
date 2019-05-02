<?php

/**
 * Plugin Name: PixelYourSite Pinterest
 * Plugin URI: http://www.pixelyoursite.com/
 * Description: Manage your Pinterest Tag: automatically add it to any page, fire events, integrate with WooCommerce or Easy Digital Downloads.
 * Version: 2.0.5
 * Author: PixelYourSite
 * Author URI: http://www.pixelyoursite.com
 * License URI: http://www.pixelyoursite.com/pixel-your-site-pro-license
 *
 * Requires at least: 4.4
 * Tested up to: 5.1.0
 *
 * WC requires at least: 2.6.0
 * WC tested up to: 3.5.5
 *
 * Text Domain: pys
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use PixelYourSite\Pinterest;

define( 'PYS_PINTEREST_VERSION', '2.0.5' );
define( 'PYS_PINTEREST_PRO_MIN_VERSION', '7.0.6' );
define( 'PYS_PINTEREST_FREE_MIN_VERSION', '7.0.0' );
define( 'PYS_PINTEREST_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'PYS_PINTEREST_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'PYS_PINTEREST_PLUGIN_FILE', __FILE__ );

require_once 'modules/pinterest/functions-common.php';
require_once 'modules/pinterest/functions-admin.php';
require_once 'modules/pinterest/functions-woo.php';
require_once 'modules/pinterest/functions-edd.php';
require_once 'modules/pinterest/functions-migrate.php';

register_activation_hook( __FILE__, 'pysPinterestActivation' );
function pysPinterestActivation() {
    if ( Pinterest\isPysProActive() ) {
        if ( ! Pinterest\pysProVersionIsCompatible() ) {
            wp_die( 'PixelYourSite Pinterest requires PixelYourSite PRO version ' . PYS_PINTEREST_PRO_MIN_VERSION . ' or newer.',
                'Plugin Activation',
                array(
                    'back_link' => true,
                ) );
        }
    } elseif ( Pinterest\isPysFreeActive() ) {
        if ( ! Pinterest\pysFreeVersionIsCompatible() ) {
            wp_die( 'PixelYourSite Pinterest requires PixelYourSite Free version ' . PYS_PINTEREST_FREE_MIN_VERSION . ' or newer.',
                'Plugin Activation',
                array(
                    'back_link' => true,
                ) );
        }
    } else {
        wp_die( 'PixelYourSite Pinterest requires PixelYourSite PRO or Free activated.',
            'Plugin Activation',
            array(
                'back_link' => true,
            ) );
    }
}

/**
 * Initialize Pinterest plugin instance.
 * Should be loaded before PYS core ( init, 9 ) to prevent dummy Pinterest plugin usage
 */
if ( Pinterest\isPysProActive() ) {
    if ( Pinterest\pysProVersionIsCompatible() ) {
        add_action( 'init', function() {
            require_once 'modules/pinterest/pinterest.php';
        }, 8 );
    } else {
        add_action( 'admin_notices', 'PixelYourSite\Pinterest\adminNoticePysProOutdated' );
    }
} elseif ( Pinterest\isPysFreeActive() ) {
    if ( Pinterest\pysFreeVersionIsCompatible() ) {
        add_action( 'init', function() {
            require_once 'modules/pinterest/pinterest.php';
        }, 8 );
    } else {
        add_action( 'admin_notices', 'PixelYourSite\Pinterest\adminNoticePysFreeOutdated' );
    }
} else {
    add_action( 'admin_notices', 'PixelYourSite\Pinterest\adminNoticePysCoreNotActive' );
}