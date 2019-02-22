import React from 'react'
import Enzyme, { mount } from 'enzyme'
import Adapter from 'enzyme-adapter-react-16'
import ContactPage from '../../components/ContactPage'
import store from "../../store";
import { Provider}  from 'react-redux';

Enzyme.configure({ adapter: new Adapter() })

function setup() {
    const props = {
        addTodo: jest.fn()
    }

    const enzymeWrapper = mount(
        <Provider store={store}>
        <ContactPage {...props} />
        </Provider>
    );

    return {
        props,
        enzymeWrapper
    }
}

describe('components', () => {
  describe('ContactPage', () => {
    it('should render self and its fields', () => {
      const { enzymeWrapper } = setup()

      expect(enzymeWrapper.find('form').hasClass('container')).toBe(true)
      expect(enzymeWrapper.find("input[type='text'][name='email']").type()).toBe('input')
      expect(enzymeWrapper.find("textarea[name='message']").type()).toBe('textarea')
      expect(enzymeWrapper.find("button[type='submit']").type()).toBe('button')
      expect(enzymeWrapper.find("button[type='button']").type()).toBe('button')
    })
  })
})