import React, { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";

import User from "./User";
import { getUsersAction } from "../../api/actions/users";

const UserList = (props) => {
  const dispatch = useDispatch();
  useEffect(() => {
    dispatch(getUsersAction());
  }, [dispatch]);

  const users = useSelector((state) => state.users.users);

  return (
    <div className="userlist">
      <h1>Список пользователей</h1>
      {users ? (
        <>
          {props.role ? (
            <>
              <div>
                {users
                  .filter((user) => user.role === props.role)
                  .map((user, index) => (
                    <User key={index} user={user} />
                  ))}
              </div>
            </>
          ) : (
            <>
              <div>
                {users.map((user, index) => (
                  <User key={index} user={user} />
                ))}
              </div>
            </>
          )}
        </>
      ) : (
        <>
          <div>Пользователей нет</div>
        </>
      )}
    </div>
  );
};

export default UserList;
