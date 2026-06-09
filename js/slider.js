/**
 * Skeleton WP — Image Slider
 * Autoplay, touch/swipe, keyboard nav, ARIA, dot navigation.
 */
( function () {
    'use strict';

    document.addEventListener( 'DOMContentLoaded', function () {
        var track   = document.getElementById( 'sliderTrack' );
        var prev    = document.getElementById( 'sliderPrev' );
        var next    = document.getElementById( 'sliderNext' );
        var dotsWrap = document.getElementById( 'sliderDots' );

        if ( ! track ) return;

        var slides   = track.querySelectorAll( '.slide' );
        var total    = slides.length;
        var current  = 0;
        var timer    = null;
        var autoplay = ( typeof skeletonWP !== 'undefined' ) ? !! skeletonWP.autoplay : true;
        var delay    = ( typeof skeletonWP !== 'undefined' ) ? parseInt( skeletonWP.autoplayMs, 10 ) : 5000;

        if ( total < 1 ) return;

        /* ---- Build thumbnail dots ---- */
        var dots = [];
        for ( var i = 0; i < total; i++ ) {
            var dot = document.createElement( 'button' );
            dot.className   = 'slider-dot' + ( i === 0 ? ' active' : '' );
            dot.setAttribute( 'aria-label', 'Go to slide ' + ( i + 1 ) );
            dot.setAttribute( 'type', 'button' );
            var slideImg = slides[i].querySelector( '.slide-image' );
            if ( slideImg ) {
                dot.style.backgroundImage = 'url(' + slideImg.src + ')';
            }
            /* closure over i */
            ( function( idx ) {
                dot.addEventListener( 'click', function () { goTo( idx ); } );
            } )( i );
            dotsWrap.appendChild( dot );
            dots.push( dot );
        }

        /* ---- Move to slide ---- */
        function goTo( idx ) {
            current = ( idx + total ) % total;
            track.style.transform = 'translateX(-' + ( current * 100 ) + '%)';
            dots.forEach( function ( d, j ) {
                d.classList.toggle( 'active', j === current );
                d.setAttribute( 'aria-pressed', j === current ? 'true' : 'false' );
            } );
            slides.forEach( function ( s, j ) {
                s.setAttribute( 'aria-hidden', j !== current ? 'true' : 'false' );
            } );
            resetTimer();
        }

        /* ---- Controls ---- */
        if ( prev ) prev.addEventListener( 'click', function () { goTo( current - 1 ); } );
        if ( next ) next.addEventListener( 'click', function () { goTo( current + 1 ); } );

        /* ---- Keyboard ---- */
        document.addEventListener( 'keydown', function ( e ) {
            var slider = document.getElementById( 'slider-section' );
            if ( ! slider ) return;
            if ( e.key === 'ArrowLeft' )  goTo( current - 1 );
            if ( e.key === 'ArrowRight' ) goTo( current + 1 );
        } );

        /* ---- Autoplay ---- */
        function startTimer() {
            if ( ! autoplay || total < 2 ) return;
            timer = setInterval( function () { goTo( current + 1 ); }, delay );
        }
        function resetTimer() {
            clearInterval( timer );
            startTimer();
        }

        /* Pause on hover */
        var section = document.getElementById( 'slider-section' );
        if ( section ) {
            section.addEventListener( 'mouseenter', function () { clearInterval( timer ); } );
            section.addEventListener( 'mouseleave', startTimer );
            section.addEventListener( 'focusin',    function () { clearInterval( timer ); } );
            section.addEventListener( 'focusout',   startTimer );
        }

        /* ---- Touch / Swipe ---- */
        var touchStartX = 0;
        var touchEndX   = 0;
        track.addEventListener( 'touchstart', function ( e ) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true } );
        track.addEventListener( 'touchend', function ( e ) {
            touchEndX = e.changedTouches[0].screenX;
            var diff  = touchStartX - touchEndX;
            if ( Math.abs( diff ) > 50 ) {
                goTo( diff > 0 ? current + 1 : current - 1 );
            }
        }, { passive: true } );

        /* ---- Init ---- */
        goTo( 0 );
        startTimer();
    } );
} )();
