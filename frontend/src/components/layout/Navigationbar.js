import React, { Component } from 'react'
import { Link, withRouter } from 'react-router-dom'
import {Navbar, Nav,NavDropdown} from 'react-bootstrap';

class Navigationbar extends Component {
   logOut(e) {
      e.preventDefault()
      localStorage.removeItem('usertoken')
      this.props.history.push(`/login`)
   }

   render() {

      const loginRegLink = (
         <Nav>
            <Nav.Link>
               <Link to="/login" className="nav-link">
                  Sign In
               </Link>
            </Nav.Link>

            <Nav.Link>
               <Link to="/register" className="nav-link">
                  Sign Up
               </Link>
            </Nav.Link>
         </Nav>

      )

      const userLink = (
         <Nav>
            <Nav.Link>
               <Link to="/home" className="nav-link">
                  Home
               </Link>
            </Nav.Link>
            <NavDropdown className = "navbar-dropDown-icon"title={<i className="fa fa-user"></i>} alignRight id="dropdown-menu-align-right">
               <NavDropdown.Item href="/home">Home</NavDropdown.Item>
               <NavDropdown.Item href="/settings">Settings & Privacy</NavDropdown.Item>
               <NavDropdown.Divider />
               <NavDropdown.Item href="#" onClick={this.logOut.bind(this)}>
                  Logout
               </NavDropdown.Item>
            </NavDropdown>
         </Nav>
      )

      return (
         <Navbar collapseOnSelect expand="lg" bg="dark" variant="dark" sticky="top">
            <Navbar.Brand href="#home">Zero Trash</Navbar.Brand>
            <Navbar.Toggle aria-controls="responsive-navbar-nav" />
            <Navbar.Collapse id="responsive-navbar-nav">
               <Nav className="mr-auto">

               </Nav>
               {localStorage.usertoken ? userLink : loginRegLink}
            </Navbar.Collapse>
         </Navbar>
      )
   }
}

export default withRouter(Navigationbar)
