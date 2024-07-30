import axios from "axios";

const baseURL = `${process.env.REACT_APP_SERVER_HOST}/${process.env.REACT_APP_SERVER_PORT}`;

const useAxios = () => {
  const axiosInstance = axios.create({
    baseURL,
    headers: { Authorization: `Bearer ${current_user?.access_token}` },
  });

  axiosInstance.interceptors.request.use(
    async (req) => {
      if (currentUser.access_token_expires_in) {
        if (currentUser.refresh_token_expires_in) {
          const response = await axios.post(`${baseURL}/api/refresh`, {
            refresh_token: currentUser.refresh_token,
          });

          const refresh_user = {
            ...current_user,
            access_token: response.data.access_token.token,
            access_token_expires_in: response.data.access_token.expires_in,
            refresh_token: response.data.refresh_token.token,
            refresh_token_expires_in: response.data.refresh_token.expires_in,
          };
          dispatch(loginSuccess(refresh_user));
          req.headers.Authorization = `Bearer ${response.data.access_token.token}`;
          return req;
        } else {
          dispatch(logoutAction(currentUser));
          return req;
        }
      } else {
        return req;
      }
    },
    (err) => {
      return Promise.reject(err);
    }
  );
  return axiosInstance;
};

export default useAxios;
