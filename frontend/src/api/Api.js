import env from 'api/env'
import 'whatwg-fetch'

export class Api {
	constructor(options) {
		this.apiUrl = env.apiUrl
		this.prefix = ''
		this.token = env.token
		if (!!options) {
			this.token = options.token
		}
	}

	/**
	 * Get full url.
	 *
	 * @param {null|string} uri
	 *
	 * @return {string} Generated url
	 */
	getUrl = (uri = null) => {
		const apiUrl = `${this.apiUrl}/api`
		if (uri === null) return `${apiUrl}${this.prefix}`
		else if (uri.length > 0 && uri[0] === '/') return `${apiUrl}${uri}`
		else if (uri.length > 4 && uri.substring(0, 4) === 'http') return uri
		else if (uri.length > 0 && uri[0] === '?')
			return `${apiUrl}${this.prefix}${uri}`
		else return `${apiUrl}${this.prefix}/${uri}`
	}

	/**
	 * Build query string with given params.
	 *
	 * @param {array} params Query params
	 *
	 * @return {string} Builded query string
	 */
	buildQueryString = params => {
		if (params === null) return ''
		if (Object.keys(params).length === 0 && params.constructor === Object)
			return ''
		return (
			'?' +
			Object.keys(params)
				.map(name => `${name}=${encodeURIComponent(params[name])}`)
				.join('&')
		)
	}

	/**
	 * Returns GET headers for JSON request.
	 */
	getJsonHeaders = () => {
		return {
			Accept: `application/json`
		}
	}

	/**
	 * Returns POST headers for JSON request.
	 */
	postJsonHeaders = () => {
		return {
			Accept: `application/json`,
			'Content-Type': `application/json`
		}
	}

	/**
	 * Returns GET headers for authentificated JSON request.
	 */
	getAuthedJsonHeaders = () => {
		if (!this.token) {
			return this.postJsonHeaders()
		}
		return {
			Accept: `application/json`,
			Authorization: `Bearer ${this.token}`
		}
	}

	/**
	 * Returns POST headers for authentificated JSON request.
	 */
	postAuthedJsonHeaders = () => {
		if (!this.token) {
			return this.postJsonHeaders()
		}
		return {
			Accept: `application/json`,
			'Content-Type': `application/json`,
			Authorization: `Bearer ${this.token}`
		}
	}

	/**
	 * Returns multipart headers for authentificated JSON request.
	 */
	multipartAuthedJsonHeaders = () => {
		if (!this.token) return this.postJsonHeaders()
		return {
			Authorization: `Bearer ${this.token}`
		}
	}

	/**
	 * Handle status for executed response.
	 */
	handleStatus = async response => {
		//	http://stackoverflow.com/questions/3297048/403-forbidden-vs-401-unauthorized-http-responses
		//  401 - no token/invalid token for something that needs auth
		//  403 - have token, but that's still not something you're allowed to touch
		if (response.ok) {
			return await response.json()
		}
		switch (response.status) {
			case 400:
				const json = await response.json()
				throw new Error(json.message || response.statusText)
			case 401:
				throw new Error(`Your login is invalid`)
			case 403:
				throw new Error(`Sorry, you are not allowed access`)
			case 404:
				return null
			case 413:
				throw new Error(`File size is too big`)
			case 500:
				throw new Error(`Server had an issue`)
			default:
				throw new Error(response.statusText)
		}
	}
}
