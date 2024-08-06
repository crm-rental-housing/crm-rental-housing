import axios from "axios";

import { setUsers } from "../reducers/usersReducer";
import { getToken } from "../../token";

const API_URL = `http://${process.env.REACT_APP_SERVER_HOST}:${process.env.REACT_APP_SERVER_PORT}/api`;

export const getUsersAction = () => {
  return async (dispatch) => {
    try {
      const response = await axios.get(`${API_URL}/users`, {
        withCredentials: true,
        headers: {
          Authorization: `Bearer ${getToken()}`,
        },
      });
      dispatch(setUsers(response.data.users));
    } catch (error) {
      console.log(error.response.data.message);
    }
  };
};
