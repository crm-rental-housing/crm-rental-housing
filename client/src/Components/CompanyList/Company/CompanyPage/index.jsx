import React from "react";
import { useSelector } from "react-redux";
import { useParams } from "react-router-dom";
import ProjectList from "../ProjectList";
import CompanyInfo from "../../../CompanyAdminPanel/CompanyInfo";
import Map from "./Map";

const CompanyPage = () => {
  const { id } = useParams();
  const company = useSelector((state) =>
    state.companies.companies.find((company) => company.id === Number(id))
  );
  return (
    <div>
      {company ? (
        <>
          <CompanyInfo company={company} />
          <Map />
          <ProjectList company={company} />
        </>
      ) : (
        <>
          <div>Загрузка</div>
        </>
      )}
    </div>
  );
};

export default CompanyPage;
