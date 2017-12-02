import React, { Component } from 'react'
import { connect } from 'react-redux'
import { bindActionCreators } from 'redux'
import { Link, Route } from 'react-router-dom'
import classnames from 'classnames'
import moment from 'moment'
import {
	Button,
	Confirm,
	Container,
	Form,
	Input,
	Menu,
	Modal,
	Segment,
	Select,
	Table
} from 'semantic-ui-react'

import SearchForm from 'components/SearchForm'

import * as ordersActions from 'actions/orders'
import * as productsActions from 'actions/products'
import * as usersActions from 'actions/users'

class Orders extends Component {
	componentWillMount() {
		this.props.usersActions.loadUsers()
		this.props.productsActions.loadProducts()
		this.props.ordersActions.loadOrders(
			this.props.orders.search.periodValue,
			this.props.orders.search.searchText
		)
	}

	renderNewOrder = ({ match }) => {
		const { url } = this.props.match
		const { search } = this.props.location
		return (
			<Modal
				open={true}
				size="tiny"
				closeOnDimmerClick={true}
				closeOnDocumentClick={true}
				onClose={() => {
					this.props.ordersActions.setOrder(null)
					this.props.history.push(`${url}${search}`)
				}}
			>
				<Modal.Header>Add new order</Modal.Header>
				<Modal.Content image>
					<Modal.Description>
						<Form>
							<Form.Field>
								<label>User</label>
								<Select
									placeholder="Select user"
									options={this.props.users.users.map(user => ({
										key: user.id,
										value: user.id,
										text: user.username
									}))}
									onChange={(ev, { value }) => {
										this.props.ordersActions.setOrder({
											...this.props.orders.order,
											user: this.props.users.users.find(
												user => user.id === value
											)
										})
									}}
								/>
							</Form.Field>
							<Form.Field>
								<label>Product</label>
								<Select
									placeholder="Select product"
									options={this.props.products.products.map(product => ({
										key: product.id,
										value: product.id,
										text: product.name
									}))}
									onChange={(ev, { value }) => {
										this.props.ordersActions.setOrder({
											...this.props.orders.order,
											product: this.props.products.products.find(
												product => product.id === value
											)
										})
									}}
								/>
							</Form.Field>
							<Form.Field>
								<label>Quantity</label>
								<Input
									placeholder="Quantity"
									type="number"
									onChange={(ev, { value }) => {
										this.props.ordersActions.setOrder({
											...this.props.orders.order,
											quantity: parseInt(value, 10)
										})
									}}
								/>
							</Form.Field>
							{!!this.props.orders.order.error && (
								<Form.Field>
									<Segment color="red">{this.props.orders.order.error}</Segment>
								</Form.Field>
							)}
							<Button
								type="submit"
								disabled={this.props.orders.order.isSubmitting}
								onClick={this.props.ordersActions.saveOrder}
							>
								{this.props.orders.order.isSubmitting
									? 'Please, wait...'
									: 'Save'}
							</Button>
						</Form>
					</Modal.Description>
				</Modal.Content>
			</Modal>
		)
	}

	renderEditOrder = ({ match }) => {
		const { url } = this.props.match
		const { search } = this.props.location
		return (
			<Modal
				open={true}
				size="tiny"
				closeOnDimmerClick={true}
				closeOnDocumentClick={true}
				onClose={() => {
					this.props.ordersActions.setOrder(null)
					this.props.history.push(`${url}${search}`)
				}}
			>
				<Modal.Header>Edit order</Modal.Header>
				<Modal.Content image>
					<Modal.Description>
						<Form>
							<Form.Field>
								<label>User</label>
								<Select
									value={this.props.orders.order.user.id}
									placeholder="Select user"
									options={this.props.users.users.map(user => ({
										key: user.id,
										value: user.id,
										text: user.username
									}))}
									onChange={(ev, { value }) => {
										this.props.ordersActions.setOrder({
											...this.props.orders.order,
											user: this.props.users.users.find(
												user => user.id === value
											)
										})
									}}
								/>
							</Form.Field>
							<Form.Field>
								<label>Product</label>
								<Select
									value={this.props.orders.order.product.id}
									placeholder="Select product"
									options={this.props.products.products.map(product => ({
										key: product.id,
										value: product.id,
										text: product.name
									}))}
									onChange={(ev, { value }) => {
										this.props.ordersActions.setOrder({
											...this.props.orders.order,
											product: this.props.products.products.find(
												product => product.id === value
											)
										})
									}}
								/>
							</Form.Field>
							<Form.Field>
								<label>Quantity</label>
								<Input
									placeholder="Quantity"
									type="number"
									value={this.props.orders.order.quantity}
									onChange={(ev, { value }) => {
										this.props.ordersActions.setOrder({
											...this.props.orders.order,
											quantity: parseInt(value, 10)
										})
									}}
								/>
							</Form.Field>
							{!!this.props.orders.order.error && (
								<Form.Field>
									<Segment color="red">{this.props.orders.order.error}</Segment>
								</Form.Field>
							)}
							<Button
								type="submit"
								disabled={this.props.orders.order.isSubmitting}
								onClick={this.props.ordersActions.saveOrder}
							>
								{this.props.orders.order.isSubmitting
									? 'Please, wait...'
									: 'Save'}
							</Button>
						</Form>
					</Modal.Description>
				</Modal.Content>
			</Modal>
		)
	}

