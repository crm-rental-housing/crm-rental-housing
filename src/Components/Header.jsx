import React, { Component } from "react";
import { Nav, Navbar } from "react-bootstrap";
import { Link } from "react-router-dom";
import { logo, heart, notifications, userIcon } from '../Images/HeaderImages';
import '../Styles/Header.css';
// import styles from '../Styles/HomePage.module.css'

export default class Header extends Component {
    render() {
        return (
            <div className="Navbar">
                <Navbar collapseOnSelect expand="md" bg="light" variant="light">
                    <Navbar.Brand href="/">
                        <img
                            src={logo}
                            className="logo d-inline-block align-top"
                            alt="Logo"
                        />
                    </Navbar.Brand>
                    <Navbar.Toggle aria-controls="responsive-navbar-nav" />
                    <Navbar.Collapse id="responsive-navbar-nav">
                        <Nav className="me-auto">
                            <Nav.Link as={Link} to="/">Главная</Nav.Link>
                            <Nav.Link as={Link} to="/search">Поиск</Nav.Link>
                            <Nav.Link as={Link} to="/website">О сайте</Nav.Link>
                            <Nav.Link as={Link} to="/contacts">Связь c нами</Nav.Link>
                        </Nav>
                    </Navbar.Collapse>
                    <Navbar.Brand href="/">
                        <img
                            src={heart}
                            className="heart d-inline-block align-top"
                            alt="Heart"
                        />
                    </Navbar.Brand>
                    <Navbar.Brand href="/">
                        <img
                            src={notifications}
                            className="notifications d-inline-block align-top"
                            alt="Notifications"
                        />
                    </Navbar.Brand>
                    <Navbar.Brand href="/">
                        <img
                            src={userIcon}
                            className="user_icon d-inline-block align-top"
                            alt="User_icon"
                        />
                    </Navbar.Brand>
                    <Nav.Link className="user" as={Link} to="/login">Вход / регистрация</Nav.Link>
                </Navbar>
            </div>
        );
    }
}
