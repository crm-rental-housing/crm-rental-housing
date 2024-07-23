import React from 'react';
import'bootstrap/dist/css/bootstrap.min.css';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Header from './Components/Header';
import HomePage from './Components/HomePage'; // Импортируйте ваш компонент HomePage


function App() {
  return (
    <div>
      <Header />
      <Routes>
        <Route path="/" element={<HomePage />} />
        {/* Добавьте другие маршруты здесь при необходимости */}
      </Routes>
    </div>
  );
}


export default App;
