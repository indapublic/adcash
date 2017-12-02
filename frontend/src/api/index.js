/**
 * Combine all APIs in one declaration.
 */

import OrdersApi from './orders'
import ProductsApi from './products'
import UsersApi from './users'

const apiAvailable = {
	ordersApi: OrdersApi,
	productsApi: ProductsApi,
	usersApi: UsersApi
}
const apiEnabled = []

/**
 * Get API object by name.
 *
 * @param {string} apiName API name
 * @param {object} options API options
 */
const getApi = (apiName, options) =>
	apiEnabled[apiName]
		? apiEnabled[apiName]
		: (apiEnabled[apiName] = new apiAvailable[apiName](options))

export const ordersApi = options => getApi(`ordersApi`, options)
export const productsApi = options => getApi(`productsApi`, options)
export const usersApi = options => getApi(`usersApi`, options)
