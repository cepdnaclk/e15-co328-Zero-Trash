import React, { Component } from 'react';
import { Button, Form, Card} from 'react-bootstrap';

class FormPickupDetails extends Component {
   state = {
      validPhoneNo: true,
   }

   continue (e) {

      const {phoneNo} = this.props.values
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
      if(allow){
         this.props.nextStep();
      }
   }

   validatePhoneNo(phoneNo) {
      let regPhoneNo = /^07\d{8}$/;
      if(phoneNo.match(regPhoneNo)) {
         return true;
      }
      return false;
   }

   render(){

      const {values,handleChange} = this.props;
      const {validPhoneNo } = this.state;
      const invalidClass = 'is-invalid';

      const invalidPhoneNoMsg = (
         <Form.Text className="text-muted text-alert">
            Invalid phone No
         </Form.Text>
      )

      return (
         <Card>
            <Form onSubmit = {e => this.continue(e)}>
               <Card.Body>
                  <Card.Title className='text-center'>
                     Shedule a pickup
                  </Card.Title>
                  <Form.Group>
                     <Form.Label>Mobile Number</Form.Label>
                     <Form.Control data-testid="phoneNo" type="text" className = {validPhoneNo ? null : invalidClass} defaultValue = {values.phoneNo} onChange = {handleChange('phoneNo')} required/>
                     {validPhoneNo ? null : invalidPhoneNoMsg}
                  </Form.Group>
                  <Form.Group>
                     <Form.Label>Address</Form.Label>
                     <Form.Control data-testid="address" as="textarea" rows='3' defaultValue={values.address} onChange = {handleChange('address')} required/>
                     <Form.Text className="text-muted text-alert">
                        Your services are limited to {values.municipalCouncil} municipal council.
                     </Form.Text>
                  </Form.Group>
                  <Form.Group >
                     <Form.Label>Pickup Time</Form.Label>
                     <Form.Control as="select"  required="required" value={values.time} onChange = {handleChange('time')}>
                        <option hidden value=''>8:00 a.m. - 10:00 a.m.</option>
                        <option value='8'>8:00 a.m. - 10:00 a.m.</option>
                        <option value='10'>10:00 a.m. - 12:00 p.m.</option>
                        <option value='12'>12:00 p.m. - 2:00 p.m.</option>
                        <option value='14'>2:00 p.m. - 4:00 p.m.</option>
                        <option value='16'>4:00 p.m. - 6:00 p.m.</option>
                        <option value='18'>6:00 p.m. - 8:00 p.m.</option>
                     </Form.Control>
                  </Form.Group>
                  <br />
                  <Button variant="success" type="submit" block>
                     Continue
                  </Button>
               </Card.Body>
            </Form>
         </Card>
      )
   }

}

export default FormPickupDetails;
