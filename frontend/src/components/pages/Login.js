import React, { Component } from "react";
import { login,setUserToken } from './../registration_components/UserFunctions';
import { Button, Form, Card,Alert } from 'react-bootstrap';

class Login extends Component {

   state = {
      username: '',
      password: '',
      validInput: true,
      invalidMsg: '',
      rememberMe: false,
   }

   handleChange = input => e => {
      this.setState({
         [input]: e.target.value
      });
   }

   continue = e => {
      e.preventDefault();

      const {username, password, rememberMe } = this.state;
      let customer = {};
      if(Number.isInteger(parseInt(username))){
         console.log('Number is integer')
         customer = {
            phoneNo: username,
            email: 'null',
            password: password
         }
      }
      else{
         console.log('Number is not integer')
         customer = {
            phoneNo: 'null',
            email: username,
            password: password
         }
      }
      login({customer,rememberMe}).then(res => {
         if (res) {
            let statusCode = res.statusCode;
            console.log(statusCode);
            if(statusCode === 'S2000'){
               console.log(res.authToken);
               //localStorage.setItem('usertoken', res.authToken);
               setUserToken(res.authToken);
               this.setState({validInput: true});
               window.location.href = '/home';
            }
            else {
               this.setState({validInput: false, invalidMsg: res.error});
            }
         }
         else {
            console.log('Error');
         }
      })
   }

   radioButtonChange = e => {
      console.log('Radio button Changed: '+ e.target.checked);
      if(e.target.checked){
         this.setState({ rememberMe: true });
      }
      else{
         this.setState({ rememberMe: false });
      }
   }

   render() {
      const values = this.state;

      const msg = (
         <div class="alert alert-danger" role="alert">
            {values.invalidMsg}
         </div>
      )

      return (
         <Card data-testid="login-form">
            <Form onSubmit = {e => this.continue(e)}>
               <Card.Body>
                  <Card.Title className='text-center'>
                     Sign In
                  </Card.Title>
                  <Form.Group >
                     <Form.Label>Mobile number or Email</Form.Label>
                     <Form.Control type="text"  value = {values.username} onChange = {this.handleChange('username')} placeholder="Enter mobile number or email" required/>
                  </Form.Group>
                  <Form.Group >
                     <Form.Label>Password</Form.Label>
                     <Form.Control type="password" value = {values.password} onChange = {this.handleChange('password')} placeholder="Enter password" required />
                  </Form.Group>
                  <br />
                  {values.validInput? null : msg}
                  <Button variant="success" type="submit" block>
                     Continue
                  </Button>
                  <Card.Text>
                     forgot&ensp;<a href="#">password?</a>
                  </Card.Text>
                  <Card.Text>
                     new to Zero Trash?&ensp;<a href="/register">Register Here!</a>
                  </Card.Text>
               </Card.Body>
            </Form>
         </Card>
      );
   }
}

export default Login;
