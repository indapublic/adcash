/**
 * API environment variables.
 */
import { apiUrl as configUrl } from 'config.env'
const apiUrl = window.localStorage.getItem('api_url') || configUrl

const env = {
	/**
	 * Api URL is hardcoded but can be stored inside local storage
	 */
	apiUrl,
	/**
	 * Access token stored in variable
	 */
	token: null
}

export default env
