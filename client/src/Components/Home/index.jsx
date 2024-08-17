import React from "react";
import { useEffect, useState } from "react";

import { me } from "../../api/actions/users";

import SideMenu from "./SideMenu";
import News from "./News";
import Feedback from "./Feedback";

import "./index.css";

const Home = () => {
  const [user, setUser] = useState(null);

  useEffect(() => {
    const fetchData = async () => {
      const user_data = await me();
      setUser(user_data);
    };
    fetchData();
  }, []);

  return (
    <div className="home">
      {user ? (
        <>
          <SideMenu user={user} />
          <News />
          <Feedback />
        </>
      ) : (
        <>
          {/**===========НУЖНО ДОБАВИТЬ КАКУЮ-НИБУДЬ АНИМАЦИЮ ИЛИ ЧТО-ТО ТАКОЕ============= */}
          <div className="home__loading">Загрузка</div>
        </>
      )}
    </div>
  );
};

export default Home;
