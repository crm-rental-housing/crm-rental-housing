import React from "react";
import { NavLink } from "react-router-dom";

const Company = (props) => {
  return (
    <div>
      <div>{props.company.id}</div>
      <div>{props.company.name}</div>
      <div>{props.company.description}</div>
      <div>{props.company.email}</div>
      <div>{props.company.phone_number}</div>
      <NavLink to={`/companies/${props.company.id}`}>
        Посмотреть предложения
      </NavLink>
    </div>
  );
};

export default Company;
