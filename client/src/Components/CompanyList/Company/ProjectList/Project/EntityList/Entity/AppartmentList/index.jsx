import React, { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import Appartment from "./Appartment";
import { getAppartmentsAction } from "../../../../api/actions/appartment";

const AppartmentList = () => {
  const dispatch = useDispatch();
  useEffect(() => {
    dispatch(getAppartmentsAction());
  }, [dispatch]);
  const appartments = useSelector((state) => state.appartments.appartments).map(
    (appartment, index) => <Appartment key={index} appartment={appartment} />
  );
  return (
    <div>
      <h1>Список квартир</h1>
      <div>{appartments}</div>
    </div>
  );
};

export default AppartmentList;
