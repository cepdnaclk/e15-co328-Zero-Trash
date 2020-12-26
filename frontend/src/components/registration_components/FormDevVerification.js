import React, { Component } from 'react';
import { Button, Form,Card, Alert } from 'react-bootstrap';
import { devVerification } from './UserFunctions';

class FormDevVerification extends Component {
   state = {
      token: '',
      validInput: true,
      validToken: true
   }

   handleChange = input => e => {
      this.setState({
         [input]: e.target.value
      });
   }

   continue = e => {
      e.preventDefault();

      const customer = {
         token: this.state.token,
         phoneNo: this.props.values.phoneNo
      }

      devVerification(customer).then(res => {
         if (res) {
            console.log(res.statusCode);
            let statusCode = res.statusCode;
            if(statusCode === 'S1000'){
               this.setState({validToken: true, validInput : true});
               this.props.nextStep();
            }
            else if(statusCode === 'E3002'){
               this.setState({validToken: false, validInput : true});
            }
            else{
               this.setState({validToken: true, validInput : false});
            }
         }
         else{
            this.setState({validInput: false});
         }
      })
   }

   back = e => {
      e.preventDefault();
      this.props.prevStep();
   }

   render() {
      const { validInput, validToken } = this.state;

      const invalidInputMsg = (
         <Alert variant='danger'>
            Server Error. Please try again later!
         </Alert>
      )

      const invalidTokenMsg = (
         <Alert variant='danger'>
            Incorrect verification code!
         </Alert>
      )

      return (

         <Card>
            <Form onSubmit = {e => this.continue(e)}>
               <Card.Body>
                  <Card.Title className='text-center'>
                     Mobile number verification
                  </Card.Title>
                  <Form.Group>
                     <Form.Label>Device Verification Code</Form.Label>
                     <Form.Control type="text" placeholder="" value={this.state.token} onChange = {this.handleChange('token')} required/>
                     <Form.Text className="text-muted">
                        Do not share this code with anyone else
                     </Form.Text>
                  </Form.Group>
                  <br />
                  <Card.Text>
                     The device verification code has been sent to you when you registering to the Collector app via SMS. (Use the token 100100 for demo accounts). 
                  </Card.Text>
                  {validInput? (validToken? null : invalidTokenMsg) : invalidInputMsg}
                  <Button variant="success" type="submit" block>
                     Verify & Continue
                  </Button>
                  <Button variant="light" onClick = {this.back} block>
                     Back
                  </Button>
               </Card.Body>
            </Form>
         </Card>
      );
   }
}

export default FormDevVerification;
