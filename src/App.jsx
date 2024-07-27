import React from 'react';
import'bootstrap/dist/css/bootstrap.min.css';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Header from './Components/Header';
import HomePage from './Components/headerTabs/HomePage'; // Импортируйте ваш компонент HomePage
import Search from './Components/headerTabs/Search';
import Site from './Components/headerTabs/Site';
import Contact from './Components/headerTabs/Contact';


function App() {
  return (
    <div>
      <Header />
      <Routes>
        <Route path="/" element={<HomePage />} />
        <Route path="/search" element={<Search />} />
        <Route path="/website" element={<Site />} />
        <Route path="/contacts" element={<Contact />} />
        {/* Добавьте другие маршруты здесь при необходимости */}
      </Routes>
    </div>
  );
}


export default App;
