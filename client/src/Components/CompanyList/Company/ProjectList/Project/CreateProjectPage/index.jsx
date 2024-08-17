import React, { useEffect, useState } from "react";
import { getPaymentTypesAction } from "../../../../../../api/actions/paymentType";
import { createProjectAction } from "../../../../../../api/actions/project";

const CreateProjectPage = () => {
  const [name, setName] = useState("");
  const [description, setDescription] = useState("");
  const [deadline, setDeadline] = useState(null);
  const [selectedOption, setSelectedOption] = useState("");
  const [payments, setPayments] = useState(null);

  useEffect(() => {
    const fetchData = async () => {
      setPayments(await getPaymentTypesAction());
    };
    fetchData();
  }, []);

  const handleSelectChange = (value) => {
    setSelectedOption(value);
  };

  const formHandleSubmit = async (e) => {
    e.preventDefault();
    const payment_type_id = payments.find(
      (payment) => payment.name === selectedOption
    )
      ? payments.find((payment) => payment.name === selectedOption).id
      : payments[0].id;
    const data = {
      name: name,
      description: description,
      deadline: deadline,
      payment_type_id: payment_type_id.toString(),
    };
    await createProjectAction(data);
  };
  return (
    <div>
      <>
        <form onSubmit={formHandleSubmit}>
          <div>Название</div>
          <input
            type="text"
            value={name}
            onChange={(e) => setName(e.target.value)}
            placeholder="Название"
          />
          <div>Описание</div>
          <input
            type="textarea"
            value={description}
            onChange={(e) => setDescription(e.target.value)}
            placeholder="Описание"
          />
          <div>Срок сдачи</div>
          <input
            type="date"
            value={deadline || ""}
            onChange={(e) => setDeadline(e.target.value)}
            placeholder="Срок сдачи"
          />
          <div>Тип оплаты</div>
          {payments ? (
            <>
              <Dropdown
                options={payments}
                selected_option={selectedOption}
                onSelect={handleSelectChange}
              />
            </>
          ) : (
            <>
              <div>Нет способов оплаты</div>
            </>
          )}
          <button>Создать</button>
        </form>
      </>
    </div>
  );
};

const Dropdown = (props) => {
  return (
    <>
      <select
        value={props.selected_option}
        onChange={(e) => props.onSelect(e.target.value)}
      >
        {props.options.map((option) => (
          <option key={option.id} value={option.name}>
            {option.name}
          </option>
        ))}
      </select>
    </>
  );
};

export default CreateProjectPage;
