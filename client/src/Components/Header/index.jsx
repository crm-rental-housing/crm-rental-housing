import React from "react";
import { NavLink } from "react-router-dom";
import { useSelector, useDispatch } from "react-redux";
import { logoutAction } from "../../api/actions/auth";
import "./index.css";

const Header = () => {
  const dispatch = useDispatch();
  const isAuth = useSelector((state) => state.auth.isAuth);
  const handleLogout = async (e) => {
    e.preventDefault();
    await dispatch(logoutAction());
  };
  return (
    <header>
      <div className="wrapper">
        <h2>
          <NavLink className="logo" to="/main">
            LOGO
          </NavLink>
        </h2>
        <div>
          {isAuth ? (
            <>
              <NavLink className="link" to="/">
                Главная
              </NavLink>
              <NavLink className="link" to="/search">
                Поиск
              </NavLink>
              <NavLink className="link" to="/companies">
                Застройщики
              </NavLink>
              <NavLink className="link" to="/contacts">
                Связь с нами
              </NavLink>
              <NavLink className="link" to="/favorite">
                Избранное
              </NavLink>
              <NavLink className="link" to="/notifications">
                Уведомления
              </NavLink>
              <NavLink className="link" to="/profile">
                Профиль
              </NavLink>
            </>
          ) : (
            <>
              <NavLink className="link" to="/main">
                Главная
              </NavLink>
              <NavLink className="link" to="/search">
                Поиск
              </NavLink>
              <NavLink className="link" to="/companies">
                Застройщики
              </NavLink>
              <NavLink className="link" to="/contacts">
                Связь с нами
              </NavLink>
              <NavLink className="link" to="/login">
                Войти
              </NavLink>
              <NavLink className="link" to="/registration">
                Регистрация
              </NavLink>
            </>
          )}
        </div>
      </div>
    </header>
  );
};

export default Header;
