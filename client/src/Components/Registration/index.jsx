import React, { useState } from "react";
import { useDispatch } from "react-redux";
import { NavLink } from "react-router-dom";
import { registrationAction } from "../../api/actions/auth";
import styles from "../Styles/Registration.module.css"; // Импорт CSS модуля

const Registration = () => {
  const dispatch = useDispatch();
  const [firstName, setFirstName] = useState("");
  const [lastName, setLastName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (password !== confirmPassword) {
      alert("Пароли не совпадают");
      return;
    }
    await dispatch(registrationAction(firstName, lastName, email, password));
  };

  return (
    <div className={styles.container}>
      <h2 className={styles.title}>Регистрация</h2>
      <form className={styles.form} onSubmit={handleSubmit}>
        <label className={styles.label} htmlFor="firstName">Имя</label>
        <input
          className={styles.input}
          id="firstName"
          type="text"
          value={firstName}
          placeholder="Введите имя"
          onChange={(e) => setFirstName(e.target.value)}
          required
        />
        <label className={styles.label} htmlFor="lastName">Фамилия</label>
        <input
          className={styles.input}
          id="lastName"
          type="text"
          value={lastName}
          placeholder="Введите фамилию"
          onChange={(e) => setLastName(e.target.value)}
          required
        />
        <label className={styles.label} htmlFor="email">Адрес электронной почты</label>
        <input
          className={styles.input}
          id="email"
          type="email"
          value={email}
          placeholder="Введите адрес электронной почты"
          onChange={(e) => setEmail(e.target.value)}
          required
        />
        <label className={styles.label} htmlFor="password">Пароль</label>
        <input
          className={styles.input}
          id="password"
          type="password"
          value={password}
          placeholder="Введите пароль"
          onChange={(e) => setPassword(e.target.value)}
          required
        />
        <label className={styles.label} htmlFor="confirmPassword">Подтверждение пароля</label>
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
          <NavLink to="/login" className={styles.registerLink}>Войти</NavLink>
        </div>
      </form>
    </div>
  );
};

export default Registration;
