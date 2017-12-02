import {
	success as NotificationsSuccess,
	error as NotificationsError,
	warning as NotificationsWarning,
	info as NotificationsInfo
} from 'react-notification-system-redux'

const defaults = {
	position: `tr`,
	autoDismiss: 5
}

const options = params => {
	const options = typeof params === `string` ? { message: params } : params
	return { ...defaults, ...options }
}

export const success = params => {
	return NotificationsSuccess(options(params))
}

export const error = params => {
	return NotificationsError(options(params))
}

export const warning = params => {
	return NotificationsWarning(options(params))
}

export const info = params => {
	return NotificationsInfo(options(params))
}
