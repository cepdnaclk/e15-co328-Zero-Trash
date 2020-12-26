import React from "react";
import { Nav } from "react-bootstrap";

class SideBar extends React.Component {

  nextStep = step => {
    this.props.nextStep(step);
  }

  render() {


    return (
      <div className="sidebar" id="sidebar-id">
        <div className="sidebar-header">
          <h3>Settings</h3>
        </div>

        <Nav className="flex-column pt-2">

          <Nav.Item className="active">
            <Nav.Link href="#" onClick={ () => this.nextStep(1) } >
              Account
            </Nav.Link>
          </Nav.Item>

          <Nav.Item>
            <Nav.Link href="#" onClick={ () => this.nextStep(2) } >
              Security and Login
            </Nav.Link>
          </Nav.Item>

          <Nav.Item>
            <Nav.Link href="#" onClick={ () => this.nextStep(3) } >
              FAQ
            </Nav.Link>
          </Nav.Item>

          <Nav.Item>
            <Nav.Link href="#" onClick={ () => this.nextStep(4) } >
              Contact
            </Nav.Link>
          </Nav.Item>
        </Nav>
      </div>
    );
  }
}

export default SideBar;
