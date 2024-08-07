import axios from "axios";

import { getToken } from "../../token";
import { setAppartments } from "../reducers/appartmentReducer";

const API_URL = `http://${process.env.REACT_APP_SERVER_HOST}:${process.env.REACT_APP_SERVER_PORT}/api`;

export const getAppartmentsAction = () => {
  return async (dispatch) => {
    try {
      const response = await axios.get(`${API_URL}/appartments`, {
        withCredentials: true,
        headers: {
          Authorization: `Bearer ${getToken()}`,
        },
      });
      dispatch(setAppartments(response.data.appartments));
    } catch (error) {
      console.log(error.response.data.message);
    }
  };
};
