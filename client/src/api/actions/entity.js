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

export const getEntityAction = async (entity_id) => {
  try {
    const response = await axios.get(`${API_URL}/entities/${entity_id}`, {
      withCredentials: true,
      headers: {
        Authorization: `Bearer ${getToken()}`,
      },
    });
    return response.data.entity;
  } catch (error) {
    console.log(error.response.data.message);
  }
};

export const createEntityAction = async (project_id, entity) => {
  try {
    const response = await axios.post(
      `${API_URL}/projects/${project_id}/entities`,
      {
        city: entity.city,
        street: entity.street,
        house: entity.house,
        floors_number: entity.floors,
        entrances_number: entity.entrances,
      },
      {
        withCredentials: true,
        headers: {
          Authorization: `Bearer ${getToken()}`,
        },
      }
    );
    console.log(response.data.message);
    return response.data.entity_id;
  } catch (error) {
    console.log(error.response.data.message);
  }
};
