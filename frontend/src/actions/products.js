import * as productsTypes from 'actionTypes/products'

import { productsApi } from 'api/'

import { error } from 'utils/'

export const reset = () => ({
	type: productsTypes.RESET
})

export const set = payload => ({
	type: productsTypes.SET,
	payload
})

/**
 * Load products.
 *
 * @return {array} Loaded products
 */
export const loadProducts = () => async (dispatch, getState) => {
	dispatch(
		set({
			isLoading: true,
			error: null
		})
	)
	try {
		const products = await productsApi().loadProducts()
		dispatch(
			set({
				isLoading: false,
				products,
				error: null
			})
		)
		return products
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
