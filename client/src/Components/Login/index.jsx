import React, { useState } from "react";
import { NavLink, useNavigate } from "react-router-dom";

import { login } from "../../api/auth";
import { setToken } from "../../token";

const Login = () => {
  const navigate = useNavigate();

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();
    const data = await login(email, password);
    const token = data.access_token.token;
    if (token) {
      setToken(token);
      navigate("/home");
    }
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
