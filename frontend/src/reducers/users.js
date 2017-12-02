import * as usersTypes from 'actionTypes/users'

const initialState = {
	isLoading: true,
	users: [],
	error: null
}

const reducer = (state = initialState, action) => {
	switch (action.type) {
		case usersTypes.RESET:
			return {
				...initialState
			}
		case usersTypes.SET:
			return {
				...state,
				...action.payload
			}
		default:
			return state
	}
}

export default reducer
