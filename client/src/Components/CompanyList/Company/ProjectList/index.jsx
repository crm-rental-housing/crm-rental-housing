import React, { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import Project from "./Project";
import { getProjectsAction } from "../../api/actions/project";

const ProjectList = () => {
  const dispatch = useDispatch();
  useEffect(() => {
    dispatch(getProjectsAction());
  }, [dispatch]);
  const projects = useSelector((state) => state.projects.projects).map(
    (project, index) => <Project key={index} project={project} />
  );
  return (
    <div>
      <h1>Список проектов</h1>
      <div>{projects}</div>
    </div>
  );
};

export default ProjectList;
