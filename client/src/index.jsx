import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { Provider } from 'react-redux';
import './index.css';

import App from './App';
import App_main from './AppMain/App_main'; // Обновите импорт
import { store } from './api/reducers';
import reportWebVitals from './reportWebVitals';

const root = ReactDOM.createRoot(document.getElementById('root'));

root.render(
  <Provider store={store}>
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<App_main />} />
        <Route path="*" element={<App />} />
      </Routes>
    </BrowserRouter>
  </Provider>
);

reportWebVitals();
