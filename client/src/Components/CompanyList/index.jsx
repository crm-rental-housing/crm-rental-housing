import React, { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import Company from "./Company";
import { getCompaniesAction } from "../../api/actions/company";

const CompanyList = () => {
  const dispatch = useDispatch();
  useEffect(() => {
    dispatch(getCompaniesAction());
  }, [dispatch]);
  const companies = useSelector((state) => state.companies.companies);
  /**
   * ============НУЖНО ПРОДУМАТЬ КАК ПЕРЕДАВАТЬ ID ДАЛЬШЕ =================================
   * ======НАПРИМЕР, ЧТОБЫ ПРИ НАЖАТИИ НА ПУНКТ ИЗ СПИСКА ПЕРЕДЕДАВАЛСЯ ID ================
   */
  return (
    <div>
      <h1>Список компаний</h1>
      {companies ? (
        <>
          <div>
            {companies.map((company, index) => (
              <Company key={index} company={company} />
            ))}
          </div>
        </>
      ) : (
        <>
          <div>Компаний нет</div>
        </>
      )}
    </div>
  );
};

export default CompanyList;
