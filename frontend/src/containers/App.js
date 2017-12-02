import React, { Component } from 'react'
import { withRouter, Switch, Route } from 'react-router-dom'
import { connect } from 'react-redux'
import Notifications from 'react-notification-system-redux'
import { Container } from 'semantic-ui-react'

import { Orders } from 'containers/Orders/'
import NotFound from 'components/NotFound'

class App extends Component {
	render() {
		return (
			<Container className="">
				<Switch>
					<Route path="/" component={Orders} />
					<Notifications notifications={this.props.notifications} />
					<Route component={NotFound} />
				</Switch>
			</Container>
		)
	}
}

export default withRouter(
	connect(
		state => ({
			notifications: state.notifications
		}),
		dispatch => ({})
	)(App)
)
