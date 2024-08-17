// src/Components/TransactionField.jsx
import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import { Card } from 'react-bootstrap';
import styles from '../../Styles/Admin.module.css'; // Импортируйте ваш CSS-модуль

function TransactionField() {
  // Здесь данные могут быть получены из props или состояния компонента
  const manager = "Иван Иванов";
  const client = "ООО Ромашка";
  const dealType = "Продажа";
  const projectName = "ЖК Северный";

  return (
    <Card className={styles.transactionFieldsContainerInfo}>
      <Card.Body>
        <Card.Title>Информация о сделке</Card.Title>
        <Card.Text>
          <strong>Менеджер:</strong> {manager} <br />
          <strong>Клиент:</strong> {client} <br />
          <strong>Тип сделки:</strong> {dealType} <br />
          <strong>Название проекта:</strong> {projectName}
        </Card.Text>
      </Card.Body>
    </Card>
  );
}

export default TransactionField;
