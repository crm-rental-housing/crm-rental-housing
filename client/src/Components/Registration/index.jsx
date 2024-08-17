import React, { useState } from "react";
import { useDispatch } from "react-redux";
import { NavLink } from "react-router-dom";
import { registrationAction } from "../../api/actions/auth";

import styles from "./index.module.css";

const Registration = () => {
  const dispatch = useDispatch();
  const [firstName, setFirstName] = useState("");
  const [lastName, setLastName] = useState("");
  const [email, setEmail] = useState("");
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (password !== confirmPassword) {
      alert("Пароли не совпадают");
      return;
    }
    await dispatch(registrationAction(email, username, password));
  };

  return (
    <div className={styles.container}>
      <h2 className={styles.title}>Регистрация</h2>
      <form className={styles.form} onSubmit={handleSubmit}>
        <input
          className={styles.input}
          type="text"
          value={email}
          placeholder="Введите Email"
          onChange={(e) => setEmail(e.target.value)}
        />
        <input
          className={styles.input}
          type="text"
          value={username}
          placeholder="Введите username"
          onChange={(e) => setUsername(e.target.value)}
        />
        <input
          className={styles.input}
          type="password"
          value={password}
          placeholder="Введите пароль"
          onChange={(e) => setPassword(e.target.value)}
        />
        <input
          className={styles.input}
          id="confirmPassword"
          type="password"
          value={confirmPassword}
          placeholder="Подтвердите пароль"
          onChange={(e) => setConfirmPassword(e.target.value)}
          required
        />
        <button className={styles.submitButton} type="submit">
          Зарегистрироваться
        </button>
        <div className={styles.redirect}>
          <span>Уже есть аккаунт? </span>
          <NavLink to="/login" className={styles.registerLink}>
            Войти
          </NavLink>
        </div>
      </form>
    </div>
  );
};

export default Registration;
