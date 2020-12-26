import React, { Component } from 'react'
import { Nav } from "react-bootstrap"

class SettingsMenu_mobile extends Component {

    nextStep = step => {
        this.props.nextStep(step);
    }

    render() {
        return (
            <div className="contentMenu-mobile">
              <div className="sidebar-header">
                <h3>Settings</h3>
              </div>
      
              <Nav className="flex-column pt-2">
      
                <Nav.Item className="active">
                  <Nav.Link href="#" onClick={ () => this.nextStep(2) } >
                    Account Details
                  </Nav.Link>
                </Nav.Item>
      
                <Nav.Item>
                  <Nav.Link href="#" onClick={ () => this.nextStep(3) } >
                    Security and Login
                  </Nav.Link>
                </Nav.Item>
      
                <Nav.Item>
                  <Nav.Link href="#" onClick={ () => this.nextStep(4) } >
                    FAQ
                  </Nav.Link>
                </Nav.Item>
      
                <Nav.Item>
                  <Nav.Link href="#" onClick={ () => this.nextStep(5) } >
                    Contact
                  </Nav.Link>
                </Nav.Item>
              </Nav>
            </div>
          );
    }
}
export default SettingsMenu_mobile;