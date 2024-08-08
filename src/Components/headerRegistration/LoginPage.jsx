import React, { Component } from "react";
import { Form, Button } from "react-bootstrap";
import { GoogleLogin } from '@react-oauth/google';
import { Link } from "react-router-dom";

export default class LoginPage extends Component {
    render() {
        return (
            <div className="login-page">
                <h2>Вход / регистрация</h2>
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
                <Button variant="primary" style={{ marginTop: '20px' }}>
                    Войти
                </Button>
                <Button variant="link" as={Link} to="/register" style={{ marginTop: '20px' }}>
                    Регистрация
                </Button>
            </div>
        );
    }
}
