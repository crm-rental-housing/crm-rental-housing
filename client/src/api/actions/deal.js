import axios from "axios";

import { getToken } from "../../token";

const API_URL = `http://${process.env.REACT_APP_SERVER_HOST}:${process.env.REACT_APP_SERVER_PORT}/api`;

export const getDealsAction = async () => {
  try {
    const response = await axios.get(`${API_URL}/deals/last`, {
      withCredentials: true,
      headers: {
        Authorization: `Bearer ${getToken()}`,
      },
    });
    return response.data;
  } catch (error) {
    console.log(error.response.data.message);
  }
};

export const getAdminCompanies = async () => {
  try {
    const response = await axios.get(`${API_URL}/admin/companies`, {
      withCredentials: true,
      headers: {
        Authorization: `Bearer ${getToken()}`,
      },
    });
    return response.data;
  } catch (error) {
    console.log(error.response.data.message);
  }
};

export const getManagers = async () => {
  try {
    const response = await axios.get(`${API_URL}/managers`, {
      withCredentials: true,
      headers: {
        Authorization: `Bearer ${getToken()}`,
      },
    });
    return response.data;
  } catch (error) {
    console.log(error.response.data.message);
  }
};
