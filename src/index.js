import { addFilter } from '@wordpress/hooks';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { createHigherOrderComponent } from '@wordpress/compose';
import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';

const BLOCK_NAME    = 'core/query';
const ATTRIBUTE_KEY = 'nqlltOpenInNewTab';

/**
 * 1. core/query ブロックに nqlltOpenInNewTab 属性を追加する。
 */
addFilter(
	'blocks.registerBlockType',
	'nqllt/add-attribute',
	( settings, name ) => {
		if ( name !== BLOCK_NAME ) {
			return settings;
		}
		return {
			...settings,
			attributes: {
				...settings.attributes,
				[ ATTRIBUTE_KEY ]: {
					type: 'boolean',
					default: false,
				},
			},
		};
	}
);

/**
 * 2. インスペクターパネルに「新しいタブで開く」トグルを追加する。
 */
const withOpenInNewTabControl = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		const { name, attributes, setAttributes } = props;

		if ( name !== BLOCK_NAME ) {
			return <BlockEdit { ...props } />;
		}

		const isChecked = !! attributes[ ATTRIBUTE_KEY ];

		return (
			<Fragment>
				<BlockEdit { ...props } />
				<InspectorControls>
					<PanelBody title={ __( 'リンクターゲット', 'nqllt' ) }>
						<ToggleControl
							label={ __( '新しいタブでリンクを開く', 'nqllt' ) }
							help={
								isChecked
									? __( 'リンクは新しいタブ（target="_blank"）で開きます。', 'nqllt' )
									: __( 'リンクは同じタブで開きます。', 'nqllt' )
							}
							checked={ isChecked }
							onChange={ ( value ) =>
								setAttributes( { [ ATTRIBUTE_KEY ]: value } )
							}
						/>
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'withOpenInNewTabControl' );

addFilter(
	'editor.BlockEdit',
	'nqllt/with-open-in-new-tab-control',
	withOpenInNewTabControl
);
