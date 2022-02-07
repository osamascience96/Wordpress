/**
 * Meta Options build.
 */
import { PluginSidebar, PluginSidebarMoreMenuItem } from '@wordpress/edit-post';
import { compose } from '@wordpress/compose';
import { withSelect, withDispatch } from '@wordpress/data';
import AstCheckboxControl from './ast-checkbox.js';
import svgIcons from '../../../../assets/svg/svgs.json';
import { SelectControl } from '@wordpress/components';
import parse from 'html-react-parser';
import Title from './ast-title';
import Divider from './ast-divider';
const { __ } = wp.i18n;

const MetaSettings = props => {

	const icon = parse( svgIcons['astra-meta-settings'] );
	const sidebarOptions = Object.entries( astMetaParams.sidebar_options ).map( ( [ key, name ] ) => {
		return ( { label: name, value: key } );
	} );

	const contentLayoutOptions = Object.entries( astMetaParams.content_layout ).map( ( [ key, name ] ) => {
		return ( { label: name, value: key } );
	} );

	// Taransparent and Sticky Header Options.
	const headerOptions = Object.entries( astMetaParams.header_options ).map( ( [ key, name ] ) => {
		return ( { label: name, value: key } );
	} );

	// Page header optins.
	const pageHeaderOptions = Object.entries( astMetaParams.page_header_options ).map( ( [ key, name ] ) => {
		return ( { label: name, value: key } );
	} );

	// Checkbox control
	const disableSections = Object.entries( astMetaParams.disable_sections ).map( ( [ key, value ] ) => {
		let sectionValue = ( 'disabled' === props.meta[value['key']] ) ? true : false;
		return (
		<AstCheckboxControl
			label = { value['label'] }
			value = { sectionValue }
			key = { key }
			name = { value['key'] }
			onChange = { ( val ) => {
				props.setMetaFieldValue( val, value['key'] );
			} }
		/>);
	});

	// Checkbox control
	const stickyHeadderOptions = Object.entries( astMetaParams.sticky_header_options ).map( ( [ key, value ] ) => {
		let stickyValue =  ( 'disabled' === props.meta[value['key']] ) ? true : false;
		return (
		<AstCheckboxControl
			label = { value['label'] }
			value = { stickyValue }
			key = { key }
			name = { value['key'] }
			onChange = { ( val ) => {
				props.setMetaFieldValue( val, value['key'] );
			} }
		/>);
	});

	return (
		<>
			{/* Meta settings icon */}
			<PluginSidebarMoreMenuItem
				target="theme-meta-panel"
				icon={ icon }
			>
				{ astMetaParams.title }
			</PluginSidebarMoreMenuItem>

			{/* Meta seetings popup area */}
				<PluginSidebar
				isPinnable={ true }
				icon={ icon }
				name="theme-meta-panel"
				title={ astMetaParams.title }
			>

				<div className="ast-sidebar-container components-panel__body is-opened" id="astra_settings_meta_box">
					{/* Sidebar Setting */}
					<Title
						option={{
							label: __( 'Site Layout', 'astra' ),
							elementType:'ast-first'
						}}
					/>
					<div className="ast-sidebar-layout-meta-wrap components-base-control__field">
						<p className="ast-sidebar-control-title post-attributes-label-wrapper">
							<strong className="customize-control-title">{ astMetaParams.sidebar_title }</strong>
						</p>

						<SelectControl
							value={ ( undefined !== props.meta['site-sidebar-layout'] && ''!== props.meta['site-sidebar-layout'] ? props.meta['site-sidebar-layout'] : 'default' ) }
							options={ sidebarOptions }
							onChange={ ( val ) => {
								props.setMetaFieldValue( val, 'site-sidebar-layout' );
							} }
						/>
					</div>

					{/* Content Layout Setting */}
					<div className="ast-sidebar-layout-meta-wrap components-base-control__field">
						<p className="ast-sidebar-control-title post-attributes-label-wrapper">
							<strong className="customize-control-title">{ astMetaParams.content_layout_title }</strong>
						</p>
						<SelectControl
							value={ ( undefined !== props.meta['site-content-layout'] && '' !== props.meta['site-content-layout'] ) ? props.meta['site-content-layout'] : 'default'  }
							options={ contentLayoutOptions }
							onChange={ ( val ) => {
								props.setMetaFieldValue( val, 'site-content-layout' );
							} }
							id = "site-content-layout"
						/>
					</div>

					<Divider />

					{/* Disable Section Setting */}
					<div className="ast-sidebar-layout-meta-wrap components-base-control__field">
						<Title
							option={{
								label: __( 'Page Elements', 'astra'),
							}}
						/>
						{ disableSections }
					</div>

					<Divider />

					<Title
						option={{
							label: __( 'Header', 'astra' ),
						}}
					/>
					{/* Transparent Header Setting */}
					<div className="ast-sidebar-layout-meta-wrap components-base-control__field">
						<p className="ast-sidebar-control-title post-attributes-label-wrapper">
							<strong className="customize-control-title">{ astMetaParams.transparent_header_title }</strong>
						</p>
						<SelectControl
							value={ ( undefined !== props.meta['theme-transparent-header-meta'] && '' !== props.meta['theme-transparent-header-meta'] ) ? props.meta['theme-transparent-header-meta'] : 'default' }
							options={ headerOptions }
							onChange={ ( val ) => {
								props.setMetaFieldValue( val, 'theme-transparent-header-meta' );
							} }
						/>
					</div>

					{/* Page Header Setting */}
					{ astMetaParams.is_bb_themer_layout && astMetaParams.is_addon_activated && <div className="ast-sidebar-layout-meta-wrap components-base-control__field">
						<p className="ast-sidebar-control-title post-attributes-label-wrapper">
							<strong className="customize-control-title">{ astMetaParams.page_header_title }</strong>
						</p>
						<SelectControl
							value={ ( undefined !== props.meta['adv-header-id-meta'] && '' !== props.meta['adv-header-id-meta'] ) ? props.meta['adv-header-id-meta'] : '' }
							options={ pageHeaderOptions.reverse() }
							onChange={ ( val ) => {
								props.setMetaFieldValue( val, 'adv-header-id-meta' );
							} }
						/>
					</div>
					}

					{/* Sticky Header Setting */}
					{ 'disabled' !== props.meta['ast-main-header-display'] && astMetaParams.is_addon_activated && <div className="ast-sidebar-layout-meta-wrap components-base-control__field">
						<p className="ast-sidebar-control-title post-attributes-label-wrapper">
							<strong className="customize-control-title">{ astMetaParams.sticky_header_title }</strong>
						</p>
						<SelectControl
							value={ ( undefined !== props.meta['stick-header-meta'] && '' !== props.meta['stick-header-meta'] ) ? props.meta['stick-header-meta'] : 'default' }
							options={ headerOptions }
							onChange={ ( val ) => {
								props.setMetaFieldValue( val, 'stick-header-meta' );
							} }
						/>
					</div>
					}

					{ astMetaParams.is_addon_activated && 'enabled' == props.meta['stick-header-meta'] && <div className="ast-sticky-header-options ast-sidebar-layout-meta-wrap components-base-control__field">
						{stickyHeadderOptions}
					</div>
					}

				</div>
			</PluginSidebar>
		</>
	);
}

export default compose(
	withSelect( ( select ) => {
		const postMeta = select( 'core/editor' ).getEditedPostAttribute( 'meta' );
		const oldPostMeta = select( 'core/editor' ).getCurrentPostAttribute( 'meta' );
		return {
			meta: { ...oldPostMeta, ...postMeta },
			oldMeta: oldPostMeta,
		};
	} ),
	withDispatch( ( dispatch ) => ( {
		setMetaFieldValue: ( value, field ) => dispatch( 'core/editor' ).editPost(
			{ meta: { [ field ]: value } }
		),
	} ) ),
)( MetaSettings );
