// src/Components/Object.jsx
import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import { Card } from 'react-bootstrap';
import styles from '../../Styles/Admin.module.css'; // Импортируйте ваш CSS-модуль

function Object() {
  // Здесь данные могут быть получены из props или состояния компонента
  const manager = "Иван Иванов";
  const client = "ООО Ромашка";

  return (
    <Card className={styles.transactionFieldsContainerInfo_2}>
      <Card.Body>
        <Card.Title>Информация о сделке</Card.Title>
        <Card.Text>
          <strong>Объект топ:</strong> {manager} <br />
          <strong>Клиент:</strong> {client} <br />
        </Card.Text>
      </Card.Body>
    </Card>
  );
}

export default Object;
