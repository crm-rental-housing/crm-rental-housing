import React from "react";
import { NavLink } from "react-router-dom";

const Project = (props) => {
  return (
    <div>
      <div>
        <NavLink to="/entities">
          <div>{props.project.id}</div>
          <div>{props.project.name}</div>
          <div>{props.project.description}</div>
          <div>{props.project.deadline}</div>
        </NavLink>
      </div>
    </div>
  );
};

export default Project;
