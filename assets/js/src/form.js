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
		this.$data     = '';
		this.init();
	}

	// Avoid Plugin.prototype conflicts
	$.extend( frontendsubmissionform.prototype, {
		init: function() {
			this.attachEvents();
		},
		attachEvents: function() {
			let self = this;
			this.$el.on( 'submit', '.fes-post-form', function( e ) {
				e.preventDefault();
				self.$data = $( this ).serialize();
				self.submitPost( this );
			});
		},
		submitPost: function( form ) {
			var self = this;
			$.ajax({
				url: window.ajaxurl,
				type: 'POST',
				data: self.$data
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
				}
			});
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
