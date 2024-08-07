const SET_ENTITIES = "SET_ENTITIES";

const defaultState = {
  entities: [],
};

export default function entityReducer(state = defaultState, action) {
  switch (action.type) {
    case SET_ENTITIES:
      return { ...state, entities: action.payload };
    default:
      return state;
  }
}

export const setEntities = (entities) => ({
  type: SET_ENTITIES,
  payload: entities,
});
