import { Api } from './Api'

/**
 * Products API.
 */
export default class ProductsApi extends Api {
	loadProducts = async () => {
		const response = await fetch(this.getUrl(`/products/`), {
			headers: this.getJsonHeaders()
		})
		switch (response.status) {
			case 200:
				return await response.json()
			default:
				return await this.handleStatus(response)
		}
	}
}
