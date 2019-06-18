import React from 'react';
import ReactDOM from 'react-dom';
import AppContainer from './AppContainer';

import 'bootstrap/dist/css/bootstrap.min.css'
import "react-datepicker/dist/react-datepicker.css";

const username = prompt('Enter your username (for basic http auth):');
const password = prompt('Enter your password (for basic http auth):');

ReactDOM.render(
    <AppContainer airports={window.airports} auth={{username, password}}/>,
    document.getElementById('app-root')
);


