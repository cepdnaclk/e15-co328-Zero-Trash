import React, { Component } from 'react';

import FormPersonalDetails from './../registration_components/FormPersonalDetails';
import FormPasswords from './../registration_components/FormPasswords';
import FormAddressDetails from './../registration_components/FormAddressDetails';
import Confirm from './../registration_components/Confirm'
import FormLanguage from './../registration_components/FormLanguage'
import FormDevVerification from './../registration_components/FormDevVerification'

class Register extends Component {
   state = {
      step: 1,
      language: '',
      customerType:  'Regular Customer',
      municipalCouncil: '',
      firstName: '',
      lastName: '',
      phoneNo: '',
      email: '',
      password: '',
      confirmPassword: '',
      address1: '',
      address2: '',
      city: '',
      regDate: this.formatDate(new Date().toLocaleString())
   };

   formatDate(date) {
      var d = new Date(date),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear();

      if (month.length < 2)
      month = '0' + month;
      if (day.length < 2)
      day = '0' + day;

      return [year, month, day].join('-');
   }

   nextStep = () => {
      const { step } = this.state;
      this.setState({
         step: step + 1
      });
   }

   prevStep = () => {
      const { step } = this.state;
      this.setState({
         step: step - 1
      });
   }

   handleChange = input => e => {
      this.setState({
         [input]: e.target.value
      });
   }

   render() {

      const { step } = this.state;
      const {firstName, lastName, email, phoneNo, password, confirmPassword, address1, address2, city, regDate, customerType, language, municipalCouncil} = this.state;
      const values = {firstName, lastName, email, phoneNo, password, confirmPassword, address1, address2, city, regDate, customerType, language, municipalCouncil};

      switch(step) {
         case 1:
         return (
            <FormLanguage
               nextStep = {this.nextStep}
               handleChange = {this.handleChange}
               />
         )
         case 2:
         return (
            <FormPersonalDetails
               nextStep = {this.nextStep}
               prevStep = {this.prevStep}
               handleChange = {this.handleChange}
               values = {values}
               />
         )
         case 3:
         return (
            <FormDevVerification
               nextStep = {this.nextStep}
               prevStep = {this.prevStep}
               handleChange = {this.handleChange}
               values = {values}
               />
         );
         case 4:
         return (
            <FormPasswords
               nextStep = {this.nextStep}
               prevStep = {this.prevStep}
               handleChange = {this.handleChange}
               values = {values}
               />
         )
         case 5:
         return (
            <FormAddressDetails
               nextStep = {this.nextStep}
               prevStep = {this.prevStep}
               handleChange = {this.handleChange}
               values = {values}
               />
         )
         case 6:
         return (
            <Confirm
               prevStep = {this.prevStep}
               values = {values}
               />
         )
         default:
         return (
            <FormLanguage
               nextStep = {this.nextStep}
               handleChange = {this.handleChange}
               />
         )
      }
   }
}

export default Register;
