import React from "react";
import { NavLink } from "react-router-dom";
import { Navbar, Nav, Dropdown } from "react-bootstrap";
// import Dropdown from 'react-bootstrap/Dropdown';
import DropdownButton from 'react-bootstrap/DropdownButton';
import { logoutAction } from "../../api/actions/auth";
import { useDispatch, useSelector } from "react-redux";
import styles from "../Styles/Navbar.module.css"; // Импорт CSS модуля
import { logo, heart, notifications, userIcon } from '../Images/HeaderImages';

const CustomNavbar = () => {
  const dispatch = useDispatch();
  const isAuth = useSelector((state) => state.auth.isAuth);

  const handleLogout = async (e) => {
    e.preventDefault();
    await dispatch(logoutAction());
  };

  return (
    <header className={styles.wrapper}>
      <Navbar collapseOnSelect expand="md" bg="light" variant="light">
        <Navbar.Brand as={NavLink} to="/">
          <img
            src={logo}
            className={styles.logo}
            alt="Logo"
          />
        </Navbar.Brand>
        <Navbar.Toggle aria-controls="responsive-navbar-nav" />
        <Navbar.Collapse id="responsive-navbar-nav">
          <Nav className={styles.navbar_nav}>
            <Nav.Link as={NavLink} to={isAuth ? "/" : "/main"} className={styles.item}>
              Главная
            </Nav.Link>
            <Nav.Link as={NavLink} to="/search" className={styles.item}>
              Поиск
            </Nav.Link>
            <Nav.Link as={NavLink} to="/companies" className={styles.item}>
              Застройщики
            </Nav.Link>
            <Nav.Link as={NavLink} to="/contacts" className={styles.item}>
              Связь с нами
            </Nav.Link>
          </Nav>
          <Nav className={styles.auth_nav}>
            {isAuth ? (
              <>
                <Nav.Link as={NavLink} to="/favorite" className={styles.item}>
                  <img
                    src={heart}
                    className={styles.item}
                    alt="Heart"
                  />
                </Nav.Link>
                <Nav.Link as={NavLink} to="/notifications" className={styles.item}>
                  <img
                    src={notifications}
                    className={styles.item}
                    alt="Notifications"
                  />
                </Nav.Link>
                <Dropdown align="end" className={styles.user_dropdown}>
                  <Dropdown.Toggle variant="link" id="dropdown-basic">
                    <img
                      src={userIcon}
                      className={styles.user_icon}
                      alt="User Icon"
                    />
                  </Dropdown.Toggle>

                  <Dropdown.Menu>
                    <Dropdown.Item as={NavLink} to="/settings">Настройки</Dropdown.Item>
                    <Dropdown.Item as={NavLink} to="/support">Чат с поддержкой</Dropdown.Item>
                    <Dropdown.Divider />
                    <nav className={styles.verticalNav}>
                      <NavLink to="/users" className={styles.navLink}>Пользователи</NavLink>
                      <NavLink to="/companies" className={styles.navLink}>Компании</NavLink>
                      <NavLink to="/projects" className={styles.navLink}>Проекты</NavLink>
                      <NavLink to="/entities" className={styles.navLink}>Объекты</NavLink>
                      <NavLink to="/appartments" className={styles.navLink}>Квартиры</NavLink>
                      <NavLink to="/managers" className={styles.navLink}>Менеджеры</NavLink>
                    </nav>
                    <Dropdown.Divider />
                    <Dropdown.Item onClick={handleLogout}>Выход</Dropdown.Item>
                  </Dropdown.Menu>
                </Dropdown>
              </>
            ) : (
              <>
                <Nav.Link as={NavLink} to="/login" className={styles.item}>
                  Войти
                </Nav.Link>
                <Nav.Link as={NavLink} to="/registration" className={styles.item}>
                  Регистрация
                </Nav.Link>
              </>
            )}
          </Nav>
        </Navbar.Collapse>
      </Navbar>
    </header>
  );
};

export default CustomNavbar;
