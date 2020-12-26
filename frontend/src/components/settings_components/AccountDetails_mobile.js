import React, { Component } from 'react'
import { getUserData,changeDetails } from './UserFunctions'
import Table from 'react-bootstrap/Table'
import { Form ,Button,Alert } from 'react-bootstrap';

class AccountDetails_mobile extends Component {
    state = {
        step: 1,
        firstName: '',
        lastName: '',
        address1:'',
        address2:'',
        city: '',
        language: '',
        phoneNo:'',
        email: '',
        municipalCouncil: '',
        prevDetails: null,
        displayRow : 0,
        validInput: true,
        invalidMsg: '',
    };

    handleChange = input => e => {
        this.setState({
           [input]: e.target.value
        });
     }


   handleUserData = () => {
        getUserData().then(res => {
            if (res.statusCode==='S2000') {
                this.setState({prevDetails: res});
                this.setState({firstName: res.firstName});
                this.setState({lastName: res.lastName});
                this.setState({phoneNo: res.phone});
                this.setState({email: res.email});
                this.setState({address1: res.address.address1});
                this.setState({address2: res.address.address2});
                this.setState({city: res.address.city});
                this.setState({municipalCouncil: res.address.municipalCouncil});
                this.setState({language: res.language});
            }
            else {
                this.setState({validInput: false, invalidMsg: res.error});
            }
        }).catch(err => {
            console.log(err)
        })
    }

    componentDidMount(){
        this.handleUserData();
    }
    displayRow = row => {
        this.setState({displayRow: row});
    }

    changeName = e => {
        this.setState({
            firstName: e.target[0].value,
            lastName: e.target[1].value
         });
         this.displayRow(0)
    }

    changeAddress = e => {
        this.setState({
            address1: e.target[0].value,
            address2: e.target[1].value,
            city: e.target[2].value,
         });
         this.displayRow(0)
    }
    changeMunicipal = e => {
        this.setState({
            municipalCouncil: e.target[0].value,
        });
        this.displayRow(0)
    }

    changeLanguage = e => {
        this.setState({
            language: e.target[0].value,
        });
        this.displayRow(0)
    }

    resetChanges = e => {
        let res = this.state.prevDetails;
        this.setState({firstName: res.firstName});
        this.setState({lastName: res.lastName});
        this.setState({phoneNo: res.phone});
        this.setState({email: res.email});
        this.setState({address1: res.address.address1});
        this.setState({address2: res.address.address2});
        this.setState({city: res.address.city});
        this.setState({municipalCouncil: res.address.municipalCouncil});
        this.setState({language: res.language});
    }

    applyChanges = e => {
        e.preventDefault();

        const {firstName, lastName, address1, address2, city, municipalCouncil,language} = this.state;
        const customer = {
           firstName: firstName,
           lastName: lastName,
           address1: address1,
           address2: address2,
           city: city,
           language: language,
           municipalCouncil: municipalCouncil,
        }
        console.log(customer);
        changeDetails(customer).then(res => {
           if (res) {
              let statusCode = res.statusCode;
              console.log(statusCode);
              if(statusCode === 'S2000'){
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
        
    }

    nextStep = step => {
        this.props.nextStep(step);
    }

    render() {

        const { validInput,invalidMsg,firstName,lastName, municipalCouncil,language ,displayRow,address1,address2,city} = this.state;

        const msg = (
            <div class="alert alert-danger" role="alert">
               {invalidMsg}
            </div>
         )

        const updateName = (
            <tr className = "hidden_rows">
                <td>
                <Form onSubmit = {e => this.changeName(e)}>
                    <Form.Group >
                        <Form.Label>First Name</Form.Label>
                        <Form.Control className = "input" type="text"  placeholder={firstName} required/>
                    </Form.Group>
                    <Form.Group >
                        <Form.Label>Last Name</Form.Label>
                        <Form.Control className = "input" type="text" placeholder={lastName} required/>
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

        const updataAddress = (
            <tr className = "hidden_rows">
                <td>
                <Form onSubmit = {e => this.changeAddress(e)}>
                    <Form.Group >
                        <Form.Label>Address 1</Form.Label>
                        <Form.Control className = "input" type="text" placeholder={address1} required/>
                    </Form.Group>
                    <Form.Group >
                        <Form.Label>Address 2</Form.Label>
                        <Form.Control className = "input" type="text" placeholder={address2} required/>
                    </Form.Group>
                    <Form.Group >
                        <Form.Label>City</Form.Label>
                        <Form.Control className = "input" type="text" placeholder={city} required/>
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
        const updateMunicipal = (
            <tr className = "hidden_rows">
                <td>
                <Form onSubmit = {e => this.changeMunicipal(e)}>
                    <Form.Group>
                        <Form.Label>Municipal Council</Form.Label>
                        <Form.Control className = 'react-select' as="select" placeholder={municipalCouncil} required>
                            <option>Colombo</option>
                            <option>Kandy</option>
                            <option>Bandarawela</option>
                        </Form.Control>
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

        const updateLanguage = (
            <tr className = "hidden_rows">
            <td>
            <Form onSubmit = {e => this.changeLanguage(e)}>
                <Form.Group>
                    <Form.Label>Language</Form.Label>
                    <Form.Control className = 'react-select' as="select" placeholder={language} required>
                        <option>Sinhala</option>
                        <option>English</option>
                    </Form.Control>
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
                    <h4>Account Details</h4>
                </div>
                <tbody>
                    <tr onClick={ () => this.displayRow(1) }>
                        <td>Change name</td>
                    </tr>
                    {(displayRow == 1)? updateName : null}
                    <tr onClick={ () => this.displayRow(2) }>
                        <td>Change address</td>
                    </tr>
                    {(displayRow == 2)? updataAddress : null}
                    <tr onClick={ () => this.displayRow(4) }>
                        <td>Change language</td>
                    </tr>
                    {(displayRow == 4)? updateLanguage : null}
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
                            <Button variant="success" onClick = {e => this.applyChanges(e)} type="submit" block>
                                Apply Changes
                            </Button>
                            <Button variant="light" onClick={ () => this.resetChanges() } block>
                                Reset
                            </Button>
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

export default AccountDetails_mobile;
