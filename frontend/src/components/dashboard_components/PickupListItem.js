import React, { Component } from 'react'

import Feedback from './Pickup/Feedback';
import Delete from './Pickup/Delete';
import Rating from './Pickup/Rating';

var PropTypes = require('prop-types');

class PickupListItem extends Component {

   handleChange = input => e => {
      console.log('You already rated');
   }

   renderPickupState(s){
      switch(s) {
         case 'PENDING': return <td className="await">Awaiting Pickup</td>;
         case 'COMPLETED': return (<td className="complete">Completed</td>);
         case 'INCOMPLETED': return (<td className="incomplete">Incompleted</td>);
         case 'CANCLED': return (<td className="incomplete">Incompleted</td>);
      }
   }

      renderPickupOption(s, pickupId, rating){
         console.log(pickupId+':'+rating);
         if(this.props.pickupState==='PENDING'){
            return <Delete pickupId={pickupId}/>
         }else if(rating){
            console.log('This is rated')
            return <Rating rating={rating} handleChange = {this.handleChange} size = {'20px'}/>
         }
         else {
            console.log('This is not rated')
            return <Feedback pickupId={pickupId} />
         }
      }
      render() {
         const pickupId = this.props.pickupId;
         const pickupTime = this.props.pickupTime;
         const pickupDate = this.props.pickupDate;
         const pickupState = this.props.pickupState;
         const pickupRating = this.props.rating;

         return (
            <tr>
               {this.renderPickupState(pickupState)}
               <td><b>{pickupDate}</b><br/><small>{pickupTime}</small></td>
               <td>{this.renderPickupOption(pickupState,pickupId, pickupRating)} </td>
            </tr>
         );
      }
   }

   Feedback.propTypes = {
      pickupId: PropTypes.number.isRequired,
      pickupId: PropTypes.string.isRequired,
      pickupState: PropTypes.string.isRequired,
      pickupTime:PropTypes.string.isRequired,
      pickupDate:PropTypes.string.isRequired,
      rating: PropTypes.number.isRequired,
   }

   export default PickupListItem;
