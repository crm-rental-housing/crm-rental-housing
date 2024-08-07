import axios from "axios";
import { jwtDecode } from "jwt-decode";

import { getToken, removeToken, setToken } from "../../token";
import { logout, setAuth } from "../reducers/authReducer";

const API_URL = `http://${process.env.REACT_APP_SERVER_HOST}:${process.env.REACT_APP_SERVER_PORT}/api`;

export const loginAction = (email, password) => {
  return async (dispatch) => {
    try {
      const response = await axios.post(
        `${API_URL}/auth/login`,
        {
          email,
          password,
        },
        {
          withCredentials: true,
        }
      );
      const data = response.data;
      const token = data.access_token.token;
      const decodedData = jwtDecode(token);
      const user = {
        email: decodedData.email,
        role: decodedData.role,
        expiresIn: data.access_token.expires_in,
      };
      setToken(token);
      dispatch(setAuth(user));
    } catch (error) {
      console.log(error.response.data.message);
    }
  };
};

export const registrationAction = (email, password) => {
  return async (dispatch) => {
    try {
      const response = await axios.post(
        `${API_URL}/auth/registration`,
        {
          email,
          password,
        },
        {
          withCredentials: true,
        }
      );
      const data = response.data;
      const token = data.access_token.token;
      const decodedData = jwtDecode(token);
      const user = {
        email: decodedData.email,
        role: decodedData.role,
        expiresIn: data.access_token.expires_in,
      };
      setToken(token);
      dispatch(setAuth(user));
    } catch (error) {
      console.log(error.response.data.message);
    }
  };
};

export const refreshAction = () => {
  return async (dispatch) => {
    try {
      const response = await axios.get(`${API_URL}/auth/refresh`, {
        withCredentials: true,
      });
      const data = response.data;
      const token = data.access_token.token;
      const decodedData = jwtDecode(token);
      const user = {
        email: decodedData.email,
        role: decodedData.role,
        expiresIn: data.access_token.expires_in,
      };
      setToken(token);
      dispatch(setAuth(user));
    } catch (error) {
      console.log(error.response.data.message);
      removeToken();
      dispatch(logout());
    }
  };
};

export const logoutAction = () => {
  return async (dispatch) => {
    try {
      const response = await axios.get(`${API_URL}/auth/logout`, {
        withCredentials: true,
        headers: {
          Authorization: `Bearer ${getToken()}`,
        },
      });
      removeToken();
      dispatch(logout());
      console.log(response.data.message);
    } catch (error) {
      console.log(error.response.data.message);
    }
  };
};
