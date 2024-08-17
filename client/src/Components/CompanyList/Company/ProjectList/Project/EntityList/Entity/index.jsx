import React from "react";
import { NavLink } from "react-router-dom";

const Entity = (props) => {
  return (
    <div>
      <NavLink to={`/entities/${props.entity.id}`}>
        <div>{props.entity.city}</div>
        <div>{props.entity.street}</div>
        <div>{props.entity.house}</div>
        <div>{props.entity.project.name}</div>
        <div>{props.entity.floors_number}</div>
        <div>{props.entity.entrances_number}</div>
        <div>{props.entity.user.name.first}</div>
        <div>{props.entity.user.name.last}</div>
        <div>{props.entity.user.name.role}</div>
      </NavLink>
    </div>
  );
};

export default Entity;
