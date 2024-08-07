const SET_PROJECTS = "SET_PROJECTS";

const defaultState = {
  projects: [],
};

export default function projectReducer(state = defaultState, action) {
  switch (action.type) {
    case SET_PROJECTS:
      return { ...state, projects: action.payload };
    default:
      return state;
  }
}

export const setProjects = (projects) => ({
  type: SET_PROJECTS,
  payload: projects,
});
