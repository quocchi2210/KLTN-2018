import React, { Component } from 'react';
import { Button, Form, FormGroup, Label, Input, FormText } from 'reactstrap';

export default class Login extends Component {
    render() {
        return (
            <div className="container">
                <div className="row">
                    <div className="col-md-8 col-md-offset-2">
                        <FormGroup>
                            <Label for="exampleEmail">Email</Label>
                            <Input type="email" name="email" id="Email" placeholder="abc@gmail.com" />
                        </FormGroup>
                        <FormGroup>
                            <Label for="examplePassword">Password</Label>
                            <Input type="password" name="password" id="Password" placeholder="Password" />
                        </FormGroup>
                            <Button color="primary">Danger!</Button>
                        </div>
                    </div>
                </div>

        );
    }
}

