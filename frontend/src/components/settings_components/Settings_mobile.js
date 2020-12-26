import React, { Component } from 'react'
import SettingsMenu_mobile from './SettingsMenu_mobile'
import AccountDetails_mobile from './AccountDetails_mobile'
import PrivacyDetails_mobile from './PrivacyDetails_mobile'

class Settings_mobile extends Component {
  state = {
    step: 1,
  }

  nextStep = (step) => {
    this.setState({
       step: step
    });
  }

  render() {
    const { step } = this.state;
    switch(step) {
      case 1:
        return (
          <SettingsMenu_mobile nextStep = {this.nextStep} />
        )
      case 2:
        return (
          <div className='content-mobile'>
            <AccountDetails_mobile nextStep = {this.nextStep} />
          </div>
        )
      case 3:
        return (
          <div className='content-mobile'>
            <PrivacyDetails_mobile nextStep = {this.nextStep} />
          </div>
        )
    }

  }
}
export default Settings_mobile;