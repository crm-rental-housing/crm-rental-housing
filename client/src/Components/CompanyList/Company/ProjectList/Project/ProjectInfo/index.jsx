import React from "react";

const ProjectInfo = (props) => {
  return (
    <div>
      <h2>{props.project.name}</h2>
      <div>{props.project.company.name}</div>
      <div>{props.project.description}</div>
    </div>
  );
};

export default ProjectInfo;
