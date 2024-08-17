import axios from "axios";
import { getToken } from "../../token";

const API_URL = `http://${process.env.REACT_APP_SERVER_HOST}:${process.env.REACT_APP_SERVER_PORT}/api`;

export const getPaymentTypesAction = async () => {
  try {
    const response = await axios.get(`${API_URL}/payment_types`, {
      withCredentials: true,
      headers: {
        Authorization: `Bearer ${getToken()}`,
      },
    });
    return response.data.payment_types;
  } catch (error) {
    console.log(error.response.data.message);
  }
};
