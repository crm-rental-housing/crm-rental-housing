import React, { Component } from "react";
import { Modal, Button, Form } from "react-bootstrap";
import { GoogleLogin } from '@react-oauth/google';
import RegisterModal from './RegisterModal';

export default class LoginModal extends Component {
    constructor(props) {
        super(props);
        this.state = {
            showRegisterModal: false
        };
    }

    handleShowRegister = () => {
        this.setState({ showRegisterModal: true });
        this.props.handleClose(); // Закрытие формы авторизации
    }

    handleCloseRegister = () => {
        this.setState({ showRegisterModal: false });
    }

    handleRegister = () => {
        // Ваш код для обработки регистрации
        this.handleCloseRegister();
    }

    render() {
        return (
            <>
                <Modal show={this.props.show} onHide={this.props.handleClose}>
                    <Modal.Header closeButton>
                        <Modal.Title>Вход / регистрация</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <Form>
                            <Form.Group controlId="formBasicEmail">
                                <Form.Label>Email адрес</Form.Label>
                                <Form.Control type="email" placeholder="Введите email" />
                            </Form.Group>

                            <Form.Group controlId="formBasicPassword">
                                <Form.Label>Пароль</Form.Label>
                                <Form.Control type="password" placeholder="Введите пароль" />
                            </Form.Group>
                        </Form>
                        <div style={{ textAlign: 'center', marginTop: '20px' }}>
                            <GoogleLogin
                                onSuccess={credentialResponse => {
                                    console.log(credentialResponse);
                                    // Ваш код для обработки успешной авторизации
                                }}
                                onError={() => {
                                    console.log('Login Failed');
                                }}
                            />
                        </div>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="secondary" onClick={this.props.handleClose}>
                            Отмена
                        </Button>
                        <Button variant="primary" onClick={this.props.handleClose}>
                            Войти
                        </Button>
                        <Button variant="link" onClick={this.handleShowRegister}>
                            Регистрация
                        </Button>
                    </Modal.Footer>
                </Modal>
                
                <RegisterModal
                    show={this.state.showRegisterModal}
                    handleClose={this.handleCloseRegister}
                    handleRegister={this.handleRegister}
                />
            </>
        );
    }
}
