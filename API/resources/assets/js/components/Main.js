import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import Login from './Login.jsx';
import User from './User.jsx';
import 'bootstrap/dist/css/bootstrap.min.css';

if(document.getElementById('login')){
    ReactDOM.render(<Login />, document.getElementById('login'));
}
if(document.getElementById('user')){
    ReactDOM.render(<User />, document.getElementById('user'));
}
class Main extends Component {
    constructor() {

        super();
        //Initialize the state in the constructor
        this.state = {
            users: [],
        }
    }
}

