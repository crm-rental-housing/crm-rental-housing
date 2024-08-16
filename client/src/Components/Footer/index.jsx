// src/Components/Footer.js
import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import styles from '../Styles/Footer.module.css'; // Импортируйте стили для футера, если есть

const Footer = () => {
  return (
    <footer className={`${styles.footer} text-center py-4`}>
      <p>Свяжитесь с нами: example@example.com</p>
      <p>Телефон: +7 (123) 456-7890</p>
      <button className="btn btn-outline-dark mt-3">Связаться</button>
    </footer>
  );
};

export default Footer;
