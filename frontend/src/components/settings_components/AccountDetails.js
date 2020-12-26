import React, { Component } from 'react'
import { getUserData,changeDetails } from './UserFunctions'
import Table from 'react-bootstrap/Table'
import { Form ,Button,Alert } from 'react-bootstrap';

class AccountDetails extends Component {
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
            this.setState({validInput: true});
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

   }

   render() {

      const { validInput,invalidMsg,firstName,lastName, phoneNo, email, municipalCouncil,language ,displayRow,address1,address2,city} = this.state;
      const full_name = firstName + ' ' + lastName;
      const address = address1+ ' ' + address2+' ' + city;

      const msg = (
         <div class="alert alert-danger" role="alert">
            {invalidMsg}
         </div>
      )

      const updateName = (
         <tr className = "hidden_rows">
            <td></td>
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
                        Review Change
                     </Button>
                     <Button variant="light" onClick={ () => this.displayRow(0) } block>
                        Cancel
                     </Button>
                  </div>
               </Form>
            </td>
            <td></td>
         </tr>
      )

      const updataAddress = (
         <tr className = "hidden_rows">
            <td></td>
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
                        Review Change
                     </Button>
                     <Button variant="light" onClick={ () => this.displayRow(0) } block>
                        Cancel
                     </Button>
                  </div>
               </Form>
            </td>
            <td></td>
         </tr>
      )
      const updateMunicipal = (
         <tr className = "hidden_rows">
            <td></td>
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
                        Review Change
                     </Button>
                     <Button variant="light" onClick={ () => this.displayRow(0) } block>
                        Cancel
                     </Button>
                  </div>
               </Form>
            </td>
            <td></td>
         </tr>
      )

      const updateLanguage = (
         <tr className = "hidden_rows">
            <td></td>
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
                        Review Change
                     </Button>
                     <Button variant="light" onClick={ () => this.displayRow(0) } block>
                        Cancel
                     </Button>
                  </div>
               </Form>
            </td>
            <td></td>
         </tr>
      )


      return (
         <Table striped borderless hover>
            <div className="table-header">
               <h3>Account Details</h3>
            </div>
            <tbody>
               <tr onClick={ () => this.displayRow(1) }>
                  <td id="td-name">Name: </td>
                  <td>{full_name}</td>
                  <td><a href='#' onClick={ () => this.displayRow(1) }>Edit</a></td>
               </tr>
               {(displayRow == 1)? updateName : null}
               <tr id="tr-email">
                  <td>email: </td>
                  <td>{email}</td>
                  <td></td>
               </tr>
               <tr id="tr-phone">
                  <td>Mobile No: </td>
                  <td>{phoneNo}</td>
                  <td></td>
               </tr>
               <tr onClick={ () => this.displayRow(2) }>
                  <td id="td-address">Address: </td>
                  <td>{address}</td>
                  <td><a href='#' onClick={ () => this.displayRow(2) }>Edit</a></td>
               </tr>
               {(displayRow == 2)? updataAddress : null}
               <tr onClick={ () => this.displayRow(3) }>
                  <td id="td-municipal">Municipal Council: </td>
                  <td>{municipalCouncil}</td>
                  <td><a href='#' onClick={ () => this.displayRow(3) }>Edit</a></td>
               </tr>
               {(displayRow == 3)? updateMunicipal : null}
               <tr onClick={ () => this.displayRow(4) }>
                  <td id="td-language">language: </td>
                  <td>{language}</td>
                  <td><a href='#' onClick={ () => this.displayRow(4) }>Edit</a></td>
               </tr>
               {(displayRow == 4)? updateLanguage : null}
            </tbody>
            <tr>
               <td colspan="3">
                  <div className="alert-block">
                     {validInput? null : msg}
                  </div>
               </td>
            </tr>
            <tr>
               <td colspan="3">
                  <div className="btn-block-apply">
                     <Button variant="success" onClick = {e => this.applyChanges(e)} type="submit" block>
                        Apply Changes
                     </Button>
                     <Button variant="light" onClick={ () => this.resetChanges() } block>
                        Reset
                     </Button>
                  </div>
               </td>

            </tr>
         </Table>
      );
   }
}

export default AccountDetails;
