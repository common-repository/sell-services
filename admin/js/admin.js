/**
 * Module's JavaScript
 *
 * @package Sell_Services
 */

( function ( $ ) {
	'use strict';

	function tabs() {
		var $container = $( '.nav-tab-wrapper' ),
			$tabs = $container.find( '.nav-tab' ),
			$panes = $( '.ish-tab-pane' ),
			$hash = window.location.hash;

		// Applying deep link from url.
		if ( '' !== $hash ) {
			$tabs.removeClass( 'nav-tab-active' );
			$( ".nav-tab[ href='" + $hash + "' ]" ).addClass( 'nav-tab-active' );

			$panes.removeClass( 'ish-is-active' );
			$( ".ish-tab-pane[ id='" + $hash.substr( 1 ) + "' ]" ).addClass( 'ish-is-active' );

			setTimeout( function() { $( window ).scrollTop( 0 ) }, 100 );
		}

		$container.on( 'click', '.nav-tab', function ( e ) {
			e.preventDefault();
			window.location.hash = $( this ).attr( "href" );
			$( window ).scrollTop( 0 );

			$tabs.removeClass( 'nav-tab-active' );
			$( this ).addClass( 'nav-tab-active' );

			$panes.removeClass( 'ish-is-active' );
			$panes.filter( $( this ).attr( 'href' ) ).addClass( 'ish-is-active' );
		} );
	}

	// Auto activate tabs when DOM ready.
	$( tabs );
} ( jQuery ) );
