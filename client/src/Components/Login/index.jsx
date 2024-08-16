import styles from "../Styles/Login.module.css"; // Импорт CSS модуля
import React, { useState } from "react";
import { NavLink } from "react-router-dom";
import { loginAction } from "../../api/actions/auth";
import { useDispatch } from "react-redux";
// import { GoogleLogin } from '@react-oauth/google';


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
        <label className={styles.label} htmlFor="email">Email</label>
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
        <NavLink className={styles.forgotPassword} to="/login/forget">
          Восстановить пароль
        </NavLink>
          {/* <div style={{ textAlign: 'center', marginTop: '20px' }}>
              <GoogleLogin
                  onSuccess={credentialResponse => {
                      console.log(credentialResponse);
                      // Ваш код для обработки успешной авторизации
                  }}
                  onError={() => {
                      console.log('Login Failed');
                  }}
              />
          </div> */}
        <button className={styles.submitButton} type="submit">
          Войти
        </button>
        <div className={styles.redirect}>
          <span>Ещё нет аккаунта? </span>
          <NavLink to="/registration" className={styles.registerLink}>Зарегистрироваться</NavLink>
        </div>
      </form>
    </div>
  );
};

export default Login;
