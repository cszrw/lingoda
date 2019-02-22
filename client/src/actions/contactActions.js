import { FETCH_CONTACTS, NEW_CONTACT } from './types';

export const createContact = contactData => disp => {
  fetch('http://localhost:8000/api/contact', {
    method: 'POST',
    headers: {
      'content-type': 'application/json'
    },
    body: JSON.stringify(contactData)
  })
    .then(res => res.json())
    .then(c =>
      disp({
        type: NEW_CONTACT,
        payload: c
      })
    );
};

export const fetchContacts = () => dispatch => {
  fetch('http://localhost:8000/api/contact')
    .then(res => res.json()
      .then(contacts =>
        dispatch({
          type: FETCH_CONTACTS,
          payload: contacts
        })
      )
    );
};

