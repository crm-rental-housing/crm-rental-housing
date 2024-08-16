// src/AppMain/AppMainContent.js
import React from 'react';
import { useNavigate } from 'react-router-dom';


const AppMainContent = () => {
  const navigate = useNavigate();

  const handleLearnMore = () => {
    navigate('/main'); 
  };

  return (
    <div>
      <h1 className="Text_hello">Добро пожаловать!</h1>
      <button className="button-start" onClick={handleLearnMore}>Узнать больше</button>
    </div>
  );
};

export default AppMainContent;
