const SET_USERS = "SET_USERS";
const ADD_USER = "ADD_USER";
const REMOVE_USER = "REMOVE_USER";

const defaultState = {
  users: [],
};

export default function usersReducer(state = defaultState, action) {
  switch (action.type) {
    case SET_USERS:
      return { ...state, users: action.payload };
    case ADD_USER:
      return { ...state, users: [...state.users, action.payload] };
    case REMOVE_USER:
      return {
        ...state,
        users: [...state.users.filter((user) => user.id !== action.payload)],
      };
    default:
      return state;
  }
}

export const setUsers = (users) => ({ type: SET_USERS, payload: users });
export const addUser = (user) => ({ type: ADD_USER, payload: user });
export const removeUser = (userId) => ({ type: REMOVE_USER, payload: userId });
