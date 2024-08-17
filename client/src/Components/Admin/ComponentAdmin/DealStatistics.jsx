// src/Components/StatisticsManagers.jsx
import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import { Card } from 'react-bootstrap';
import styles from '../../Styles/Admin.module.css'; // Импортируйте ваш CSS-модуль

function StatisticsManagers() {
  // Здесь данные могут быть получены из props или состояния компонента
  const manager = "Иван Иванов";
  const dealsCount = 5;

  return (
    <Card className={styles.transactionFieldsContainerInfo_3}>
      <Card.Body>
        <Card.Title>Информация о сделке</Card.Title>
        <Card.Text>
          <strong>Менеджер ФИО:</strong> {manager} <br />
          <strong>Количество сделок:</strong> {dealsCount} <br />
        </Card.Text>
      </Card.Body>
    </Card>
  );
}

export default StatisticsManagers;
