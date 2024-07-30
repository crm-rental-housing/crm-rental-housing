import React from "react";
import { NavLink } from "react-router-dom";
import { logout } from "../../api/auth";
import { getToken, removeToken } from "../../token";

const Navbar = () => {
  const handleSubmit = async (e) => {
    e.preventDefault();
    removeToken();
    await logout();
  };

  const AuthRoute = ({ element }) => {
    const token = getToken();
    if (token) {
      return element;
    }
  };

  const NotAuthRoute = ({ element }) => {
    const token = getToken();
    if (!token) {
      return element;
    }
  };

  return (
    <header className="wrapper">
      <div className="navbar">
        <h2 className="navbar__logo">
          <NavLink to="/main">LOGO</NavLink>
        </h2>
        <div className="navbar__menu">
          <NavLink to="/main" className="navbar__item">
            Главная
          </NavLink>
          <NavLink to="/search" className="navbar__item">
            Поиск
          </NavLink>
          <NavLink to="/property_builders" className="navbar__item">
            Застройщики
          </NavLink>
          <NavLink to="/contacts" className="navbar__item">
            Связь с нами
          </NavLink>

          <AuthRoute
            element={
              <>
                <NavLink to="/favorite" className="navbar__item">
                  <div>Избранное</div>
                </NavLink>
                <NavLink to="/notifications" className="navbar__item">
                  <div>Уведомления</div>
                </NavLink>
                <button onClick={handleSubmit}>Выйти</button>
              </>
            }
          />
          <NotAuthRoute
            element={
              <>
                <NavLink to="/login" className="navbar__item">
                  <div>Войти</div>
                </NavLink>
                <NavLink to="/registration" className="navbar__user">
                  <div>Регистрация</div>
                </NavLink>
              </>
            }
          />
        </div>
      </div>
    </header>
  );
};

export default Navbar;
