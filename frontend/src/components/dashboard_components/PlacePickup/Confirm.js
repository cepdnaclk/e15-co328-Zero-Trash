import React, { Component } from 'react';
import { Button, Form, Card, Alert} from 'react-bootstrap';
import { newPickup } from './../UserFunctions';

class Confirm extends Component {
   state = {
      validInput: true,
      invalidMsg: '',
   }

   getPickupTime(timeState){
      switch(timeState) {
         case '8':
         return ('8:00 a.m. - 10:00 a.m.');
         case '10':
         return ('10:00 a.m. - 12:00 p.m.');
         case '12':
         return '12:00 p.m. - 2:00 p.m.';
         case '14':
         return ('2:00 p.m. - 4:00 p.m.');
         case '16':
         return ('4:00 p.m. - 6:00 p.m.');
         case '18':
         return ('6:00 p.m. - 8:00 p.m.');
      }
   }

   continue = e => {
      e.preventDefault();

      const { values: {phoneNo, time, address,date} } = this.props;
      const pickup = {
         phoneNo: phoneNo,
         time: time,
         address: address,
         date: date,
      }

      newPickup(pickup).then(res => {
         if (res) {
            let statusCode = res.statusCode;
            if(statusCode === 'S2000'){
               //if(statusCode){
               console.log('Success')
               this.setState({validServer :true});
               window.location.href = '/home';
            }
            else {
               //console.log('err');
               this.setState({validInput: false, invalidMsg: res.error});
            }
         }
         else{
            console.log('Error')
         }
      })
   }

   back = e => {
      e.preventDefault();
      this.props.prevStep();
   }

   render(){
      const { values: {phoneNo, address, time} } = this.props;
      const { validInput,invalidMsg} = this.state;

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
                     Confirm Pickup
                  </Card.Title>
                  <Form.Group>
                     <Form.Label>Mobile Number</Form.Label>
                     <Form.Control type="text" value = {phoneNo} readOnly/>
                  </Form.Group>
                  <Form.Group>
                        <Form.Label>Address</Form.Label>
                        <Form.Control as="textarea" rows='3' value = {address} readOnly/>
                  </Form.Group>
                  <Form.Group>
                     <Form.Label>Pickup Time</Form.Label>
                     <Form.Control type="text" value = {this.getPickupTime(time)} readOnly/>
                  </Form.Group>
                  <br/>
                  {validInput? null : msg}
                  <Button variant="success" type="submit" block>
                     Confirm
                  </Button>
                  <Button variant="light" onClick = {this.back} block>
                     Back
                  </Button>
               </Card.Body>
            </Form>
         </Card>
      )
   }
}

export default Confirm;
