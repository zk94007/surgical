var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.components.ServerSideRender,
	TextControl = wp.components.TextControl,
	SelectControl = wp.components.SelectControl,
	InspectorControls = wp.editor.InspectorControls;

registerBlockType( 'ultimate-product-catalogue/ewd-upcp-display-catalog-block', {
	title: 'Display Product Catalog',
	icon: 'feedback',
	category: 'ewd-upcp-blocks',
	attributes: {
		id: { type: 'string' },
		sidebar: { type: 'string' },
		starting_layout: { type: 'string' },
		excluded_layouts: { type: 'string' },
	},

	edit: function( props ) {
		var returnString = [];
		returnString.push(
			el( InspectorControls, {},
				el( TextControl, {
					label: 'Product Catalog ID',
					value: props.attributes.id,
					onChange: ( value ) => { props.setAttributes( { id: value } ); },
				} ),
				el( SelectControl, {
					label: 'Sidebar',
					value: props.attributes.sidebar,
					options: [ {value: 'Yes', label: 'Yes'}, {value: 'No', label: 'No'} ],
					onChange: ( value ) => { props.setAttributes( { sidebar: value } ); },
				} ),
				el( SelectControl, {
					label: 'Starting Layout',
					value: props.attributes.starting_layout,
					options: [ {value: 'Thumbnail', label: 'Thumbnail'}, {value: 'Detail', label: 'Detail'}, {value: 'List', label: 'List'} ],
					onChange: ( value ) => { props.setAttributes( { starting_layout: value } ); },
				} ),
				el( TextControl, {
					label: 'Excluded Layouts (e.g. "List" or "Thumbnail,List")',
					value: props.attributes.excluded_layouts,
					onChange: ( value ) => { props.setAttributes( { excluded_layouts: value } ); },
				} )
			),
		);
		returnString.push( el( 'div', { class: 'ewd-upcp-admin-block ewd-upcp-admin-block-display-catalog' }, 'Display Product Catalog Block' ) );
		return returnString;
	},

	save: function() {
		return null;
	},
} );


