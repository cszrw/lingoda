import React from 'react'
import ContactForm from './ContactForm'

class ContactPage extends React.Component {
  submit = values => {

    const contact = {
        email:values.email,
        message:values.message
    }

    fetch('http://localhost:8000/api/contact', {
        method: 'POST',
        headers: {
          'content-type': 'application/json'
        },
        body: JSON.stringify(contact)
      }).then(function(response) {
        // things we could do here:
        // Put the latest contact item into state
        // Report remote errors
        
        if(response.ok) {
            alert("You message has been sent");
            return
        }
        throw new Error('Network response was not ok.');
      }).catch(function(error) {
        alert('Could not find the service. Message not sent: ', error.message);
      });  
  }
  render() {
    return <ContactForm onSubmit={this.submit} />
  }
}

export default ContactPage