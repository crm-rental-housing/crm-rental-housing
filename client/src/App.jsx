import { BrowserRouter, Routes, Route } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { useEffect } from "react";

import Navbar from "./Components/Navbar";
import Login from "./Components/Login";
import Registration from "./Components/Registration";
import Main from "./Components/Main";
import Home from "./Components/Home";
import Admin from "./Components/Admin";
import UserList from "./Components/UserList";
import User from "./Components/UserList/User";

import { refreshAction } from "./api/actions/auth";
import { getToken } from "./token";

import CompanyList from "./Components/CompanyList";
import Company from "./Components/CompanyList/Company";
import ProjectList from "./Components/CompanyList/Company/ProjectList";
import Project from "./Components/CompanyList/Company/ProjectList/Project";
import EntityList from "./Components/CompanyList/Company/ProjectList/Project/EntityList";
import Entity from "./Components/CompanyList/Company/ProjectList/Project/EntityList/Entity";
import AppartmentList from "./Components/CompanyList/Company/ProjectList/Project/EntityList/Entity/AppartmentList";
import Appartment from "./Components/CompanyList/Company/ProjectList/Project/EntityList/Entity/AppartmentList/Appartment";

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
        <Route path="/companies" element={<CompanyList />} />
        <Route path="/company" element={<Company />} />
        {isAuth ? (
          <>
            <Route path="/projects" element={<ProjectList />} />
            <Route path="/project" element={<Project />} />
            <Route path="/entities" element={<EntityList />} />
            <Route path="/entity" element={<Entity />} />
            <Route path="/appartments" element={<AppartmentList />} />
            <Route path="/appartment" element={<Appartment />} />
            {auth.role === "USER" && (
              <>
                <Route path="/home" element={<Home />} />
                <Route path="/profile" element={<Home />} />
                <Route path="*" element={<Home />} />
              </>
            )}
            {auth.role === "ADMIN" && (
              <>
                <Route path="/admin" element={<Admin />} />
                <Route path="/users" element={<UserList />} />
                <Route path="/user" element={<User />} />
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
