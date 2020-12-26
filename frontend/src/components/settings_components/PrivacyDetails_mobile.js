import React, { Component } from 'react'
import Table from 'react-bootstrap/Table'
import { changePasswordDetails } from './UserFunctions'
import { Form ,Button,Alert } from 'react-bootstrap';

class PrivacyDetails_mobile extends Component {


    state = {
        displayRow : 0,
        validInput: true,
        invalidMsg: '',
        validPassword: true,
        validConfirmPassword: true
    };

    handleChange = input => e => {
        this.setState({
           [input]: e.target.value
        });
     }

    
    displayRow = row => {
        this.setState({displayRow: row});
    }

    changePassword = e => {
        let oldPassword = e.target[0].value;
        let password = e.target[1].value;
        let confirmPassword = e.target[2].value;

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
        if(allow) {
            e.preventDefault();

            let customer = {
               new: password,
               old: oldPassword
            }
            changePasswordDetails(customer).then(res => {
               if (res) {
                   console.log('arrived');
                  let statusCode = res.statusCode;
                  console.log(statusCode);
                  if(statusCode === 'S1000'){
                     console.log('Success')
                     this.setState({validServer :true});
                     window.location.href = '/home';
                  }
                  else {
                    this.setState({validInput: false, invalidMsg: res.error});
                  }
               }
               else{
                    console.log('error');
               }
            })
            this.displayRow(0)
        }

    }

    validatePassword(password) {

        let regPassword=  /^(?=.*[0-9])[a-zA-Z0-9]{7,15}$/;
        if(password.match(regPassword)) {
           console.log('Correct'+ password)
           return true;
        }
        console.log('Incorrect' + password)
        return false;
     }
     
     nextStep = step => {
        this.props.nextStep(step);
    }
    render() {
        const { validInput,invalidMsg,displayRow,validPassword,validConfirmPassword } = this.state;
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

        const msg = (
            <div class="alert alert-danger" role="alert">
               {invalidMsg}
            </div>
         )
        const invalidClass = 'is-invalid';

        
        const updatePassword = (
            <tr className = "hidden_rows">
            <td>
                <Form onSubmit = {e => this.changePassword(e)}>
                        <Form.Group >
                            <Form.Label>Old Password</Form.Label>
                            <Form.Control type="password" required/>
                        </Form.Group>
                        <Form.Group>
                            <Form.Label>New Password</Form.Label>
                            <Form.Control type="password" className = {validPassword ? null : invalidClass} required/>
                            {validPassword ? null : invalidPasswordMsg}
                        </Form.Group>
                        <Form.Group>
                            <Form.Label>Confirm Password</Form.Label>
                            <Form.Control type="password" className = {validPassword ? null : invalidClass} required />
                            {validConfirmPassword ? null : invalidConfirmPasswordMsg}
                        </Form.Group>
                        <div className="btn-block">
                            <Button variant="success" type="submit" block>
                                Confirm
                            </Button>
                            <Button variant="light" onClick={ () => this.displayRow(0) } block>
                                Cancel
                            </Button>
                        </div>
                </Form>
            </td>
        </tr>
        )


        return (
                <Table striped borderless hover>
                <div className="table-header">
                    <h4>Security & Login</h4>
                </div>
                <tbody>
                    <tr onClick={ () => this.displayRow(1) }>
                        <td>Change Password</td>
                    </tr>
                    {(displayRow == 1)? updatePassword : null}
                </tbody>
                <tr>
                    <td>
                        <div className="alert-block">
                            {validInput? null : msg}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div className="btn-block-apply">
                            <Button variant="light" onClick={ () => this.nextStep(1) }  block>
                                Back
                            </Button>
                        </div>
                    </td>

                </tr>
                </Table>
        );
    }
}

export default PrivacyDetails_mobile;
