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

			// submit post form.
			this.$el.on( 'submit', '.fes-post-form', function( e ) {
				e.preventDefault();
				self.$data = new FormData( this );
				self.submitPost( this );
			});

			//image upload.
			$( '#fe-post-image' ).change( function() {
				self.fileUpload( this );
			});
		},
		submitPost: function( form ) {
			var self = this;
			$.ajax({
				url: window.ajaxurl,
				type: 'POST',
				data: self.$data,
				cache: false,
				contentType: false,
				processData: false
			})
			.done( res => {
				if ( false === res.success ) {
					$( this ).find( '.error-message' ).append( res.data.message );
					if ( res.data.fields ) {
						$.each( res.data.fields, function( key, value ) {
							$( '#' + value + '-error' ). append( res.data.fields_message );
							$( '#' + value + '-error' ).show();
							$( '.' + value ).addClass( 'sui-form-field-error' );
						});
					}
				} else if ( true === res.success ) {
					console.log( res );
				}
			});
		},
		fileUpload: function( input ) {
			if ( input.files && input.files[0]) {
				let reader = new FileReader();
				reader.onload = function( e ) {
					$( '#imagePreview' ).css( 'background-image', 'url(' + e.target.result + ')' );
					$( '#imagePreview' ).hide();
					$( '#imagePreview' ).fadeIn( 650 );
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
