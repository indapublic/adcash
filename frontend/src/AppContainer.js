import React, { Component } from 'react'
import configureStore from 'store/'
import Root from 'containers/Root'
import createHistory from 'history/createBrowserHistory'

const history = createHistory()

export default class AppContainer extends Component {
	render() {
		return <Root history={history} store={configureStore({}, history)} />
	}
}
