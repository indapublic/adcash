import { Api } from './Api'

/**
 * Users API.
 */
export default class UsersApi extends Api {
	loadUsers = async () => {
		const response = await fetch(this.getUrl(`/users/`), {
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
