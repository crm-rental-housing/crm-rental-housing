import React, { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import Entity from "./Entity";
import { getEntitiesAction } from "../../api/actions/entity";

const EntityList = () => {
  const dispatch = useDispatch();
  useEffect(() => {
    dispatch(getEntitiesAction());
  }, [dispatch]);
  const entities = useSelector((state) => state.entities.entities).map(
    (entity, index) => <Entity key={index} entity={entity} />
  );
  return (
    <div>
      <h1>Список объектов</h1>
      <div>{entities}</div>
    </div>
  );
};

export default EntityList;
