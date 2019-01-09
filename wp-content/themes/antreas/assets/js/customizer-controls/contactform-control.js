( function( api ) {

	api.AntreasContactFormControl = api.Control.extend( {

		ready: function() {
			var control = this,
				$pluginSelect =  control.container.children('select'),
				$wpformsContainer = control.container.find('.cpotheme_contact_control__wpforms'),
				$cf7Container = control.container.find('.cpotheme_contact_control__cf7forms');

			if ( $pluginSelect.length && control.settings.plugin_select.get() === 'wpforms') {
				$cf7Container.hide();
			}

			if ( $pluginSelect.length && control.settings.plugin_select.get() === 'cf7') {
				$wpformsContainer.hide();
			}

			$pluginSelect.change(function() {
				var val = $( this ).val();

				if ( val == 'wpforms' ) {
					$wpformsContainer.show().find('option:eq(0)').prop('selected', true);
					$cf7Container.hide();
				}
				else {
					$wpformsContainer.hide();
					$cf7Container.show().find('option:eq(0)').prop('selected', true);
				}
			} );

			$wpformsContainer.find('select').change(function() {
				var val = $( this ).val();
				if ( isNaN( val ) ) {
					return;
				}
				control.settings.plugin_select( 'wpforms' );
				control.settings.form_id( val );
			});

			$cf7Container.find('select').change(function() {
				var val = $( this ).val();

				if ( isNaN( val ) ) {
					return;
				}
				control.settings.plugin_select( 'cf7' );
				control.settings.form_id( val );
			});

		}

	} );

	$.extend( api.controlConstructor, {
		'antreas-contactform-control': api.AntreasContactFormControl,
    });

})( wp.customize );