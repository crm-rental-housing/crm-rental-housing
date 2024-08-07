import React from "react";

const User = (props) => {
  const banHandleSubmit = () => {};
  const deleteHandleSubmit = () => {};
  return (
    <div>
      <div>{props.user.id}</div>
      <div>{props.user.info ? props.user.info.firstName : "Имя"}</div>
      <div>{props.user.info ? props.user.info.lastName : "Фамилия"}</div>
      <div>{props.user.email}</div>
      <div>{props.user.role}</div>
      <button onClick={deleteHandleSubmit}>Удалить</button>
      <button onClick={banHandleSubmit}>Заблокировать</button>
    </div>
  );
};

export default User;
