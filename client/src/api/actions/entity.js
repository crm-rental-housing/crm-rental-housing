import axios from "axios";

import { getToken } from "../../token";
import { setEntities } from "../reducers/entityReducer";

const API_URL = `http://${process.env.REACT_APP_SERVER_HOST}:${process.env.REACT_APP_SERVER_PORT}/api`;

export const getEntitiesAction = () => {
  return async (dispatch) => {
    try {
      const response = await axios.get(`${API_URL}/entities`, {
        withCredentials: true,
        headers: {
          Authorization: `Bearer ${getToken()}`,
        },
      });
      dispatch(setEntities(response.data.entities));
    } catch (error) {
      console.log(error.response.data.message);
    }
  };
};
