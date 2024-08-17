import React from "react";
import { NavLink } from "react-router-dom";
import "./index.css";

const Footer = () => {
  return (
    <footer>
      <div className="footer__wrapper">
        <div className="footer__item">
          <h4>(c) 2024</h4>
        </div>
        <div className="footer__item">
          <h4>Навигация</h4>
          <NavLink className="footer__link" to="/main">
            Главная
          </NavLink>
          <NavLink className="footer__link" to="/entities">
            Объекты
          </NavLink>
          <NavLink className="footer__link" to="/companies">
            Застройщики
          </NavLink>
        </div>
        <div className="footer__item">
          <h4>Контакты</h4>
          <div>+79XXXXXXXXX</div>
          <div>example@example.com</div>
        </div>
        <div className="footer__item">Политика конфиденциальности</div>
      </div>
    </footer>
  );
};

export default Footer;
