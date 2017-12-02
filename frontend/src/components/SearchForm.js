import React, { Component } from 'react'
import PropTypes from 'prop-types'
import { Button, Dropdown, Grid, Input } from 'semantic-ui-react'

export default class NotFound extends Component {
	static propTypes = {
		periodValue: PropTypes.string,
		searchText: PropTypes.string,
		onChangePeriodValue: PropTypes.func.isRequired,
		onChangeSearchText: PropTypes.func.isRequired,
		onSearch: PropTypes.func.isRequired
	}

	render() {
		return (
			<Grid className="Search">
				<Grid.Column width={3} verticalAlign="middle">
					<Dropdown
						selection
						value={this.props.periodValue}
						options={[
							{
								value: 'all-time',
								text: 'All time'
							},
							{
								value: 'last-7-days',
								text: 'Last 7 days'
							},
							{
								value: 'today',
								text: 'Today'
							}
						]}
						onChange={(ev, { value }) => {
							this.props.onChangePeriodValue(value)
						}}
					/>
				</Grid.Column>
				<Grid.Column width={3} verticalAlign="middle">
					<Input
						type="text"
						value={this.props.searchText}
						onChange={(ev, { value }) => {
							this.props.onChangeSearchText(value)
						}}
					/>
				</Grid.Column>
				<Grid.Column width={10}>
					<Button onClick={this.props.onSearch}>Search</Button>
				</Grid.Column>
			</Grid>
		)
	}
}
