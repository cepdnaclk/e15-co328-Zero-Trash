import React, { Component } from 'react';
import BeautyStars from 'beauty-stars';

class Rating extends Component {
   state = { 
      value: 0 
   };

   render() {

      const { rating, handleChange, size}  = this.props;

     return (
      <div style={{display: 'flex', justifyContent: 'center'}}>
             <BeautyStars
              value={rating}
              onChange = {handleChange('rating')}
              size = {size}
            />
      </div>
     );
   }

}
 
export default Rating;
