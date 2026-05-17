/**
 * Skeleton WP — Mobile Navigation Toggle
 */
( function () {
    'use strict';

    document.addEventListener( 'DOMContentLoaded', function () {
        var toggle = document.querySelector( '.menu-toggle' );
        var nav    = document.getElementById( 'site-navigation' );

        if ( ! toggle || ! nav ) return;

        toggle.addEventListener( 'click', function () {
            var expanded = toggle.getAttribute( 'aria-expanded' ) === 'true';
            toggle.setAttribute( 'aria-expanded', ! expanded );
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
    } );
} )();
