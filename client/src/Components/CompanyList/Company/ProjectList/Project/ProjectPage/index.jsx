import React from "react";
import { useSelector } from "react-redux";
import { useParams } from "react-router-dom";
import ProjectInfo from "../ProjectInfo";
import EntityList from "../EntityList";

const ProjectPage = () => {
  const { id } = useParams();
  const project = useSelector((state) =>
    state.projects.projects.find((project) => project.id === Number(id))
  );
  return (
    <div>
      {project ? (
        <>
          <ProjectInfo project={project} />
          <EntityList project={project} />
          <h3>Менеджер</h3>
          <div>
            {project.user.name.first} {project.user.name.last}
          </div>
        </>
      ) : (
        <>
          <div>Загрузка</div>
        </>
      )}
    </div>
  );
};

export default ProjectPage;
