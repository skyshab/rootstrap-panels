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
use function Rootstrap\vendor_path;

/**
 * RoostrapPanels class
 *
 * @since  1.0.0
 * @access public
 */
class Manager implements Bootable {

    /**
     * Stores Resources Path
     *
     * @since 1.0.0
     * @var array
     */
    private $resources;

    /**
     * Load resources.
     *
     * @since 1.0.0
     * @return object
     */
    public function boot() {
        // Store resources path
        $this->resources = vendor_path() . '/skyshab/rootstrap-panels/dist';
        // Add custom control
        add_action( 'rootstrap/customize-register', [ $this, 'customControl' ] );
        // Register tabs
        add_action( 'rootstrap/customize-register/custom', [ $this, 'registerPanels' ] );
        // Load customize control resources
        add_action( 'customize_controls_enqueue_scripts', [ $this, 'customizeResources' ] );
    }

    /**
     * Load file that contains our customizer control for sequences.
     *
     * @since 1.0.0
     * @return void
     */
    public function customControl($manager) {
        require_once 'controls/class-rootstrap-custom-panel.php';
    }

    /**
     * Register the custom panel
     *
     * @since 1.0.0
     * @return void
     */
    public function registerPanels($manager) {
        $manager->register_panel_type( 'Rootstrap_Custom_Panel' );
    }

    /**
     * Enqueue scripts and styles.
     *
     * @since 1.0.0
     */
    public function customizeResources() {
        wp_enqueue_script( 'rootstrap-custom-panels', $this->resources . '/js/custom-panels.js', ['customize-controls', 'jquery'], null, true );
        wp_enqueue_style( 'rootstrap-customize-customize-controls', $this->resources . '/css/customize-controls.css' );
    }
}
