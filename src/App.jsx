import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import { BrowserRouter as Router, Route, Routes, useLocation } from 'react-router-dom';
import Header from './Components/Header';
import HomePage from './Components/headerTabs/HomePage'; 
import Search from './Components/headerTabs/Search';
import Site from './Components/headerTabs/Site';
import Contact from './Components/headerTabs/Contact';
import LoginPage from './Components/headerRegistration/LoginPage';
import RegisterPage from './Components/headerRegistration/RegisterPage';
// import AllProjects from './Components/headerTabs/ComponentsHomePage/AllProjects';

function App() {
  return (
    <div>
      <Header />
      <Routes>
        <Route path="/" element={<HomePage />} />
        <Route path="/search" element={<Search />} />
        <Route path="/website" element={<Site />} />
        <Route path="/contacts" element={<Contact />} />
        <Route path="/login" element={<LoginPage />} />
        <Route path="/register" element={<RegisterPage />} />
      </Routes>
    </div>
  );
}

export default App;