	renderDeleteOrder = ({ match }) => {
		return (
			<Confirm
				open={true}
				content="Do you want delete this order?"
				onConfirm={() => {
					this.props.ordersActions.deleteOrder(match.params.orderId)
				}}
				onCancel={() => {
					this.props.history.push('/')
				}}
			/>
		)
	}

	render() {
		const isLoading =
			this.props.orders.isLoading || this.props.products.isLoading
		return (
			<Container className="Orders">
				<Menu>
					<Menu.Item
						name="add-order"
						active={false}
						onClick={() => {
							this.props.ordersActions.setOrder({
								id: null,
								user: null,
								product: null,
								quantity: 0,
								price: null,
								total: null
							})
							this.props.history.push('add')
						}}
					>
						New order
					</Menu.Item>
					<Menu.Item
						name="search"
						active={!!this.props.orders.search.active}
						onClick={() => {
							this.props.ordersActions.setSearch({
								active: !this.props.orders.search.active
							})
						}}
					>
						{!!this.props.orders.search.active ? 'Hide search' : 'Search'}
					</Menu.Item>
					<Menu.Item
						className={classnames(
							'Refresh-Button',
							isLoading ? 'disabled' : null
						)}
						onClick={() => {
							this.props.ordersActions.loadOrders(
								this.props.orders.search.periodValue,
								this.props.orders.search.searchText
							)
						}}
					>
						{isLoading ? 'Please, wait...' : 'Refresh'}
					</Menu.Item>
				</Menu>
				{!!this.props.orders.search.active && (
					<SearchForm
						periodValue={this.props.orders.search.periodValue}
						searchText={this.props.orders.search.searchText}
						onChangePeriodValue={periodValue => {
							this.props.ordersActions.setSearch({
								periodValue
							})
						}}
						onChangeSearchText={searchText => {
							this.props.ordersActions.setSearch({
								searchText
							})
						}}
						onSearch={() => {
							this.props.ordersActions.loadOrders(
								this.props.orders.search.periodValue,
								this.props.orders.search.searchText
							)
						}}
					/>
				)}
				{!isLoading && (
					<Table celled>
						<Table.Header>
							<Table.Row>
								<Table.HeaderCell>User</Table.HeaderCell>
								<Table.HeaderCell>Product</Table.HeaderCell>
								<Table.HeaderCell>Price</Table.HeaderCell>
								<Table.HeaderCell>Quantity</Table.HeaderCell>
								<Table.HeaderCell>Total</Table.HeaderCell>
								<Table.HeaderCell>Updated</Table.HeaderCell>
								<Table.HeaderCell>Actions</Table.HeaderCell>
							</Table.Row>
						</Table.Header>
						<Table.Body>
							{this.props.orders.orders.map((order, orderIndex) => (
								<Table.Row key={orderIndex}>
									<Table.Cell>{order.user.username}</Table.Cell>
									<Table.Cell>{order.product.name}</Table.Cell>
									<Table.Cell>{order.price} EUR</Table.Cell>
									<Table.Cell>{order.quantity}</Table.Cell>
									<Table.Cell>{order.total} EUR</Table.Cell>
									<Table.Cell>
										{moment.utc(order.dateUpdated).format('D MMM YYYY, H:mmA')}
									</Table.Cell>
									<Table.Cell>
										<Link
											to={`orders/${order.id}`}
											onClick={() => {
												this.props.ordersActions.setOrder({
													...order,
													error: null
												})
											}}
										>
											Edit
										</Link>{' '}
										<Link to={`orders/${order.id}/delete`}>Delete</Link>
									</Table.Cell>
								</Table.Row>
							))}
						</Table.Body>
					</Table>
				)}
				<Route
					exact={true}
					path="/orders/:orderId/delete"
					render={this.renderDeleteOrder}
				/>
				<Route path="/add" render={this.renderNewOrder} />
				<Route
					exact={true}
					path="/orders/:orderId"
					render={this.renderEditOrder}
				/>
			</Container>
		)
	}
}

export default connect(
	state => ({
		orders: state.orders,
		products: state.products,
		users: state.users
	}),
	dispatch => ({
		ordersActions: bindActionCreators(ordersActions, dispatch),
		productsActions: bindActionCreators(productsActions, dispatch),
		usersActions: bindActionCreators(usersActions, dispatch)
	})
)(Orders)
