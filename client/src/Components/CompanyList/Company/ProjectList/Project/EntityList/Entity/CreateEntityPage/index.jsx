import React, { useState } from "react";
import { useParams } from "react-router-dom";
import { createEntityAction } from "../../../../../../../../api/actions/entity";
import { addAppartmentsUrlAction } from "../../../../../../../../api/actions/appartment";

const CreateEntityPage = () => {
  const { project_id } = useParams();
  const [city, setCity] = useState("");
  const [street, setStreet] = useState("");
  const [house, setHouse] = useState("");
  const [floors, setFloors] = useState("");
  const [entrances, setEntrances] = useState("");
  const [link, setLink] = useState("");
  const [entityId, setEntityId] = useState(null);

  const formHandleSubmit = async (e) => {
    e.preventDefault();

    const data = {
      city: city,
      street: street,
      house: house,
      floors: Number(floors),
      entrances: Number(entrances),
    };
    setEntityId(await createEntityAction(project_id, data));
    await addAppartmentsUrlAction(entityId, link);
  };
  return (
    <div>
      <form onSubmit={formHandleSubmit}>
        <input
          id="city"
          type="text"
          value={city}
          onChange={(e) => setCity(e.target.value)}
          placeholder="Город"
        />

        <input
          id="street"
          type="text"
          value={street}
          onChange={(e) => setStreet(e.target.value)}
          placeholder="Улица"
        />

        <input
          id="house"
          type="text"
          value={house}
          onChange={(e) => setHouse(e.target.value)}
          placeholder="Дом"
        />

        <input
          id="floors"
          type="number"
          value={floors}
          onChange={(e) => setFloors(e.target.value)}
          placeholder="Количество этажей"
        />

        <input
          id="entrances"
          type="number"
          value={entrances}
          onChange={(e) => setEntrances(e.target.value)}
          placeholder="Количество подъездов"
        />

        <h3>Информация о квартирах</h3>
        <input
          id="link"
          type="text"
          value={link}
          onChange={(e) => setLink(e.target.value)}
          placeholder="Вставьте ссылку на Google таблицу"
        />

        <button type="submit">Создать</button>
      </form>
    </div>
  );
};

export default CreateEntityPage;
