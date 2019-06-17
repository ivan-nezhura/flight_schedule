import React from 'react'
import PropTypes from 'prop-types'
import {Container} from 'reactstrap'
import axios from 'axios'

import AppForm from './components/AppForm'
import AppResults from './components/AppResults'

class AppContainer extends React.Component{
    constructor(props, context) {
        super(props, context);

        this.state = {
            departureAirport: '',
            arrivalAirport: '',
            departureDate: '',
            errorText: '',
            results: [],
        };
    }

    onChangeSelection(field, value) {
        this.setState(
            {[field]: value, results: []},
            () => this.fetchFlights()
        )
    }

    fetchFlights() {
        const {departureAirport, arrivalAirport, departureDate} = this.state;

        if (!departureAirport || !arrivalAirport || !departureDate) {
            return;
        }

        const params = {
            r: 'schedule/search',
            expand: 'transporter',
            departureDate,
            departureAirport,
            arrivalAirport
        };

        axios
            .get('http://127.0.0.1:21080/index.php?r=flight/search', {params})
            .then(response => this.setState({errorText: '', results: response.data.searchResults}))
            .catch(err => this.setState({errorText: err.response.data.message, results: []}))
    }

    render(){
        const {airports} = this.props;

        return (
            <Container>
                <AppForm
                    airports={airports}
                    onChange={(field, value) => this.onChangeSelection(field, value)}
                    {...this.state}
                />
                <AppResults
                    {...this.state}
                />
            </Container>
        );
    }
}

const airportShape = {
    code: PropTypes.string.isRequired,
    name: PropTypes.string.isRequired,
    utc_offset: PropTypes.string.isRequired,
};

AppContainer.propTypes= {
    airports: PropTypes.arrayOf(PropTypes.shape(airportShape)).isRequired
};

export default AppContainer