import React from "react";

const CompanyInfo = (props) => {
  return (
    <div>
      <div>
        <div>
          <div>
            <div>{props.company.name}</div>
            <div>{props.company.email}</div>
            <div>{props.company.phone_number}</div>
          </div>
          <div>
            <div>{props.company.description}</div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CompanyInfo;
