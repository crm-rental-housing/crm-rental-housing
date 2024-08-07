import axios from "axios";

import { getToken } from "../../token";
import { setCompanies } from "../reducers/companyReducer";

const API_URL = `http://${process.env.REACT_APP_SERVER_HOST}:${process.env.REACT_APP_SERVER_PORT}/api`;

export const getCompaniesAction = () => {
  return async (dispatch) => {
    try {
      const response = await axios.get(`${API_URL}/companies`, {
        withCredentials: true,
        headers: {
          Authorization: `Bearer ${getToken()}`,
        },
      });
      dispatch(setCompanies(response.data.companies));
    } catch (error) {
      console.log(error.response.data.message);
    }
  };
};
