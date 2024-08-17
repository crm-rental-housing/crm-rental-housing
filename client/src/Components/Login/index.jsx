import styles from "../Styles/Login.module.css"; // Импорт CSS модуля
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
    <div className={styles.container}>
      <h2 className={styles.title}>Вход</h2>
      <form className={styles.form} onSubmit={handleSubmit}>
        <input
          className={styles.input}
          label="Email"
          type="email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          placeholder="Введите Email"
        />
        <input
          className={styles.input}
          label="Пароль"
          type="password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          placeholder="Введите пароль"
        />
        <button className={styles.submitButton} type="submit">
          Войти
        </button>
        <NavLink className={styles.forgotPassword} to="/login/forget">
          Восстановить пароль
        </NavLink>
        <div className={styles.redirect}>
          <span>Ещё нет аккаунта? </span>
          <NavLink to="/registration" className={styles.registerLink}>
            Зарегистрироваться
          </NavLink>
        </div>
      </form>
    </div>
  );
};

export default Login;
