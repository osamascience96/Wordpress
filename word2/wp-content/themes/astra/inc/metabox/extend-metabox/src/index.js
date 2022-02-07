import { registerPlugin } from '@wordpress/plugins';
import MetaSettings from './settings';

registerPlugin( 'astra-theme-layout', { render: MetaSettings } );
