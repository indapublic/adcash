import { combineReducers } from 'redux'
import { routerReducer as router } from 'react-router-redux'
import { reducer as notifications } from 'react-notification-system-redux'

import orders from './orders'
import products from './products'
import users from './users'

export default combineReducers({
	orders,
	products,
	users,
	router,
	notifications
})
