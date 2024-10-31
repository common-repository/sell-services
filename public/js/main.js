/**
 * Main JavaScript functionality for Sell Services
 *
 * @package Sell_Services
 */

"use strict";

/*--------------------------------------------------------------
 # Document Ready
 --------------------------------------------------------------*/
jQuery( document ).ready( function( $ ) {

	// Initialize the Sell Services.
	if ( '' != bb_data.snippet_url ) {
		window.BBWidget.initialize({
			target: document.body,
			url: bb_data.snippet_url,
		});
	}

} );
