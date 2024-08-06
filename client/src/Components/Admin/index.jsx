import React from "react";
import { useDispatch, useSelector } from "react-redux";
import { getUsersAction } from "../../api/actions/users";

const Admin = () => {
  const auth = useSelector((state) => state.auth.currentUser);
  const users = useSelector((state) => state.users.users);
  const dispatch = useDispatch();

  const showUsers = async (e) => {
    e.preventDefault();
    await dispatch(getUsersAction());
    console.log(users);
  };
  return (
    <div>
      <h1>Admin panel</h1>
      <div>{auth.email}</div>
      <div>{auth.role}</div>
      <div>{auth.expiresIn}</div>
      <button onClick={showUsers}>Список пользователей</button>
    </div>
  );
};

export default Admin;
