import React, { Component } from "react";
import { Button, Form,Card } from 'react-bootstrap';

export class FormPersonalDetails extends Component {

   state = {
      validEmail: true,
      validPhoneNo: true,
   }

   continue = e => {
      e.preventDefault();

      const {phoneNo, email} = this.props.values

      let allow = true;
      if(!this.validatePhoneNo(phoneNo)) {
         this.setState({
            validPhoneNo: false
         });
         allow = false;
      }
      else{
         this.setState({
            validPhoneNo: true
         });
      }
      if(!this.validateEmail(email)) {
         this.setState({
            validEmail: false
         });
         allow = false;
      }
      else{
         this.setState({
            validEmail: true
         });
      }
      if(allow){
         this.props.nextStep();
      }
   }

   back = e => {
      e.preventDefault();
      this.props.prevStep();
   }

   validatePhoneNo(phoneNo) {

      let regPhoneNo = /^07\d{8}$/;
      if(phoneNo.match(regPhoneNo)) {
         return true;
      }
      return false;

   }

   validateEmail(email) {
      let regEmail =  /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      if(email.match(regEmail)) {
         return true
      }
      return false
   }


   render() {

      const { values,handleChange } = this.props;
      const {validEmail, validPhoneNo} = this.state;

      const invalidPhoneNoMsg = (
         <Form.Text className="text-muted text-alert">
            Invalid phone No
         </Form.Text>
      )
      const invalidEmailMsg = (
         <Form.Text className="text-muted text-alert">
            Invalid email address
         </Form.Text>
      )

      const invalidClass = 'is-invalid';

      return (
         <Card>
            <Form onSubmit = {e => this.continue(e)}>
               <Card.Body>
                  <Card.Title className='text-center'>
                     Sign Up
                  </Card.Title>
                  <Form.Group >
                     <Form.Label>First Name</Form.Label>
                     <Form.Control type="text"  value = {values.firstName} onChange = {handleChange('firstName')} placeholder="Enter first name" required/>
                  </Form.Group>
                  <Form.Group >
                     <Form.Label>Last Name</Form.Label>
                     <Form.Control type="text" value = {values.lastName} onChange = {handleChange('lastName')} placeholder="Enter last name" required />
                  </Form.Group>
                  <Form.Group>
                     <Form.Label>Mobile Number</Form.Label>
                     <Form.Control type="text" className = {validPhoneNo ? null : invalidClass} value = {values.phoneNo} onChange = {handleChange('phoneNo')} placeholder="Enter mobile number" required/>
                     {validPhoneNo ? null : invalidPhoneNoMsg}
                  </Form.Group>
                  <Form.Group>
                     <Form.Label>Email</Form.Label>
                     <Form.Control type="text" className = {validEmail ? null : invalidClass} value = {values.email} onChange = {handleChange('email')} placeholder="Enter email" required/>
                     {validEmail ? null : invalidEmailMsg}
                  </Form.Group>
                  <br />
                  <Button variant="success" type="submit" block>
                     Continue
                  </Button>
                  <Button variant="light" onClick ={this.back} block>
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

export default FormPersonalDetails;
