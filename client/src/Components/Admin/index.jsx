import React from "react";
import { useSelector } from "react-redux";
import { NavLink } from "react-router-dom";

const Admin = () => {
  const auth = useSelector((state) => state.auth.currentUser);

  return (
    <div>
      <h1>Admin panel</h1>
      <div>{auth.email}</div>
      <div>{auth.role}</div>
      <NavLink to="/users">Пользователи</NavLink>
      <NavLink to="/companies">Компании</NavLink>
      <NavLink to="/projects">Проекты</NavLink>
      <NavLink to="/entities">Объекты</NavLink>
      <NavLink to="/appartments">Квартиры</NavLink>
      <NavLink to="/managers">Менеджеры</NavLink>
    </div>
  );
};

export default Admin;
