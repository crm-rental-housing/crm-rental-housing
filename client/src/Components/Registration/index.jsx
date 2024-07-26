import React, { useState } from "react";
import { NavLink } from "react-router-dom";

const Registration = () => {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");
  return (
    <div className="login">
      <h2 className="login__title">Регистрация</h2>
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
      <button className="login__btn">Зарегистрироваться</button>
      <div className="login__redirect">
        <span>Уже есть аккаунт? </span>
        <NavLink to="/login">Войти</NavLink>
      </div>
    </div>
  );
};

export default Registration;
