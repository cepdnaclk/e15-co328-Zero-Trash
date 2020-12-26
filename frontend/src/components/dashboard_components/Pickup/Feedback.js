import React, { Component } from 'react'
import { Button, Modal } from 'react-bootstrap';
import Star from 'react-icons/lib/fa/star';
import Rating from './Rating';
import PropTypes from 'prop-types'

import { ratePickup } from './../UserFunctions';

class Feedback extends Component {

   state = {
      show: false,
      rating: '',
      validInput: true,
      invalidMsg: '',
   }

   feedback() {
      this.setState({ show: !this.state.show })
   }

   handleChange = input => e => {
      this.setState({
         [input]: e,
      });
   }

   continue = e => {
      console.log('click')

      const { pickupId } = this.props;
      const { rating } = this.state;

      const pickup = {
         pickupId: pickupId,
         rate: rating,
      }

      ratePickup(pickup).then(res => {
         if (res) {
            let statusCode = res.statusCode;
            console.log(statusCode);
            if(statusCode === 'S2000'){
               console.log('Success')
               window.location.href = '/home';
            }
            else {
               this.setState({validInput: false, invalidMsg: res.error});
            }
         }
         else{
            console.log('Error')
         }
      })
   }

   render() {

      const { pickupId }  = this.props;
      const { rating,validInput,invalidMsg } = this.state;

      const msg = (
         <div class="alert alert-danger" role="alert">
            {invalidMsg}
         </div>
      )

      return (
         <div>
            <Button variant="light" onClick={() => { this.feedback() }} block><Star size={25} /></Button>
            <Modal show={this.state.show} onHide={() => { this.feedback() }}>
               <Modal.Header closeButton>
                  <h4><b>Feedbacks for pickup #{pickupId}</b></h4>
               </Modal.Header>
               <Modal.Body>
                  <br></br>
                  <div style={{paddingLeft:'10px'}}>
                     Make your feedback on pickup #{pickupId}
                     <br></br>
                     <Rating rating={rating} handleChange = {this.handleChange} size = {'36px'} />
                  </div>
               </Modal.Body>
               {validInput? null : msg}
               <Modal.Footer>
                  <Button variant="success" onClick = {e => this.continue(e)}>Submit</Button>
               </Modal.Footer>
            </Modal>
         </div>
      )
   }
}

Feedback.propTypes = {
   pickupId: PropTypes.number.isRequired
}

export default Feedback;
