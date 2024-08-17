import React, { useEffect, useState } from "react";
import { getDealsAction } from "../../api/actions/deal";

const DealList = () => {
  const [deals, setDeals] = useState(null);
  useEffect(() => {
    const fetchData = async () => {
      const data = await getDealsAction();
      if (data.deals) {
        setDeals(data.deals);
      } else {
        console.log(data.message);
      }
    };
    fetchData();
  }, []);
  return (
    <div>
      {deals ? (
        <>
          {deals.map((deal, index) => (
            <>
              <div>
                {deal.employee.first} {deal.employee.last}
              </div>
              <div>
                {deal.client.first} {deal.client.last}
              </div>
              <div>{deal.payment_type}</div>
              <div>
                {deal.appartment.address.city} {deal.appartment.address.street}{" "}
                {deal.appartment.address.house}
              </div>
            </>
          ))}
        </>
      ) : (
        <>Сделок нет</>
      )}
    </div>
  );
};

export default DealList;
