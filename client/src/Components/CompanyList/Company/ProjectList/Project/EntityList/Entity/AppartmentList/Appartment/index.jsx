import React from "react";

const Appartment = (props) => {
  return (
    <>
      <div>{props.appartment.price}</div>
      <div>{props.appartment.entrance_number}</div>
      <div>{props.appartment.floor_number}</div>
      <div>{props.appartment.appartment_number}</div>
      <div>{props.appartment.rooms_number}</div>
      <div>{props.appartment.total_area}</div>
      <div>{props.appartment.kitchen_area}</div>
      <div>{props.appartment.repair_type}</div>
      <div>{props.appartment.type_status}</div>
      <div>{props.appartment.entity.address.city}</div>
      <div>{props.appartment.entity.address.street}</div>
      <div>{props.appartment.entity.address.house}</div>
      <div>{props.appartment.entity.user.first}</div>
      <div>{props.appartment.entity.user.last}</div>
      <div>{props.appartment.entity.user.role}</div>
    </>
  );
};

export default Appartment;
