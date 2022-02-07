// External dependencies.
import React from 'react';

// Internal dependencies.
import './style.scss';
import Logo from '../../../components/logo';
import PageBuilder from '../page-builder-filter';
import ExitToDashboard from '../../../components/exist-to-dashboard';
import MyFavorite from './my-favorite';
import SyncLibrary from './sync-library';

const SiteListHeader = () => {
	return (
		<div className="site-list-header row">
			<div className="st-header-left">
				<Logo />
			</div>
			<div className="st-header-right">
				<MyFavorite />
				<SyncLibrary />
				<PageBuilder />
				<ExitToDashboard />
			</div>
		</div>
	);
};

export default SiteListHeader;
