import React, { Component } from 'react'
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { createContact } from '../actions/contactActions';

class ContactForm extends Component {

  constructor(props){
    super(props)
    this.state = {
        email:'',
        message:''
    }
    this.onChange = this.onChange.bind(this);
    this.onSubmit = this.onSubmit.bind(this);
  }

  onChange(e){
    this.setState({[e.target.name]: e.target.value})
  }

  onSubmit(e){
    e.preventDefault()
    const contact = {
        email:this.state.email,
        message:this.state.message
    }
    this.props.createContact(contact);
  }

  render() {
    return (
      <div>
        <h1>Contact Us</h1>
     
        <form onSubmit={this.onSubmit}>
          <div>
            <label>E-mail:</label>
            <input name="email" type="email"
             value={this.state.email}
             onChange={this.onChange} />
          </div>
          <br/>
          <div>
            <label>Message:</label>
            <textarea name="message" 
              value={this.state.message}
              onChange={this.onChange} />
          </div>
          <br/>
          <button type="submit">Submit</button>
        </form>
      </div>
    )
  }
}

ContactForm.propTypes = {
  createContact: PropTypes.func.isRequired
};
export default connect(null, { createContact })(ContactForm);

