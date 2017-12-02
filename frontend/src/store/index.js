switch (process.env.NODE_ENV) {
	case 'development':
		module.exports = require('./configureStore.dev')
		break
	case 'production':
		module.exports = require('./configureStore.prod')
		break
	default:
		break
}
