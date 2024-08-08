import React, { Component } from "react";
import { Form, Button } from "react-bootstrap";

export default class RegisterPage extends Component {
    handleRegister = () => {
        // Ваш код для обработки регистрации
    }

    render() {
        return (
            <div className="register-page">
                <h2>Регистрация</h2>
                <Form>
                    <Form.Group controlId="formBasicFirstName">
                        <Form.Label>Имя</Form.Label>
                        <Form.Control type="text" placeholder="Введите имя" />
                    </Form.Group>

                    <Form.Group controlId="formBasicLastName">
                        <Form.Label>Фамилия</Form.Label>
                        <Form.Control type="text" placeholder="Введите фамилию" />
                    </Form.Group>

                    <Form.Group controlId="formBasicMiddleName">
                        <Form.Label>Отчество</Form.Label>
                        <Form.Control type="text" placeholder="Введите отчество" />
                    </Form.Group>

                    <Form.Group controlId="formBasicPhoneNumber">
                        <Form.Label>Номер телефона</Form.Label>
                        <Form.Control type="text" placeholder="Введите номер телефона" />
                    </Form.Group>

                    <Form.Group controlId="formBasicEmail">
                        <Form.Label>Email адрес</Form.Label>
                        <Form.Control type="email" placeholder="Введите email" />
                    </Form.Group>

                    <Form.Group controlId="formBasicPassword">
                        <Form.Label>Пароль</Form.Label>
                        <Form.Control type="password" placeholder="Введите пароль" />
                    </Form.Group>
                </Form>
                <Button variant="secondary" style={{ marginTop: '20px' }}>
                    Отмена
                </Button>
                <Button variant="primary" style={{ marginTop: '20px' }} onClick={this.handleRegister}>
                    Зарегистрироваться
                </Button>
            </div>
        );
    }
}
