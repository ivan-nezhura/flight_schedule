import React from 'react'
import PropTypes from 'prop-types'
import {Row, Col, Table} from 'reactstrap'


const AppForm = ({errorText, results}) => (
    <Row>
        {errorText && <Col><h3 className="text-danger text-center">{errorText}</h3></Col>}

        {
            results.length > 0 && (
                <Col xs={12}>
                    <Table>
                        <thead>
                            <tr>
                                <th>Transporter</th>
                                <th>Flight number</th>
                                <th>Departure</th>
                                <th>Arrival</th>
                                <th>Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                        {
                            results.map(r => (
                                <tr key={r.flightNumber + r.departureDateTime}>
                                    <td>{r.transporter.name}</td>
                                    <td>{r.flightNumber}</td>
                                    <td>{r.departureDateTime}</td>
                                    <td>{r.arrivalDateTime}</td>
                                    <td>{r.duration}</td>
                                </tr>
                            ))
                        }
                        </tbody>
                    </Table>
                </Col>
            )
        }
    </Row>
)

AppForm.propTypes= {
    errorText: PropTypes.string,
    results: PropTypes.array
};

export default AppForm