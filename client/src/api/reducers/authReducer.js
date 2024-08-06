const SET_USER = "SET_USER";
const LOGOUT = "LOGOUT";

const defaultState = {
  currentUser: null,
  isAuth: false,
};

export default function authReducer(state = defaultState, action) {
  switch (action.type) {
    case SET_USER:
      return {
        ...state,
        currentUser: action.payload,
        isAuth: true,
      };
    case LOGOUT:
      return {
        ...state,
        currentUser: null,
        isAuth: false,
      };
    default:
      return state;
  }
}

export const setAuth = (user) => ({ type: SET_USER, payload: user });
export const logout = () => ({ type: LOGOUT });
