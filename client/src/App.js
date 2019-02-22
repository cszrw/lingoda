import React, { Component } from 'react';
import './App.css';
import ContactPage from './components/ContactPage';
import { Provider}  from 'react-redux';
import store from './store';

class App extends Component {
  render() {
    return (
      
      <Provider store={store}>
      <div className="App">
        <ContactPage/>
      </div>
      </Provider>
    );
  }
}

export default App;
