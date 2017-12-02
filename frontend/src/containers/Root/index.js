switch (process.env.NODE_ENV) {
	case 'development':
		module.exports = require('./Root.dev')
		break
	case 'production':
		module.exports = require('./Root.prod')
		break
	default:
		break
}
