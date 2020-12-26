import React, { Component } from 'react';
import { Button, Form, Card } from 'react-bootstrap';

class FormLanguage extends Component {

   continue (e) {
      e.preventDefault();
      this.props.nextStep();
   }

   render() {
      const { handleChange } = this.props;
      return (
         <Card>
            <Form onSubmit = {e => this.continue(e)}>
               <Card.Body>
                  <Card.Title className='text-center'>
                     Choose Your Language
                  </Card.Title>
                  <br />
                  <div className="mb-3" className='btn-block-language'>
                     <Button type = 'button' value='sinhala' variant="success" size="lg" className="disabled" >
                        Sinhala
                     </Button>
                     <Button type = 'submit' value = 'english' variant="success" size="lg" onClick={handleChange('language')}>
                        English
                     </Button>
                  </div>
               </Card.Body>
            </Form>
         </Card>
      );
   }
}

export default FormLanguage;
