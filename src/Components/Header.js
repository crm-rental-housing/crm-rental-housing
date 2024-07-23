import React, { Component } from "react";
import { Nav, Navbar } from "react-bootstrap";
import { Link } from "react-router-dom";
import { logo, heart, notifications, userIcon } from '../Images/HeaderImages';
import '../Styles/Header.css';
import LoginModal from './LoginModal';

export default class Header extends Component {
    constructor(props) {
        super(props);
        this.state = {
            showModal: false
        };
    }

    handleShow = () => {
        this.setState({ showModal: true });
    }

    handleClose = () => {
        this.setState({ showModal: false });
    }

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
                    <Nav.Link className="user" onClick={this.handleShow}>Вход / регистрация</Nav.Link>
                </Navbar>

                <LoginModal show={this.state.showModal} handleClose={this.handleClose} />
            </div>
        );
    }
}
