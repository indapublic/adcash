import * as ordersTypes from 'actionTypes/orders'

const initialState = {
	isLoading: true,
	orders: [],
	order: {
		isSubmitting: false,
		user: null,
		product: null,
		quantity: 0,
		error: null
	},
	search: {
		active: false,
		periodValue: 'all-time',
		searchText: ''
	},
	error: null
}

const reducer = (state = initialState, action) => {
	switch (action.type) {
		case ordersTypes.RESET:
			return {
				...initialState
			}
		case ordersTypes.SET:
			return {
				...state,
				...action.payload
			}
		case ordersTypes.SET_ORDER:
			return {
				...state,
				order: {
					...state.order,
					...action.payload
				}
			}
		case ordersTypes.SET_SEARCH:
			return {
				...state,
				search: {
					...state.search,
					...action.payload
				}
			}
		default:
			return state
	}
}

export default reducer
