/**
 * Skeleton WP — Mobile Navigation Toggle + Sub-menu support
 */
( function () {
    'use strict';

    document.addEventListener( 'DOMContentLoaded', function () {
        var toggle = document.querySelector( '.menu-toggle' );
        var nav    = document.getElementById( 'site-navigation' );

        if ( ! toggle || ! nav ) return;

        /* ---- Main hamburger toggle ---- */
        toggle.addEventListener( 'click', function () {
            var expanded = toggle.getAttribute( 'aria-expanded' ) === 'true';
            toggle.setAttribute( 'aria-expanded', String( ! expanded ) );
            nav.classList.toggle( 'toggled' );
        } );

        /* Close on outside click */
        document.addEventListener( 'click', function ( e ) {
            if ( nav.classList.contains( 'toggled' ) && ! nav.contains( e.target ) && e.target !== toggle ) {
                nav.classList.remove( 'toggled' );
                toggle.setAttribute( 'aria-expanded', 'false' );
            }
        } );

        /* Close on Escape */
        document.addEventListener( 'keydown', function ( e ) {
            if ( e.key === 'Escape' && nav.classList.contains( 'toggled' ) ) {
                nav.classList.remove( 'toggled' );
                toggle.setAttribute( 'aria-expanded', 'false' );
                toggle.focus();
            }
        } );

        /* ---- Mobile sub-menu toggles ---- */
        /* Only inject on touch / narrow viewports. We re-check on resize. */
        function isMobile() {
            return window.innerWidth <= 749;
        }

        /* Inject a chevron button next to each top-level item that has children */
        var parentItems = nav.querySelectorAll( 'ul > li' );
        parentItems.forEach( function ( li ) {
            var subMenu = li.querySelector( 'ul' );
            if ( ! subMenu ) return;

            /* Avoid double-injecting */
            if ( li.querySelector( '.sub-menu-toggle' ) ) return;

            var btn = document.createElement( 'button' );
            btn.className = 'sub-menu-toggle';
            btn.setAttribute( 'aria-expanded', 'false' );
            btn.setAttribute( 'aria-label', 'Expand sub-menu' );
            btn.innerHTML = '<i class="fa fa-chevron-down" aria-hidden="true"></i>';

            /* Insert right after the anchor */
            var anchor = li.querySelector( 'a' );
            if ( anchor ) {
                anchor.insertAdjacentElement( 'afterend', btn );
            } else {
                li.prepend( btn );
            }

            btn.addEventListener( 'click', function ( e ) {
                e.stopPropagation();
                if ( ! isMobile() ) return; /* desktop uses CSS hover */

                var open = li.classList.contains( 'sub-menu-open' );

                /* Close other open siblings */
                var siblings = li.parentElement.querySelectorAll( 'li.sub-menu-open' );
                siblings.forEach( function ( sib ) {
                    if ( sib !== li ) {
                        sib.classList.remove( 'sub-menu-open' );
                        var sibBtn = sib.querySelector( '.sub-menu-toggle' );
                        if ( sibBtn ) sibBtn.setAttribute( 'aria-expanded', 'false' );
                    }
                } );

                li.classList.toggle( 'sub-menu-open', ! open );
                btn.setAttribute( 'aria-expanded', String( ! open ) );
            } );
        } );

        /* Show/hide sub-menu toggle buttons based on viewport width */
        function syncSubToggleVisibility() {
            var btns = nav.querySelectorAll( '.sub-menu-toggle' );
            btns.forEach( function ( b ) {
                b.style.display = isMobile() ? '' : 'none';
            } );
            /* On desktop, re-enable CSS hover by removing open classes */
            if ( ! isMobile() ) {
                nav.querySelectorAll( '.sub-menu-open' ).forEach( function ( li ) {
                    li.classList.remove( 'sub-menu-open' );
                } );
            }
        }

        syncSubToggleVisibility();
        window.addEventListener( 'resize', syncSubToggleVisibility );
    } );
} )();
