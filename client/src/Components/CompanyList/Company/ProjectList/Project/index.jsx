import React from "react";

const Project = (props) => {
  return (
    <div>
      <div>
        <div>{props.project.id}</div>
        <div>{props.project.name}</div>
        <div>{props.project.description}</div>
        <div>{props.project.deadline}</div>
        <div>{props.project.payment_type}</div>
        <div>{props.project.company.name}</div>
        <div>{props.project.user.name.first}</div>
        <div>{props.project.user.name.last}</div>
        <div>{props.project.user.name.role}</div>
      </div>
    </div>
  );
};

export default Project;
