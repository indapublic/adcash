import * as usersTypes from 'actionTypes/users'

import { usersApi } from 'api/'

import { error } from 'utils/'

export const reset = () => ({
	type: usersTypes.RESET
})

export const set = payload => ({
	type: usersTypes.SET,
	payload
})

/**
 * Load users.
 *
 * @return {array} Loaded users
 */
export const loadUsers = () => async (dispatch, getState) => {
	dispatch(
		set({
			isLoading: true,
			error: null
		})
	)
	try {
		const users = await usersApi().loadUsers()
		dispatch(
			set({
				isLoading: false,
				users,
				error: null
			})
		)
		return users
	} catch (err) {
		dispatch(
			set({
				isLoading: false,
				error: err.message
			})
		)
		dispatch(error(err.message))
		throw err
	}
}
