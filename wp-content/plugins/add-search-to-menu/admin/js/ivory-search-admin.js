( function( $ ) {

	'use strict';

	if ( typeof ivory_search === 'undefined' || ivory_search === null ) {
		return;
	}

	$( function() {

		$( window ).load( function() {
			$( '.col-wrapper .load-all' ).on( 'click', function() {
				var post_id = $('#post_ID').val();
				var post_type = $(this).attr('id');
				var this_load = $(this);
				var inc_exc = $('.search-form-editor-panel').attr('id');
				$(this).parent().append('<span class="spinner"></span>');
				$.ajax( {
					type : "post",
					url: ivory_search.ajaxUrl,
					data: {
						action: 'display_posts',
						post_id: post_id,
						post_type: post_type,
						inc_exc: inc_exc
					},
					success: function( response ) {
						$(this_load).parent().find('select').find('option').remove().end().append(response );
						if ( $(this_load).parent().find('select option:selected').length ) {
							$(this_load).parent().find('.col-title span').html( '<strong>'+$(this_load).parent().find('.col-title').text()+'</strong>');
						}
						$(this_load).parent().find('.spinner').remove();
						$(this_load).remove();
					},
					error: function (request, error) {
						alert( " The posts could not be loaded. Because: " + error );
					}
				} );
			} );
		} );

		$('.form-table .actions a.expand').click( function() {
			$('.form-table .actions a.expand').hide();
			$('.form-table .ui-accordion-content, .form-table .actions a.collapse').show();
			$('.form-table .ui-accordion-content').addClass('ui-accordion-content-active');
			$('.form-table h3').addClass('ui-state-active');
			return false;
		} );
		
		$('.form-table .actions a.collapse').click( function() {
			$('.form-table .actions a.expand').show();
			$('.form-table .ui-accordion-content, .form-table .actions a.collapse').hide();
			$('.form-table .ui-accordion-content').removeClass('ui-accordion-content-active');
			$('.form-table h3').removeClass('ui-state-active');
			return false;
		} );

		$( ".form-table" ).accordion( {
			collapsible: true,
			heightStyle: "content",
			icons: false,
		} );

		$('#search-body select[multiple] option').mousedown(function(e) {
			if ($(this).attr('selected')) {
				$(this).removeAttr('selected');
				return false;
			}
		} );

		$( ".col-title .list-search" ).keyup(function() {
			var search_val = $(this).val().toLowerCase();
			var search_sel = $(this).parent().parent().find('select option');
			$( search_sel ).each(function() {
				if ( $(this).text().toLowerCase().indexOf( search_val ) === -1 ) {
					$(this).fadeOut( 'fast' );
				} else {
					$(this).fadeIn( 'fast' );
				}
			} );
		} );

		$( ".list-search.wide" ).keyup(function() {
			var search_val = $(this).val().toLowerCase();
			var search_sel = $(this).parent().find('select option');
			$( search_sel ).each(function() {
				if ( $(this).text().toLowerCase().indexOf( search_val ) === -1 ) {
					$(this).fadeOut( 'fast' );
				} else {
					$(this).fadeIn( 'fast' );
				}
			} );
		} );

		if ( '' === $( '#title' ).val() ) {
			$( '#title' ).focus();
		}

		ivory_search.titleHint();

		$('#search-form-editor .ind-status').each(function(){
			var ind_class = $(this).attr('class').split(' ')[1];
			if ( ind_class !== null ) {
				$('.form-table h3 .indicator.'+ind_class).fadeIn();
			}
		} );

		$('#search-form-editor').on('keyup change paste', 'input, select, textarea', function( e ){
			var ind_class = $(e.target).attr("class");
			if ( ind_class !== null ) {
				$('.form-table h3 .indicator.'+ind_class).fadeOut().fadeIn();
			}
		} );

		var changed = false;

		$(document).on("submit", "form", function(event){
			changed = false;
			$(window).off('beforeunload');
		} );

		$( window ).on( 'beforeunload', function( event ) {

			$( '#search-body :input[type!="hidden"]' ).each( function() {
				if ( $( this ).is( ':checkbox, :radio' ) ) {
					if ( this.defaultChecked != $( this ).is( ':checked' ) ) {
						changed = true;
					}
				} else if ( $( this ).is( 'select' ) ) {
					$( this ).find( 'option' ).each( function() {
						if ( this.defaultSelected != $( this ).is( ':selected' ) ) {
							changed = true;
						}
					} );
				} else {
					if ( this.defaultValue != $( this ).val() ) {
						changed = true;
					}
				}
			} );

			if ( changed ) {
				event.returnValue = ivory_search.saveAlert;
				return ivory_search.saveAlert;
			}
		} );

		$( '#is-admin-form-element' ).submit( function() {
			if ( 'copy' != this.action.value ) {
				$( window ).off( 'beforeunload' );
			}

			if ( 'save' == this.action.value ) {
				$( '#publishing-action .spinner' ).addClass( 'is-active' );
			}
		} );
	} );

	ivory_search.titleHint = function() {
		var $title = $( '#title' );
		var $titleprompt = $( '#title-prompt-text' );

		if ( '' === $title.val() ) {
			$titleprompt.removeClass( 'screen-reader-text' );
		}

		$titleprompt.click( function() {
			$( this ).addClass( 'screen-reader-text' );
			$title.focus();
		} );

		$title.blur( function() {
			if ( '' === $(this).val() ) {
				$titleprompt.removeClass( 'screen-reader-text' );
			}
		} ).focus( function() {
			$titleprompt.addClass( 'screen-reader-text' );
		} ).keydown( function( e ) {
			$titleprompt.addClass( 'screen-reader-text' );
			$( this ).unbind( e );
		} );
	};

} )( jQuery );
