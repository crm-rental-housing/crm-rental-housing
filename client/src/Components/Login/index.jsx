import React, { useState } from "react";
import { NavLink } from "react-router-dom";

import { loginAction } from "../../api/actions/auth";
import { useDispatch } from "react-redux";

const Login = () => {
  const dispatch = useDispatch();

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();
    await dispatch(loginAction(email, password));
  };

  return (
    <div className="login">
      <h2 className="login__title">Вход</h2>
      <label className="login__label">Email</label>
      <input
        className="login__input"
        type="text"
        value={email}
        placeholder="Введите адрес электронной почты"
        onChange={(e) => setEmail(e.target.value)}
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
      <button className="login__btn" onClick={handleSubmit}>
        Войти
      </button>
      <div className="login__redirect">
        <span>Ещё нет аккаунта? </span>
        <NavLink to="/registration">Зарегистрироваться</NavLink>
      </div>
    </div>
  );
};

export default Login;
