import { BrowserRouter, Routes, Route } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { useEffect } from "react";

import Header from "./Components/Header";
import Footer from "./Components/Footer";
import Login from "./Components/Login";
import Registration from "./Components/Registration";
import Main from "./Components/Main";
import Home from "./Components/Home";
import CompanyAdminPanel from "./Components/CompanyAdminPanel";
import UserList from "./Components/UserList";

import { refreshAction } from "./api/actions/auth";

import CompanyList from "./Components/CompanyList";
import ProjectList from "./Components/CompanyList/Company/ProjectList";
import EntityList from "./Components/CompanyList/Company/ProjectList/Project/EntityList";
import AppartmentList from "./Components/CompanyList/Company/ProjectList/Project/EntityList/Entity/AppartmentList";
import Profile from "./Components/Profile";
import CompanyPage from "./Components/CompanyList/Company/CompanyPage";
import ProjectPage from "./Components/CompanyList/Company/ProjectList/Project/ProjectPage";
import EntityPage from "./Components/CompanyList/Company/ProjectList/Project/EntityList/Entity/EntityPage";
import AppartmentPage from "./Components/CompanyList/Company/ProjectList/Project/EntityList/Entity/AppartmentList/Appartment/AppartmentPage";
import CreateProjectPage from "./Components/CompanyList/Company/ProjectList/Project/CreateProjectPage";
import CreateEntityPage from "./Components/CompanyList/Company/ProjectList/Project/EntityList/Entity/CreateEntityPage";
import AdminPanel from "./Components/AdminPanel";

import { getToken } from "./token";
import ProjectList from "./Components/CompanyList/Company/ProjectList";
import Project from "./Components/CompanyList/Company/ProjectList/Project";
import CompanyList from "./Components/CompanyList";
import Company from "./Components/CompanyList/Company";
import EntityList from "./Components/CompanyList/Company/ProjectList/Project/EntityList";
import Entity from "./Components/CompanyList/Company/ProjectList/Project/EntityList/Entity";
import AppartmentList from "./Components/CompanyList/Company/ProjectList/Project/EntityList/Entity/AppartmentList";
import Appartment from "./Components/CompanyList/Company/ProjectList/Project/EntityList/Entity/AppartmentList/Appartment";

import "./App.css";
function App() {
  const isAuth = useSelector((state) => state.auth.isAuth);
  const auth = useSelector((state) => state.auth.currentUser);
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(refreshAction());
  }, [dispatch]);
  /**
   * =============НАПИСАТЬ РОУТЫ ДЛЯ ВСЕХ РОЛЕЙ============== и
   * =======ПОДУМАТЬ КАК РЕАЛИЗОВАТЬ ВЛОЖЕННЫЕ РОУТЫ=========
   */
  return (
    <BrowserRouter>
      <Header />
      <Routes>
        <Route path="/main" element={<Main />} />
        <Route path="/companies" element={<CompanyList />} />
        <Route path="/companies/:id" element={<CompanyPage />} />
        <Route path="/projects" element={<ProjectList />} />
        <Route path="/projects/:id" element={<ProjectPage />} />
        <Route path="/entities" element={<EntityList />} />
        <Route path="/entities/:id" element={<EntityPage />} />
        <Route path="/appartments" element={<AppartmentList />} />
        <Route path="/appartments/:id" element={<AppartmentPage />} />
        {isAuth ? (
          <>
            <Route path="/profile" element={<Profile />} />
            {auth.role === "USER" && (
              <>
                <Route path="/home" element={<Home />} />
                <Route path="*" element={<Home />} />
              </>
            )}
            {auth.role === "COMPANY_ADMIN" && (
              <>
                <Route path="/admin" element={<CompanyAdminPanel />} />

                <Route
                  path="/projects/create"
                  element={<CreateProjectPage />}
                />
                <Route
                  path="/projects/:project_id/entities/create"
                  element={<CreateEntityPage />}
                />
                <Route path="*" element={<CompanyAdminPanel />} />
              </>
            )}
            {auth.role === "ADMIN" && (
              <>
                <Route path="/" element={<AdminPanel />} />
                <Route path="/users" element={<UserList />} />
                <Route path="/managers" element={<UserList role="MANAGER" />} />
                <Route path="*" element={<AdminPanel />} />
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
      <Footer />
    </BrowserRouter>
  );
}

export default App;
