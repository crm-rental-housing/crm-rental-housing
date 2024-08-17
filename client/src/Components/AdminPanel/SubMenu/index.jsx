import React from "react";
import { NavLink } from "react-router-dom";

import "./index.css";

const SubMenu = () => {
  return (
    <div className="submenu">
      <div className="submenu__wrapper">
        {/**=========БУДУЩЕЕ ДОП МЕНЮ============== */}
        <NavLink className="submenu__item" to="/users">
          Пользователи
        </NavLink>
        <NavLink className="submenu__item" to="/companies">
          Компании
        </NavLink>
        <NavLink className="submenu__item" to="/projects">
          Проекты
        </NavLink>
        <NavLink className="submenu__item" to="/entities">
          Объекты
        </NavLink>
        <NavLink className="submenu__item" to="/appartments">
          Квартиры
        </NavLink>
        <NavLink className="submenu__item" to="/managers">
          Менеджеры
        </NavLink>
        {/**=========БУДУЩЕЕ ДОП МЕНЮ============== */}
      </div>
    </div>
  );
};

export default SubMenu;
