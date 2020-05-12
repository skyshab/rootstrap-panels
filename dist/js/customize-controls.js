/**
 * Scripts for custom panel type.
 *
 * @package   Rootstrap Customize
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2019, Sky Shabatura
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* See https://gist.github.com/OriginalEXE/9a6183e09f4cae2f30b006232bb154af */

( function( $ ) {

    var api = wp.customize;

    api.bind( 'pane-contents-reflowed', function() {

        // Reflow panels
        var panels = [];

        api.panel.each( function( panel ) {

            if ('rootstrap_panel' !== panel.params.type || 'undefined' === typeof panel.params.panel) {
                return;
            }

            panels.push( panel );
        });

        panels.sort( api.utils.prioritySort );

        $.each( panels, function( i, panel ) {
            $( '#sub-accordion-panel-' + panel.params.panel ).append( panel.headContainer );
        });
    });


    // Extend Panel
    var _panelEmbed = wp.customize.Panel.prototype.embed;
    var _panelIsContextuallyActive = wp.customize.Panel.prototype.isContextuallyActive;
    var _panelAttachEvents = wp.customize.Panel.prototype.attachEvents;

    wp.customize.Panel = wp.customize.Panel.extend({

        attachEvents: function() {

            _panelAttachEvents.call( this );

            if ('rootstrap_panel' !== this.params.type || 'undefined' === typeof this.params.panel ) {
                return;
            }

            var panel = this;

            panel.expanded.bind( function( expanded ) {
                api.panel( panel.params.panel ).contentContainer.toggleClass( 'current-panel-parent', expanded );
            });

            panel.container.find( '.customize-panel-back' ).off( 'click keydown' ).on( 'click keydown', function( event ) {

                if ( api.utils.isKeydownButNotEnterEvent( event ) ) {
                    return;
                }

                event.preventDefault(); // Keep this AFTER the key filter above

                if ( panel.expanded() ) {
                    api.panel( panel.params.panel ).expand();
                }
            });
        },
        embed: function() {

            _panelEmbed.call( this );

            if ('rootstrap_panel' !== this.params.type || 'undefined' === typeof this.params.panel) {
                return;
            }

            var panel = this;
            $( '#sub-accordion-panel-' + this.params.panel ).append( panel.headContainer );
        },
        isContextuallyActive: function() {

            if ('rootstrap_panel' !== this.params.type) {
                return _panelIsContextuallyActive.call( this );
            }

            var panel = this;
            var children = this._children( 'panel', 'section' );

            api.panel.each( function( child ) {

                if (!child.params.panel || child.params.panel !== panel.id) {
                    return;
                }

                children.push( child );
            });

            children.sort( api.utils.prioritySort );

            var activeCount = 0;

            _( children ).each( function ( child ) {
                if ( child.active() && child.isContextuallyActive() ) {
                    activeCount += 1;
                }
            });

            return ( activeCount !== 0 );
        }

    });

  })( jQuery );
