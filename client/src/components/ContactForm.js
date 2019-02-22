
import React from 'react'
import { Field, reduxForm } from 'redux-form'
import TextField from 'material-ui/TextField'
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';

const validate = values => {
  const errors = {}
  const requiredFields = [
    'email',
    'message'
  ]
  requiredFields.forEach(field => {
    if (!values[field]) {
      errors[field] = 'Required'
    }
  })
  if (
    values.email &&
    !/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i.test(values.email)
  ) {
    errors.email = 'Invalid email address'
  }
  return errors
}

const renderTextField = ({
  input,
  label,
  meta: { touched, error },
  ...custom
}) => (
  <TextField
    hintText={label}
    floatingLabelText={label}
    errorText={touched && error}
    {...input}
    {...custom}
  />
)

const ContactForm = props => {
  const { handleSubmit, pristine, reset, submitting } = props
  return (
    <MuiThemeProvider>
    <form onSubmit={handleSubmit}>
      
      <div>
        <Field name="email" component={renderTextField} label="Email" />
      </div>
     
      <div>
        <Field
          name="message"
          component={renderTextField}
          label="Message"
          multiLine={true}
          rows={10}
        />
      </div>
      <div>
        <button type="submit" disabled={pristine || submitting}>
          Submit
        </button>
        <button type="button" disabled={pristine || submitting} onClick={reset}>
          Clear Values
        </button>
      </div>
    </form>
    </MuiThemeProvider>
  )
}

export default reduxForm({
  form: 'ContactForm',
  validate
})(ContactForm)
