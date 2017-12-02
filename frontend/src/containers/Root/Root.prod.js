import React, { Component } from 'react'
import { Provider } from 'react-redux'
import { ConnectedRouter } from 'react-router-redux'

import App from 'containers/App'

export default class Root extends Component {
	render() {
		const { history, store } = this.props
		return (
			<Provider store={store}>
				<div>
					<ConnectedRouter history={history}>
						<App />
					</ConnectedRouter>
				</div>
			</Provider>
		)
	}
}
