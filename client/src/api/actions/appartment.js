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

export const addAppartmentsUrlAction = async (entity_id, link) => {
  try {
    const response = await axios.post(
      `${API_URL}/entities/${entity_id}/appartments/url`,
      {
        link: link,
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
