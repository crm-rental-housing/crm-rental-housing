import React, { useState } from "react";
import { NavLink } from "react-router-dom";

import "./index.css";

const Login = () => {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");
  return (
    <div className="login">
      <h2 className="login__title">Вход</h2>
      <label className="login__label">Имя пользователя</label>
      <input
        className="login__input"
        type="text"
        value={username}
        placeholder="Введите имя пользователя"
        onChange={(e) => setUsername(e.target.value)}
      />
      <label className="login__label">Пароль</label>
      <input
        className="login__input"
        type="text"
        value={password}
        placeholder="Введите пароль"
        onChange={(e) => setPassword(e.target.value)}
      />
      <NavLink className="login__forget" to="/login/forget">
        Восстановить пароль
      </NavLink>
      <button className="login__btn">Войти</button>
      <div className="login__redirect">
        <span>Ещё нет аккаунта? </span>
        <NavLink to="/registration">Зарегистрироваться</NavLink>
      </div>
    </div>
  );
};

export default Login;
