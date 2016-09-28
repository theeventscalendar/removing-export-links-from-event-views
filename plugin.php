<?php
/**
 * Plugin Name: The Events Calendar Extension: Removing "Export" Links from Event Views
 * Description: Remove iCal and gCal "export" links from calendar views.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1971
 * License: GPLv2 or later
 */

defined( 'WPINC' ) or die;

class Tribe__Extension__Removing_Export_Links_from_Event_Views {

    /**
     * The semantic version number of this extension; should always match the plugin header.
     */
    const VERSION = '1.0.0';

    /**
     * Each plugin required by this extension
     *
     * @var array Plugins are listed in 'main class' => 'minimum version #' format
     */
    public $plugins_required = array(
        'Tribe__Events__Main' => '4.2'
    );

    /**
     * The constructor; delays initializing the extension until all other plugins are loaded.
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ), 100 );
    }

    /**
     * Extension hooks and initialization; exits if the extension is not authorized by Tribe Common to run.
     */
    public function init() {

        // Exit early if our framework is saying this extension should not run.
        if ( ! function_exists( 'tribe_register_plugin' ) || ! tribe_register_plugin( __FILE__, __CLASS__, self::VERSION, $this->plugins_required ) ) {
            return;
        }

        add_action( 'init', array( $this, 'single_event_links' ) );
        add_action( 'init', array( $this, 'view_links' ) );
    }

    public function single_event_links() {
        remove_action( 'tribe_events_single_event_after_the_content', array( 'Tribe__Events__iCal', 'single_event_links' ) );
    }

    public function view_links() {
        remove_filter( 'tribe_events_after_footer', array( 'Tribe__Events__iCal', 'maybe_add_link' ) );
    }
}

new Tribe__Extension__Removing_Export_Links_from_Event_Views();
