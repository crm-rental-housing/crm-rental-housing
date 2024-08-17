import React from "react";
import DealStatistic from "./DealStatistic";
import CompanyInfo from "./CompanyInfo";
import { NavLink } from "react-router-dom";
import { useSelector } from "react-redux";

const CompanyAdminPanel = () => {
  const user = useSelector((state) => state.auth.currentUser);

  return (
    <div>
      <h2>Панель администратора застройщика</h2>
      {user.company ? (
        <>
          <CompanyInfo company={user.company} />
          <NavLink to={`/companies/${user.company.id}/edit`}>
            Редактировать информацию
          </NavLink>
          <DealStatistic />
        </>
      ) : (
        <>
          {/**===========НУЖНО ДОБАВИТЬ КАКУЮ-НИБУДЬ АНИМАЦИЮ ИЛИ ЧТО-ТО ТАКОЕ============= */}
          <div>Загрузка...</div>
        </>
      )}
    </div>
  );
};

export default CompanyAdminPanel;
