import React, { useEffect, useState } from "react";
import SubMenu from "./SubMenu";
import DealList from "../DealList";
import CompanyList from "../CompanyList";

const AdminPanel = () => {
  return (
    <div>
      <SubMenu />
      <h2>Статистика застройщиков</h2>
      <div>
        <h3>Последние сделки</h3>
        <DealList />
      </div>
      <div>
        <h3>Статистика по менеджерам</h3>
        <div>Скоро появится</div>
      </div>
      <div>
        <CompanyList />
      </div>
    </div>
  );
};

export default AdminPanel;
