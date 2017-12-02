import { createStore, applyMiddleware, compose } from 'redux'
import { createLogger } from 'redux-logger'
import { routerMiddleware } from 'react-router-redux'
import thunk from 'redux-thunk'

import rootReducer from 'reducers/'

export default function configureStore(initialState = {}, history) {
	//  Create the store with two middlewares
	const historyMiddleware = routerMiddleware(history)

	const middlewares = [thunk, createLogger(), historyMiddleware]

	const enhancer = compose(applyMiddleware(...middlewares))

	const store = createStore(rootReducer, initialState, enhancer)

	return store
}
