import React from 'react'
import PropTypes from 'prop-types'
import {Row, Col, Input} from 'reactstrap'
import DatePicker from "react-datepicker";
import moment from "moment";


const AppForm = ({arrivalAirport, departureAirport, departureDate, airports, onChange}) => (
    <Row className={'my-3'}>
        <Col xs={5}>
            <Input
                type={'select'}
                onChange={({target}) => onChange('departureAirport', target.value)}
                value={departureAirport}
            >

                <option value="">Departure airport</option>
                {
                    airports.map(a => <option key={a.code} value={a.code}>{a.name} ({a.utc_offset})</option>)
                }

            </Input>
        </Col>
        <Col xs={5} className={'text-center'}>
            <Input
                type={'select'}
                onChange={({target}) => onChange('arrivalAirport', target.value)}
                value={arrivalAirport}
            >

                <option value="">Arrival airport</option>
                {
                    airports.map(a => <option key={a.code} value={a.code}>{a.name} ({a.utc_offset})</option>)
                }

            </Input>
        </Col>
        <Col xs={2} className={'text-center'}>
            <DatePicker
                popperPlacement={'top'}
                className="form-control"
                placeholderText="Pick date"
                value={departureDate}
                onChange={val => onChange('departureDate', moment(val).format('YYYY-MM-DD'))}
            />
        </Col>
        <Col><hr/></Col>
    </Row>
)

const airportShape = {
    code: PropTypes.string.isRequired,
    name: PropTypes.string.isRequired,
    utc_offset: PropTypes.string.isRequired,
};

AppForm.propTypes= {
    airports: PropTypes.arrayOf(PropTypes.shape(airportShape)).isRequired,
    departureAirport: PropTypes.string.isRequired,
    arrivalAirport: PropTypes.string.isRequired,
    departureDate: PropTypes.string.isRequired,
    onChange: PropTypes.func.isRequired
};

export default AppForm