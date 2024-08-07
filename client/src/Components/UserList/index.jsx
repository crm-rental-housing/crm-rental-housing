import React, { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";

import User from "./User";
import { getUsersAction } from "../../api/actions/users";

const UserList = () => {
  const dispatch = useDispatch();
  useEffect(() => {
    dispatch(getUsersAction());
  }, [dispatch]);

  const users = useSelector((state) => state.users.users).map((user, index) => (
    <User key={index} user={user} />
  ));

  return (
    <div>
      <h1>Список пользователей</h1>
      {users}
    </div>
  );
};

export default UserList;
