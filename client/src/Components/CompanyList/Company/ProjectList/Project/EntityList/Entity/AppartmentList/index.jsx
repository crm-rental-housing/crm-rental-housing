import React, { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import Appartment from "./Appartment";
import { getAppartmentsAction } from "../../../../../../../../api/actions/appartment";

const AppartmentList = (props) => {
  const dispatch = useDispatch();
  useEffect(() => {
    dispatch(getAppartmentsAction());
  }, [dispatch]);
  const appartments = useSelector((state) => state.appartments.appartments);
  return (
    <div>
      <h1>Список квартир</h1>
      {appartments ? (
        <>
          {props.entity ? (
            <>
              <div>
                {appartments
                  .filter(
                    (appartment) => appartment.entity_id === props.entity.id
                  )
                  .map((appartment, index) => (
                    <Appartment key={index} appartment={appartment} />
                  ))}
              </div>
            </>
          ) : (
            <>
              <div>
                {appartments.map((appartment, index) => (
                  <Appartment key={index} appartment={appartment} />
                ))}
              </div>
            </>
          )}
        </>
      ) : (
        <>
          <div>Квартир нет</div>
        </>
      )}
    </div>
  );
};

export default AppartmentList;
