import React, { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import Project from "./Project";
import { getProjectsAction } from "../../../../api/actions/project";
import { NavLink } from "react-router-dom";

const ProjectList = (props) => {
  const dispatch = useDispatch();
  const user = useSelector((state) => state.auth.currentUser);
  useEffect(() => {
    dispatch(getProjectsAction());
  }, [dispatch]);
  const projects = useSelector((state) => state.projects.projects);
  return (
    <div>
      <h2>Список проектов</h2>
      {(user.role === "COMPANY_ADMIN" || user.role === "COMPANY_MANAGER") && (
        <>
          {props.company && (
            <>
              <NavLink to={`/projects/create`}>Создать проект</NavLink>
            </>
          )}
        </>
      )}
      {projects ? (
        <>
          <div>
            {props.company ? (
              <>
                {projects.filter(
                  (project) => project.company.id === props.company.id
                ).length !== 0 ? (
                  <>
                    {projects
                      .filter(
                        (project) => project.company.id === props.company.id
                      )
                      .map((project, index) => (
                        <Project key={index} project={project} />
                      ))}
                  </>
                ) : (
                  <>
                    <div>У компании нет проектов</div>
                  </>
                )}
              </>
            ) : (
              <>
                {projects.map((project, index) => (
                  <Project key={index} project={project} />
                ))}
              </>
            )}
          </div>
        </>
      ) : (
        <>
          <div>Проектов нет</div>
        </>
      )}
    </div>
  );
};

export default ProjectList;
