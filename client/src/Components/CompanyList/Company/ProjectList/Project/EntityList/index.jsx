import React, { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import Entity from "./Entity";
import { getEntitiesAction } from "../../../../../../api/actions/entity";
import { NavLink } from "react-router-dom";

const EntityList = (props) => {
  const dispatch = useDispatch();
  const user = useSelector((state) => state.auth.currentUser);
  useEffect(() => {
    dispatch(getEntitiesAction());
  }, [dispatch]);
  const entities = useSelector((state) => state.entities.entities);
  return (
    <div>
      <h2>Список объектов</h2>
      {(user.role === "COMPANY_ADMIN" || user.role === "COMPANY_MANAGER") && (
        <>
          {props.project && (
            <>
              <NavLink to={`/projects/${props.project.id}/entities/create`}>
                Создать объект
              </NavLink>
            </>
          )}
        </>
      )}
      {entities ? (
        <>
          {props.project ? (
            <>
              {entities
                .filter((entity) => entity.project.id === props.project.id)
                .map((entity, index) => (
                  <Entity key={index} entity={entity} />
                ))}
            </>
          ) : (
            <>
              {entities.map((entity, index) => (
                <Entity key={index} entity={entity} />
              ))}
            </>
          )}
        </>
      ) : (
        <>
          <div>Объектов нет</div>
        </>
      )}
    </div>
  );
};

export default EntityList;
