import { BrowserRouter, Routes, Route, Navigate } from "react-router-dom";

import { getToken } from "./token";

import Navbar from "./Components/Navbar";
import Login from "./Components/Login";
import Registration from "./Components/Registration";
import Home from "./Components/Home";

function App() {
  const AuthRoute = ({ element }) => {
    const token = getToken();
    if (token) {
      return element;
    }
    return <Navigate to="/login" />;
  };

  const NotAuthRoute = ({ element }) => {
    const token = getToken();
    if (!token) {
      return element;
    }
    return <Navigate to="/home" />;
  };
  return (
    <BrowserRouter>
      <Navbar />
      <Routes>
        <Route path="/login" element={<NotAuthRoute element={<Login />} />} />
        <Route
          path="/registration"
          element={<NotAuthRoute element={<Registration />} />}
        />
        <Route path="*" element={<NotAuthRoute element={<Login />} />} />

        <Route path="/home" element={<AuthRoute element={<Home />} />} />
        <Route path="*" element={<AuthRoute element={<Home />} />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
