<?php
/**
 * Custom Panels Class.
 *
 * This class handles creation of our custom panel type
 *
 * @package   Rootstrap\Customize
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2019, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* See https://gist.github.com/OriginalEXE/9a6183e09f4cae2f30b006232bb154af */

if ( class_exists( 'WP_Customize_Panel' ) ) {

    class Rootstrap_Custom_Panel extends WP_Customize_Panel {

        public $panel;
        public $type = 'rootstrap_panel';
        public function json() {
            $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'type', 'panel', ) );
            $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
            $array['content'] = $this->get_content();
            $array['active'] = $this->active();
            $array['instanceNumber'] = $this->instance_number;
            return $array;
        }
    }
}
