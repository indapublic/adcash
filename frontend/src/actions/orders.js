import * as ordersTypes from 'actionTypes/orders'

import { push } from 'react-router-redux'

import { ordersApi } from 'api/'

import { error } from 'utils/'

export const reset = () => ({
	type: ordersTypes.RESET
})

export const set = payload => ({
	type: ordersTypes.SET,
	payload
})

export const setOrder = payload => ({
	type: ordersTypes.SET_ORDER,
	payload
})

export const setSearch = payload => ({
	type: ordersTypes.SET_SEARCH,
	payload
})

/**
 * Load orders.
 *
 * @return {array} Loaded orders
 */
export const loadOrders = (periodValue, searchText) => async (
	dispatch,
	getState
) => {
	dispatch(
		set({
			isLoading: true,
			error: null
		})
	)
	try {
		const orders = await ordersApi().loadOrders(periodValue, searchText)
		dispatch(
			set({
				isLoading: false,
				orders,
				error: null
			})
		)
		return orders
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

/**
 * Load specific order.
 *
 * @param {number} orderId
 *
 * @return {object} Loaded order.
 */
export const loadOrder = orderId => async (dispatch, getState) => {
	dispatch(
		setOrder({
			isLoading: true,
			error: null
		})
	)
	try {
		const order = await ordersApi().loadOrder(orderId)
		dispatch(
			setOrder({
				isLoading: false,
				order,
				error: null
			})
		)
		return order
	} catch (err) {
		dispatch(
			setOrder({
				isLoading: false,
				error: err.message
			})
		)
		dispatch(error(err.message))
		throw err
	}
}

/**
 * Save order.
 */
export const saveOrder = () => async (dispatch, getState) => {
	dispatch(
		setOrder({
			isSubmitting: true,
			error: null
		})
	)
	const { order } = getState().orders
	let success = true
	if (!order.user) {
		dispatch(
			setOrder({
				isSubmitting: false,
				error: 'You should define user'
			})
		)
		success = false
	}
	if (!order.product) {
		dispatch(
			setOrder({
				isSubmitting: false,
				error: 'You should define product'
			})
		)
		success = false
	}
	if (!order.quantity) {
		dispatch(
			setOrder({
				isSubmitting: false,
				error: 'You should define quantity'
			})
		)
		success = false
	}
	if (!success) return null
	try {
		const savedOrder = await ordersApi().saveOrder({
			'order-id': order.id,
			'user-id': order.user.id,
			'product-id': order.product.id,
			quantity: order.quantity
		})
		dispatch(
			set({
				orders: !!order.id
					? getState().orders.orders.map(
							order => (order.id === savedOrder.id ? savedOrder : order)
						)
					: getState().orders.orders.concat(savedOrder)
			})
		)
		dispatch(
			setOrder({
				isSubmitting: false,
				error: null
			})
		)
		dispatch(push('/'))
	} catch (err) {
		dispatch(error(err.message))
		dispatch(
			setOrder({
				isSubmitting: false,
				error: err.message
			})
		)
	}
}

/**
 * Delete order.
 *
 * @param {string} orderId
 */
export const deleteOrder = orderId => async (dispatch, getState) => {
	try {
		await ordersApi().deleteOrder(orderId)
		dispatch(
			set({
				orders: getState().orders.orders.filter(order => order.id !== orderId)
			})
		)
		dispatch(push('/'))
	} catch (err) {
		dispatch(error(err.message))
	}
}
