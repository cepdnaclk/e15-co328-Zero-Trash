import React, { Component } from 'react';

class Landing extends Component {


   componentDidMount(){
      // Redirect to requested URL
      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      const page = urlParams.get('p')
      console.log(page);

      if(page!=null){
         this.props.history.push(page);
      }
   }
   
    state = {  }
    render() {
        return (
            <div />
        );
    }
}

export default Landing;
