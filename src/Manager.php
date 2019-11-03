<?php
/**
 * Rootstrap Panels
 *
 * This class handles loading the customize register actions for the extension.
 *
 * @package   Rootstrap\Customize
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2019, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Panels;

use Hybrid\Contracts\Bootable;
use WP_Customize_Manager;
use function Rootstrap\vendor_path;

/**
 * RoostrapPanels class
 *
 * @since  1.0.0
 * @access public
 */
class Manager implements Bootable {

    /**
     * Load resources.
     *
     * @since 1.0.0
     * @return object
     */
    public function boot() {

        // Add custom control
        add_action( 'rootstrap/customize-register',         [ $this, 'customizeRegister' ] );

        // Load customize control resources
        add_action( 'customize_controls_enqueue_scripts',   [ $this, 'customizeResources' ] );
    }

    /**
     * Customize register functionality
     *
     * @since 1.0.0
     * @return void
     */
    public function customizeRegister( WP_Customize_Manager $manager) {

        // Load custom panel file
        require_once 'controls/class-rootstrap-custom-panel.php';

        // Register custom panel
        $manager->register_panel_type( 'Rootstrap_Custom_Panel' );
    }

    /**
     * Enqueue scripts and styles.
     *
     * @since 1.0.0
     */
    public function customizeResources() {
        $resources = vendor_path() . '/skyshab/rootstrap-panels/dist';
        wp_enqueue_script( 'rootstrap-panels', $resources . '/js/customize-controls.js', ['customize-controls', 'jquery'], null, true );
        wp_enqueue_style( 'rootstrap-panels', $resources . '/css/customize-controls.css' );
    }
}
