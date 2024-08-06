import React, { useState } from "react";
import { useDispatch } from "react-redux";
import { NavLink } from "react-router-dom";
import { registrationAction } from "../../api/actions/auth";

const Registration = () => {
  const dispatch = useDispatch();

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();
    await dispatch(registrationAction(email, password));
  };
  return (
    <div className="login">
      <h2 className="login__title">Регистрация</h2>
      <label className="login__label">Адрес электронной почты</label>
      <input
        className="login__input"
        type="text"
        value={email}
        placeholder="Введите имя пользователя"
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
      <button className="login__btn" onClick={handleSubmit}>
        Зарегистрироваться
      </button>
      <div className="login__redirect">
        <span>Уже есть аккаунт? </span>
        <NavLink to="/login">Войти</NavLink>
      </div>
    </div>
  );
};

export default Registration;
