import React from "react";

const EntityInfo = (props) => {
  return (
    <div>
      <h2>{props.entity.id}</h2>
      {/* <div>{props.project.company.name}</div> */}
      <div>
        г. {props.entity.city}, ул. {props.entity.street}, д.{" "}
        {props.entity.house}
      </div>
      <div>
        <div>Срок сдачи</div>
        <div>{props.entity.deadline}</div>
      </div>
      {/* <div>
        <div>Оплата</div>
        <div>{props.project.payment_type}</div>
      </div> */}
      <div>
        <div>Характеристики</div>
        <div>{props.entity.floors_number}</div>
        <div>{props.entity.entrances_number}</div>
      </div>
    </div>
  );
};

export default EntityInfo;
