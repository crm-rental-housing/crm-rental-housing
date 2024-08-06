import { BrowserRouter, Routes, Route } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { useEffect } from "react";

import Navbar from "./Components/Navbar";
import Login from "./Components/Login";
import Registration from "./Components/Registration";
import Main from "./Components/Main";
import Home from "./Components/Home";
import Admin from "./Components/Admin";

import { refreshAction } from "./api/actions/auth";
import { getToken } from "./token";

function App() {
  const isAuth = useSelector((state) => state.auth.isAuth);
  const auth = useSelector((state) => state.auth.currentUser);
  const dispatch = useDispatch();

  useEffect(() => {
    if (getToken()) {
      dispatch(refreshAction());
    }
  }, [dispatch]);

  return (
    <BrowserRouter>
      <Navbar />
      <Routes>
        <Route path="/main" element={<Main />} />
        {isAuth ? (
          <>
            {auth.role === "USER" && (
              <>
                <Route path="/home" element={<Home />} />
                <Route path="*" element={<Home />} />
              </>
            )}
            {auth.role === "ADMIN" && (
              <>
                <Route path="/admin" element={<Admin />} />
                <Route path="*" element={<Admin />} />
              </>
            )}
          </>
        ) : (
          <>
            <Route path="/login" element={<Login />} />
            <Route path="/registration" element={<Registration />} />
            <Route path="*" element={<Login />} />
          </>
        )}
      </Routes>
    </BrowserRouter>
  );
}

export default App;
