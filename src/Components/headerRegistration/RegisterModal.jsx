import React, { Component } from "react";
import { Modal, Button, Form } from "react-bootstrap";

export default class RegisterModal extends Component {
    render() {
        return (
            <Modal show={this.props.show} onHide={this.props.handleClose}>
                <Modal.Header closeButton>
                    <Modal.Title>Регистрация</Modal.Title>
                </Modal.Header>
                <Modal.Body>
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
                </Modal.Body>
                <Modal.Footer>
                    <Button variant="secondary" onClick={this.props.handleClose}>
                        Отмена
                    </Button>
                    <Button variant="primary" onClick={this.props.handleRegister}>
                        Зарегистрироваться
                    </Button>
                </Modal.Footer>
            </Modal>
        );
    }
}
