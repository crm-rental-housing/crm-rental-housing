import React from "react";

const Company = (props) => {
  return (
    <div>
      <div>{props.company.id}</div>
      <div>{props.company.name}</div>
      <div>{props.company.description}</div>
      <div>{props.company.email}</div>
      <div>{props.company.phone_number}</div>
    </div>
  );
};

export default Company;
