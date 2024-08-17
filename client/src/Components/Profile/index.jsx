import React from "react";
import { useDispatch } from "react-redux";
import { useState, useEffect } from "react";

import { me, updateUserAction } from "../../api/actions/users";
import { logoutAction } from "../../api/actions/auth";

import "./profile.css";

const Profile = () => {
  const [user, setUser] = useState(null);

  const [username, setUsername] = useState("");
  const [firstName, setFirstName] = useState("");
  const [middleName, setMiddleName] = useState("");
  const [lastName, setLastName] = useState("");
  const [gender, setGender] = useState("");
  const [birthdate, setBirthdate] = useState(null);
  const [phone, setPhone] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const dispatch = useDispatch();
  const logoutHandleSubmit = async (e) => {
    e.preventDefault();
    await dispatch(logoutAction());
  };

  useEffect(() => {
    const fetchData = async () => {
      const user_data = await me();
      setUser(user_data);
      setUsername(user_data?.info?.username);
      setFirstName(user_data?.info?.firstName);
      setMiddleName(user_data?.info?.middleName);
      setLastName(user_data?.info?.lastName);
      setGender(user_data?.info?.gender);
      setBirthdate(user_data?.info?.birthdate);
      setPhone(user_data?.info?.phone);
      setEmail(user_data?.email);
    };
    fetchData();
  }, []);

  const formHandleSubmit = async (e) => {
    e.preventDefault();
    const updated_data = {
      username: username,
      first_name: firstName,
      middle_name: middleName,
      last_name: lastName,
      gender: gender,
      birthdate: birthdate,
      phone_number: phone,
      email: email,
      password: password,
    };
    await updateUserAction(updated_data, user.id);
  };

  return (
    <div className="profile">
      <h2 className="profile__title">Профиль</h2>
      <button onClick={logoutHandleSubmit} className="profile__logout">
        Выход
      </button>
      <div className="profile__items">
        <form onSubmit={formHandleSubmit} className="profile__form">
          <h3 className="form__title">Изменение профиля</h3>
          <input
            type="text"
            value={username || ""}
            onChange={(e) => setUsername(e.target.value)}
            placeholder="Username"
            className="profile__input"
          />
          <input
            type="text"
            value={firstName || ""}
            onChange={(e) => setFirstName(e.target.value)}
            placeholder="Имя"
            className="profile__input"
          />
          <input
            type="text"
            value={middleName || ""}
            onChange={(e) => setMiddleName(e.target.value)}
            placeholder="Отчество"
            className="profile__input"
          />
          <input
            type="text"
            value={lastName || ""}
            onChange={(e) => setLastName(e.target.value)}
            placeholder="Фамилия"
            className="profile__input"
          />
          <input
            type="text"
            value={gender || ""}
            onChange={(e) => setGender(e.target.value)}
            placeholder="Пол"
            className="profile__input"
          />
          <input
            type="date"
            value={birthdate || ""}
            onChange={(e) => setBirthdate(e.target.value)}
            placeholder="Дата рождения"
            className="profile__input"
          />
          <input
            type="tel"
            value={phone || ""}
            onChange={(e) => setPhone(e.target.value)}
            placeholder="Номер телефона"
            className="profile__input"
          />
          <input
            type="text"
            value={email || ""}
            onChange={(e) => setEmail(e.target.value)}
            placeholder="Email"
            className="profile__input"
          />
          {/**============СДЕЛАТЬ ТАК, ЧТОБЫ СНАЧАЛА БЫЛ ВВЕДЕН СТАРЫЙ ПАРОЛЬ ДЛЯ ПРОВЕРКИ============= */}
          <input
            type="text"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            placeholder="Пароль"
            className="profile__input"
          />
          <button className="form__button">Сохранить</button>
        </form>
      </div>
    </div>
  );
};

export default Profile;
