const SET_APPARTMENTS = "SET_APPARTMENTS";

const defaultState = {
  appartments: [],
};

export default function appartmentReducer(state = defaultState, action) {
  switch (action.type) {
    case SET_APPARTMENTS:
      return { ...state, appartments: action.payload };
    default:
      return state;
  }
}

export const setAppartments = (appartments) => ({
  type: SET_APPARTMENTS,
  payload: appartments,
});
