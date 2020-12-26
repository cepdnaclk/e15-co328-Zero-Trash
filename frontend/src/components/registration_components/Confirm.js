import React, { Component } from "react";
import { register } from './UserFunctions';
import { Button, Form,Card, Alert } from 'react-bootstrap';

export class Confirm extends Component {

   state = {
      validInput: true,
      invalidMsg: '',
   }

   continue = e => {
      e.preventDefault();

      const { values: {firstName, lastName, phoneNo, email, customerType, password, address1, address2, city, regDate, language, municipalCouncil} } = this.props;
      const customer = {
         firstName: firstName,
         lastName: lastName,
         phoneNo: phoneNo,
         email: email,
         customerType: customerType,
         password: password,
         address1: address1,
         address2: address2,
         city: city,
         regDate: regDate,
         language: language,
         municipalCouncil: municipalCouncil,
      }
      console.log(customer);
      register(customer).then(res => {
         if (res) {
            let statusCode = res.statusCode;
            console.log(statusCode);
            if(statusCode === 'S2000'){
               console.log('Success')
               this.setState({validInput: true, validServer :true});
               window.location.href = '/login';
            }
            else {
               this.setState({validInput: false, invalidMsg: res.error});
            }
         }
         else{
            console.log('Error');
         }
      })
   }

   back = e => {
      e.preventDefault();
      this.props.prevStep();
   }

   render() {

      const { values: {firstName, lastName, phoneNo, email, address1, address2, city} } = this.props;
      const { validInput, invalidMsg} = this.state;

      const msg = (
         <div class="alert alert-danger" role="alert">
            {invalidMsg}
         </div>
      )

      return (

         <Card>
            <Form onSubmit = {e => this.continue(e)}>
               <Card.Body>
                  <Card.Title className='text-center'>
                     Confirm Information
                  </Card.Title>
                  <Form.Group >
                     <Form.Label>Name</Form.Label>
                     <Form.Control type="text"  value = {firstName + " " + lastName} readOnly/>
                  </Form.Group>
                  <Form.Group >
                     <Form.Label>Email</Form.Label>
                     <Form.Control type="text" value = {email} readOnly />
                  </Form.Group>
                  <Form.Group>
                     <Form.Label>Mobile Number</Form.Label>
                     <Form.Control type="text" value = {phoneNo} readOnly/>
                  </Form.Group>
                  <Form.Group>
                        <Form.Label>Address</Form.Label>
                        <Form.Control as="textarea" rows='3' value = {address1+ "\n"+address2 + "\n" + city} readOnly/>
                  </Form.Group>
                  <br/>
                  {validInput? null : msg}
                  <Button variant="success" type="submit" block>
                     Confirm & Submit
                  </Button>
                  <Button variant="light" onClick = {this.back} block>
                     Back
                  </Button>
                  <Card.Text>
                     Already have an account?&ensp;
                     <a href="#">Login Here!</a>
                  </Card.Text>
               </Card.Body>
            </Form>
         </Card>
      );
   }
}

export default Confirm;
