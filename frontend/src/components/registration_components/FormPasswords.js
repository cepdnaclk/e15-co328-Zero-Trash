import React, { Component } from "react";
import { Button, Form,Card } from 'react-bootstrap';

export class FormPasswords extends Component {

   state = {
      validPassword: true,
      validConfirmPassword: true
   }

   continue = e => {
      e.preventDefault();

      const {password, confirmPassword} = this.props.values

      let allow = true;
      if(!this.validatePassword(password)) {
         this.setState({
            validPassword: false
         });
         allow = false;
      }
      else{
         this.setState({
            validPassword: true
         });
      }
      if(password !== confirmPassword) {
         this.setState({
            validConfirmPassword: false
         });
         allow = false;
      }
      else{
         this.setState({
            validConfirmPassword: true
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

   //password length must be [7,15], Must contain at least one numeric digit and a special character
   validatePassword(password) {

      let regPassword=  /^(?=.*[0-9])[a-zA-Z0-9]{7,15}$/;
      if(password.match(regPassword)) {
         console.log('Correct'+ password)
         return true;
      }
      console.log('Incorrect' + password)
      return false;
   }

   render() {

      const { values,handleChange } = this.props;
      const {validPassword, validConfirmPassword } = this.state;

      const invalidPasswordMsg = (
         <Form.Text className="text-muted text-alert">
            Password must contain 7 to 15 characters including atleast 1 numeric
            character.
         </Form.Text>
      )

      const invalidConfirmPasswordMsg = (
         <Form.Text className="text-muted text-alert">
            Passwords do not match.
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
                  <Form.Group>
                     <Form.Label>Password</Form.Label>
                     <Form.Control type="password" className = {validPassword ? null : invalidClass} value = {values.password} onChange = {handleChange('password')} placeholder="Enter Password" required/>
                     {validPassword ? null : invalidPasswordMsg}
                  </Form.Group>
                  <Form.Group>
                     <Form.Label>Confirm Password</Form.Label>
                     <Form.Control type="password" className = {validPassword ? null : invalidClass} value = {values.confirmPassword} onChange = {handleChange('confirmPassword')} placeholder="Confirm Password" required />
                     {validConfirmPassword ? null : invalidConfirmPasswordMsg}
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

export default FormPasswords;
