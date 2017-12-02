import { Api } from './Api'

/**
 * History API.
 */
export default class HistoryApi extends Api {
	/**
	 * Load orders.
	 */
	loadOrders = async (periodValue, searchText) => {
		const response = await fetch(this.getUrl(`/orders/`), {
			headers: this.getJsonHeaders(),
			body: JSON.stringify({
				'period-value': periodValue,
				'search-text': searchText
			})
		})
		switch (response.status) {
			case 200:
				return await response.json()
			default:
				return await this.handleStatus(response)
		}
	}

	/**
	 * Load specific order.
	 *
	 * @param {string} orderId Order ID
	 */
	loadOrder = async orderId => {
		const response = await fetch(this.getUrl(`/orders/${orderId}`), {
			headers: this.getJsonHeaders()
		})
		switch (response.status) {
			case 200:
				return await response.json()
			default:
				return await this.handleStatus(response)
		}
	}

	/**
	 * Save order (new or existing).
	 *
	 * @param {object} data Order values
	 */
	saveOrder = async data => {
		const url = !!data['order-id']
			? this.getUrl(`/orders/${data['order-id']}`)
			: this.getUrl(`/orders/`)
		const response = await fetch(url, {
			method: !!data['order-id'] ? 'put' : 'post',
			headers: this.postJsonHeaders(),
			body: JSON.stringify(data)
		})
		switch (response.status) {
			case 200:
			case 201:
				return await response.json()
			default:
				return await this.handleStatus(response)
		}
	}

	/**
	 * Delete specific order.
	 *
	 * @param {string} orderId Order ID
	 */
	deleteOrder = async orderId => {
		const response = await fetch(this.getUrl(`/orders/${orderId}`), {
			method: 'delete',
			headers: this.postJsonHeaders()
		})
		switch (response.status) {
			case 204:
				return true
			default:
				return await this.handleStatus(response)
		}
	}
}
