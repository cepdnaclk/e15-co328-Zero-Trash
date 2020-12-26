import React, { Component } from 'react';
import { Button, Form, Card, ButtonGroup, Container, Row, Col } from 'react-bootstrap';

class FormPickupAgree extends Component {

   continue (e) {
      e.preventDefault();
      this.props.nextStep();
   }

   back = e => {
      e.preventDefault();
      this.props.prevStep();
   }
   
   render(){

      return (
         <Card>
            <Form onSubmit = {e => this.continue(e)}>
                  <Card.Body>
                     <Card.Title className='text-center'>
                        Shedule a pickup
                     </Card.Title>
                     <b>Your order will be picked up within 3 days.</b>
                     <Card.Text>
                     Your pickup will be accepeted by Zero Trash center after a one hour
                        of scheduling.
                        The scheduled pickup can be canceled if the pick is not allocated 
                        to a collector.
                     </Card.Text>
                     <br />
                     <Button variant="success" type="submit" block>
                        I Agree
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

export default FormPickupAgree;
