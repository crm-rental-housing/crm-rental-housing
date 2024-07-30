import axios from "axios";

const API_URL = `http://${process.env.REACT_APP_SERVER_HOST}:${process.env.REACT_APP_SERVER_PORT}/api`;

export const login = async (email, password) => {
  try {
    const response = await axios.post(`${API_URL}/auth/login`, {
      email,
      password,
    });
    return response.data;
  } catch (error) {
    console.log(error.response.data.message);
  }
};

export const registration = async (email, password) => {
  try {
    const response = await axios.post(`${API_URL}/auth/registration`, {
      email,
      password,
    });
    return response.data;
  } catch (error) {
    console.log(error.response.data.message);
  }
};

export const logout = async () => {
  try {
    const response = await axios.get(`${API_URL}/auth/logout`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("access_token")}`,
      },
    });
    return response.data;
  } catch (error) {
    console.log(error.response.data.message);
  }
};
