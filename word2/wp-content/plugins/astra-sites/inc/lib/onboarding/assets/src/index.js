import React from 'react';
import ReactDOM from 'react-dom';
import reducer, { initialState } from './store/reducer';
import { StateProvider } from './store/store';
import App from './app';

ReactDOM.render(
	<StateProvider reducer={ reducer } initialState={ initialState }>
		<App />
	</StateProvider>,
	document.getElementById( 'starter-templates-ai-root' )
);
