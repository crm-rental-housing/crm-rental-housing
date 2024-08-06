import React from "react";
import { useSelector } from "react-redux";

const Home = () => {
  const user = useSelector((state) => state.auth.currentUser);

  return (
    <div>
      <h1>Home page</h1>
      <div>{user.email}</div>
      <div>{user.role}</div>
      <div>{user.expiresIn}</div>
    </div>
  );
};

export default Home;
