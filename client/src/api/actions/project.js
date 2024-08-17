import axios from "axios";

import { setProjects } from "../reducers/projectReducer";
import { getToken } from "../../token";

const API_URL = `http://${process.env.REACT_APP_SERVER_HOST}:${process.env.REACT_APP_SERVER_PORT}/api`;

export const getProjectsAction = () => {
  return async (dispatch) => {
    try {
      const response = await axios.get(`${API_URL}/projects`, {
        withCredentials: true,
        headers: {
          Authorization: `Bearer ${getToken()}`,
        },
      });
      dispatch(setProjects(response.data.projects));
    } catch (error) {
      console.log(error.response.data.message);
    }
  };
};

export const createProjectAction = async (project) => {
  try {
    const response = await axios.post(
      `${API_URL}/projects`,
      {
        name: project.name,
        description: project.description,
        deadline: project.deadline,
        payment_type_id: project.payment_type_id,
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
