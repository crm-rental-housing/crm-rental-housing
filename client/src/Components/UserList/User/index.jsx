import React from "react";

const User = (props) => {
  const banHandleSubmit = () => {};
  const deleteHandleSubmit = () => {};
  return (
    <div>
      <div>{props.user.id}</div>
      {props.user.company ? (
        <>
          <div>{props.user.company}</div>
        </>
      ) : (
        <>
          <div>Нет</div>
        </>
      )}
      {props.user.info ? (
        <>
          <div>{props.user.info.username}</div>
          <div>{props.user.info.first_name}</div>
          <div>{props.user.info.middle_name}</div>
          <div>{props.user.info.last_name}</div>
        </>
      ) : (
        <>
          <div>Неизвестно</div>
          <div>Неизвестно</div>
          <div>Неизвестно</div>
          <div>Неизвестно</div>
          <div>Неизвестно</div>
        </>
      )}
      <div>{props.user.email}</div>
      <div>{props.user.role}</div>
      <button onClick={deleteHandleSubmit}>Удалить</button>
      <button onClick={banHandleSubmit}>Заблокировать</button>
    </div>
  );
};

export default User;
