import { combineReducers } from "redux";
import { configureStore } from "@reduxjs/toolkit";
import usersReducer from "./usersReducer";
import authReducer from "./authReducer";

const rootReducer = combineReducers({
  auth: authReducer,
  users: usersReducer,
});

export const store = configureStore({ reducer: rootReducer });
