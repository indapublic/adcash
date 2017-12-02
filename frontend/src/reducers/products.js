import * as productsTypes from 'actionTypes/products'

const initialState = {
	isLoading: true,
	products: [],
	error: null
}

const reducer = (state = initialState, action) => {
	switch (action.type) {
		case productsTypes.RESET:
			return {
				...initialState
			}
		case productsTypes.SET:
			return {
				...state,
				...action.payload
			}
		default:
			return state
	}
}

export default reducer
