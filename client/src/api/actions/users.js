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

export const me = async () => {
  try {
    const response = await axios.get(`${API_URL}/users/me`, {
      withCredentials: true,
      headers: {
        Authorization: `Bearer ${getToken()}`,
      },
    });
    return response.data.user;
  } catch (error) {
    console.log(error.response.data.message);
  }
};

export const updateUserAction = async (user_data, user_id) => {
  try {
    const response = await axios.put(
      `${API_URL}/users/${user_id}`,
      {
        username: user_data.username,
        first_name: user_data.first_name,
        middle_name: user_data.middle_name,
        last_name: user_data.last_name,
        gender: user_data.gender,
        birthdate: user_data.birthdate,
        phone_number: user_data.phone_number,
        email: user_data.email,
        password: user_data.password,
      },
      {
        withCredentials: true,
        headers: {
          Authorization: `Bearer ${getToken()}`,
        },
      }
    );
    console.log(response.data.message);
  } catch (error) {
    console.log(error.response.data.message);
  }
};
