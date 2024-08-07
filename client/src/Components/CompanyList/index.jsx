import React, { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import Company from "./Company";
import { getCompaniesAction } from "../../api/actions/company";

const CompanyList = () => {
  const dispatch = useDispatch();
  useEffect(() => {
    dispatch(getCompaniesAction());
  }, [dispatch]);
  const companies = useSelector((state) => state.companies.companies).map(
    (company, index) => <Company key={index} company={company} />
  );
  return (
    <div>
      <h1>Список компаний</h1>
      <div>{companies}</div>
    </div>
  );
};

export default CompanyList;
