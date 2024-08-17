import React from "react";
import { useDispatch } from "react-redux";

import { NavLink } from "react-router-dom";
import { logoutAction } from "../../../api/actions/auth";

import "./index.css";

const SideMenu = (props) => {
  const dispatch = useDispatch();
  const logoutHandleSubmit = async (e) => {
    e.preventDefault();
    await dispatch(logoutAction());
  };
  return (
    <div className="side_menu">
      <div className="user">
        <div className="user__id">ID: {props.user.id}</div>
        <div className="user__email">Email: {props.user.email}</div>
        <div className="user__name">ФИО:</div>
        {props.user.info ? (
          <>
            <div>{props.user.info.last}</div>
            <div>{props.user.info.middle}</div>
            <div>{props.user.info.first}</div>
          </>
        ) : (
          <>
            <div>Безымянный</div>
          </>
        )}
      </div>

      <NavLink className="side_menu__link" to="/main">
        Главная
      </NavLink>
      <NavLink className="side_menu__link" to="/profile">
        Профиль
      </NavLink>
      <NavLink className="side_menu__link" to="/favorite">
        Избранное
      </NavLink>
      <NavLink className="side_menu__link" to="/notifications">
        Уведомления
      </NavLink>
      <button onClick={logoutHandleSubmit} className="side_menu__button">
        Выход
      </button>
    </div>
  );
};

export default SideMenu;
