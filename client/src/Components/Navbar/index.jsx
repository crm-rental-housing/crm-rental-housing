import React from "react";
import { NavLink } from "react-router-dom";
import { logoutAction } from "../../api/actions/auth";
import { useDispatch, useSelector } from "react-redux";

const Navbar = () => {
  const dispatch = useDispatch();
  const isAuth = useSelector((state) => state.auth.isAuth);

  const handleSubmit = async (e) => {
    e.preventDefault();
    await dispatch(logoutAction());
  };

  return (
    <header className="wrapper">
      <div className="navbar">
        <h2 className="navbar__logo">
          <NavLink to="/main">LOGO</NavLink>
        </h2>
        <div className="navbar__menu">
          {isAuth ? (
            <>
              <NavLink to="/">Главная</NavLink>
            </>
          ) : (
            <>
              <NavLink to="/main">Главная</NavLink>
            </>
          )}
          <NavLink to="/search" className="navbar__item">
            Поиск
          </NavLink>
          <NavLink to="/companies" className="navbar__item">
            Застройщики
          </NavLink>
          <NavLink to="/contacts" className="navbar__item">
            Связь с нами
          </NavLink>

          {isAuth ? (
            <>
              <NavLink to="/favorite" className="navbar__item">
                <div>Избранное</div>
              </NavLink>
              <NavLink to="/notifications" className="navbar__item">
                <div>Уведомления</div>
              </NavLink>
              <button onClick={handleSubmit}>Выйти</button>
            </>
          ) : (
            <>
              <NavLink to="/login" className="navbar__item">
                <div>Войти</div>
              </NavLink>
              <NavLink to="/registration" className="navbar__user">
                <div>Регистрация</div>
              </NavLink>
            </>
          )}
        </div>
      </div>
    </header>
  );
};

export default Navbar;
