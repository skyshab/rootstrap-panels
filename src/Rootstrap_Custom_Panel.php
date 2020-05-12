<?php
/**
 * Custom Panels Class.
 *
 * This class handles creation of our custom panel type
 *
 * @package   Rootstrap\Customize
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2020, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* See https://gist.github.com/OriginalEXE/9a6183e09f4cae2f30b006232bb154af */

if ( class_exists( 'WP_Customize_Panel' ) ) {

    class Rootstrap_Custom_Panel extends WP_Customize_Panel {

        public $panel;
        public $type = 'rootstrap_panel';
        public $pre_title_label = 'Customizing';

        /**
         * Define data to be used in panel template.
         */
        public function json() {
            $array = wp_array_slice_assoc( (array) $this, [ 'id', 'description', 'priority', 'type', 'panel' ] );
            $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
            $array['content'] = $this->get_content();
            $array['active'] = $this->active();
            $array['instanceNumber'] = $this->instance_number;
            $array['preTitle'] = $this->pre_title_label;

            if ( $this->panel ) {
                $array['preTitle'] .= ' ▸ ' . esc_html( $this->manager->get_panel( $this->panel )->title );
            }

            return $array;
        }

        /**
         * An Underscore (JS) template for this panel's content.
         */
        public function content_template() {
            ?>
            <li class="panel-meta customize-info accordion-section <# if ( ! data.description ) { #> cannot-expand<# } #>">
                <button class="customize-panel-back" tabindex="-1"><span class="screen-reader-text"><?php _e( 'Back' ); ?></span></button>
                <div class="accordion-section-title">
                    <span class="preview-notice">
                        <?php echo '{{ data.preTitle }}<strong class="panel-title">{{ data.title }}</strong>' ?>
                    </span>
                    <# if ( data.description ) { #>
                        <button type="button" class="customize-help-toggle dashicons dashicons-editor-help" aria-expanded="false"><span class="screen-reader-text"><?php _e( 'Help' ); ?></span></button>
                    <# } #>
                </div>
                <# if ( data.description ) { #>
                    <div class="description customize-panel-description">
                        {{{ data.description }}}
                    </div>
                <# } #>

                <div class="customize-control-notifications-container"></div>
            </li>
            <?php
        }
    }
}
