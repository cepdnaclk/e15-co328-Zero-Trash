import React, { Component } from 'react'
import Sidebar from '../settings_components/Sidebar'
import AccountDetails from '../settings_components/AccountDetails'
import PrivacyDetails from '../settings_components/PrivacyDetails'
import Settings_mobile from '../settings_components/Settings_mobile'


class Settings extends Component {

   state = {
      step: 1,
      mobileWindow: false,
   }

   nextStep = (step) => {
      this.setState({
         step: step
      });
   }

   updateDimensions() {
      if(window.innerWidth < 500) {
         this.setState({mobileWindow: true});
      }
      else{
         this.setState({mobileWindow: false});
      }
   }

   componentDidMount() {
      this.updateDimensions();
      window.addEventListener("resize", this.updateDimensions.bind(this));
   }

   componentWillUnmount() {
      window.removeEventListener("resize", this.updateDimensions.bind(this));
   }


   render() {
      const { step,mobileWindow } = this.state;
      switch(step) {
         case 1:
         if(mobileWindow) {
            return (
               <div className="settings">
                  <Settings_mobile />
               </div>
            )

         }
         else {
            return (
               <div className="settings">
                  <Sidebar nextStep = {this.nextStep} />
                  <div className="content" id="content-id">
                     <AccountDetails />
                  </div>
               </div>
            )
         }

         case 2:
         return (
            <div className="settings">
               <Sidebar nextStep = {this.nextStep} />
               <div className="content" id="content-id">
                  <PrivacyDetails />
               </div>
            </div>
         )

      }
   }
}

export default Settings;
