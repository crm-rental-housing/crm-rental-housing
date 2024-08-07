const SET_COMPANIES = "SET_COMPANIES";

const defaultState = {
  companies: [],
};

export default function companyReducer(state = defaultState, action) {
  switch (action.type) {
    case SET_COMPANIES:
      return { ...state, companies: action.payload };
    default:
      return state;
  }
}

export const setCompanies = (companies) => ({
  type: SET_COMPANIES,
  payload: companies,
});
