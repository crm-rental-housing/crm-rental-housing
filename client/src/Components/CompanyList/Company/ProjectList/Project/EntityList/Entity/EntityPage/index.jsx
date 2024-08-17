import React from "react";
import { useSelector } from "react-redux";
import { useParams } from "react-router-dom";
import EntityInfo from "../EntityInfo";
import AppartmentList from "../AppartmentList";

const EntityPage = () => {
  const { id } = useParams();
  const entity = useSelector((state) =>
    state.entities.entities.find((entity) => entity.id === Number(id))
  );
  return (
    <div>
      {entity ? (
        <>
          <EntityInfo entity={entity} />
          <AppartmentList entity={entity} />
        </>
      ) : (
        <>
          <div>Загрузка</div>
        </>
      )}
    </div>
  );
};

export default EntityPage;
