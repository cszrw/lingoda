import { FETCH_CONTACTS, NEW_CONTACT} from '../actions/types'

const initailState = {
    items: [],
    item: {}
}

export default function(state = initailState, action){
    switch(action.type){
        case FETCH_CONTACTS: 
            
            return {
                ...state,
                items: action.payload
            }
        case NEW_CONTACT:
            return {
                ...state,
                item: action.payload
            };
        default:
            return state;

    }

}