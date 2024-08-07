import { combineReducers } from "redux";
import { configureStore } from "@reduxjs/toolkit";
import usersReducer from "./usersReducer";
import authReducer from "./authReducer";
import projectReducer from "./projectReducer";
import entityReducer from "./entityReducer";
import companyReducer from "./companyReducer";
import appartmentReducer from "./appartmentReducer";

const rootReducer = combineReducers({
  auth: authReducer,
  users: usersReducer,
  companies: companyReducer,
  projects: projectReducer,
  entities: entityReducer,
  appartments: appartmentReducer,
});

export const store = configureStore({ reducer: rootReducer });
