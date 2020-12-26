import React, { Component } from 'react'
import { Container, Row, Col, Table } from 'react-bootstrap';
import { Link } from 'react-router-dom';

import Image from 'react-icons/lib/fa/image';
import PickupListItem from './PickupListItem';
import { getListItems } from './UserFunctions';

class Dashboard extends Component {

   state = {
      list : [],
   }
   getPickupTime(timeState){
      switch(timeState) {
         case '8':
         return '8:00 a.m. - 10:00 a.m.';
         case '10':
         return '10:00 a.m. - 12:00 p.m.';
         case '12':
         return '12:00 p.m. - 2:00 p.m.';
         case '14':
         return '2:00 p.m. - 4:00 p.m.';
         case '16':
         return '4:00 p.m. - 6:00 p.m.';
         case '18':
         return '6:00 p.m. - 8:00 p.m.';
      }
   }

   handleListItems = () => {
      getListItems().then(res => {
         if (res.statusCode==='S2000') {
               let list = [];
               for(let i=0; i<res.data.length;++i){
                  let date = res.data[i].placedOn.split(" ");
                  let time = this.getPickupTime(res.data[i].timeSlot);
                  let item = {
                     pickupState: res.data[i].state,
                     pickupId: parseInt(res.data[i].id),
                     pickupDate: date[0],
                     pickupTime: time,
                     rating: parseInt(res.data[i].rating)
                  }
                  list.push(item);
               }
               this.setState({list: list});
         }
      })
   }

   componentDidMount(){
      this.handleListItems();
   }

   render() {

      var { list } = this.state;

      return (
         <div>
            <br></br>
            <br></br>

            <div className="dashboard">
               <Container>
                  <Row>
                     <Col>
                        <Link to="../newPickup">
                           <div style={{display: "flex",justifyContent: "center",alignItems: "center"}}>
                              <div>
                                 <Image size={200} />
                                 <br/>
                                 <h5 align="center">Schedule a Pickup</h5>
                              </div>

                           </div>
                        </Link>
                     </Col>
                     <Col>
                        <b>Instructions to Schedule a Pickup</b>
                        <br></br>
                        <ul>
                           <li>Click this to schedule a pickup</li>
                           <li>Enter the requesting information</li>
                           <li>Confirm and Submit pickup</li>
                        </ul>
                        Your pickup will be accepeted by Zero Trash center after a one hour
                        of scheduling.
                        The scheduled pickup can be canceled if the pick is not allocated 
                        to a collector.
                     </Col>
                  </Row>
                  <br></br>
                  <br></br>
                  <Row>
                     <Col>
                        <div>
                           <br/>
                           <h4>History</h4>
                           <br/>
                           <Table responsive striped >
                              <tbody>
                                 {list.map(function(item, i){
                                    return <PickupListItem
                                       pickupState={item.pickupState}
                                       pickupId={item.pickupId}
                                       pickupDate={item.pickupDate}
                                       pickupTime={item.pickupTime}
                                       rating={item.rating}
                                       key={i}/>;
                                 })}
                              </tbody>
                           </Table>
                        </div>
                     </Col>
                  </Row>
               </Container>
            </div>
         </div>
      )
   }
}

export default Dashboard;
