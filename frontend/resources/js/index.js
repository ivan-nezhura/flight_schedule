import React from 'react';
import ReactDOM from 'react-dom';
import AppContainer from './AppContainer';

import 'bootstrap/dist/css/bootstrap.min.css'
import "react-datepicker/dist/react-datepicker.css";


ReactDOM.render(
    <AppContainer airports={window.airports}/>,
    document.getElementById('app-root')
);


