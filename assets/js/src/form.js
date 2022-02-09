// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly.
;// noinspection JSUnusedLocalSymbols
( function( $, window, document, undefined ) {

	'use strict';

	// Create the defaults once
	var pluginName = 'frontendsubmissionform';

	// The actual plugin constructor
	function frontendsubmissionform( element, options ) {
		this.element   = element;
		this.$el       = $( this.element );
		this.$data     = new FormData();
		this.init();
	}

	// Avoid Plugin.prototype conflicts
	$.extend( frontendsubmissionform.prototype, {
		init: function() {
			this.attachEvents();
		},
		attachEvents: function() {
			let self = this;

			//image upload.
			$( '#fe-post-image-fr' ).change( function() {
				self.fileUpload( this, 'fr' );
			});
			$( '#fe-post-image-en' ).change( function() {
				self.fileUpload( this, 'en' );
			});

		},
		fileUpload: function( input, locale ) {
			
			if ( input.files && input.files[0]) {
				let reader = new FileReader();
				reader.onload = function( e ) {
					$( '#imagePreview-' + locale ).css( 'background-image', 'url(' + e.target.result + ')' );
					$( '#imagePreview-' + locale ).hide();
					$( '#imagePreview-' + locale ).fadeIn( 650 );
				};
				reader.readAsDataURL( input.files[0]);
			}
		}
	});

	// A really lightweight plugin wrapper around the constructor,
	// preventing against multiple instantiations
	$.fn[pluginName] = function( options ) {
		return this.each( function() {
			if ( ! $.data( this, pluginName ) ) {
				$.data( this, pluginName, new frontendsubmissionform( this, options ) );
			}
		});
	};

}( jQuery, window, document ) );
