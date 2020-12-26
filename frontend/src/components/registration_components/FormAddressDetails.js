import React, { Component } from "react";
import { Button, Form,Card } from 'react-bootstrap';

export class FormAddressDetails extends Component {

    continue = e => {
        e.preventDefault();
        this.props.nextStep();
    }

    back = e => {
        e.preventDefault();
        this.props.prevStep();
    }


    render() {

        const { values,handleChange } = this.props;

        return (
            <Card>
                <Form onSubmit = {e => this.continue(e)}>
                    <Card.Body>
                        <Card.Title className='text-center'>
                        Sign Up
                        </Card.Title>
                        <Form.Group>
                            <Form.Label>Address 1</Form.Label>
                            <Form.Control type="text"  value = {values.address1} onChange = {handleChange('address1')} placeholder="address 1" required/>
                        </Form.Group>
                        <Form.Group>
                            <Form.Label>Address 2</Form.Label>
                            <Form.Control type="text"  value = {values.address2} onChange = {handleChange('address2')} placeholder="address 2" required />
                        </Form.Group>
                        <Form.Group>
                            <Form.Label>City</Form.Label>
                            <Form.Control type="text" value = {values.city} onChange = {handleChange('city')} placeholder="City" required/>
                        </Form.Group>
                        <Form.Group>
                            <Form.Label>Municipal Council</Form.Label>
                            <Form.Control as="select" value = {values.municipalCouncil} onChange = {handleChange('municipalCouncil')} required>
                                <option>Colombo</option>
                                <option>Kandy</option>
                                <option>Bandarawela</option>
                                <option>Gampola</option>
                                <option>Rathnapura</option>
                                <option>Nugegoda</option>
                                <option>Malambe</option>
                                <option>Galle</option>
                                <option>Kadawatha</option>
                                <option>Battaramulla</option>
                                <option>Badulla</option>
                            </Form.Control>
                        </Form.Group>
                        <br />
                        <Button variant="success" type="submit" block>
                            Continue
                        </Button>
                        <Button variant="light" onClick = {this.back} block>
                            Back
                        </Button>
                        <Card.Text>
                            Already have an account?&ensp;<a href="#">Login Here!</a>
                        </Card.Text>
                    </Card.Body>
                </Form>
            </Card>
        );
    }
}

export default FormAddressDetails;
