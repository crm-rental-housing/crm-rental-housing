import { jwtDecode } from "jwt-decode";

export const setToken = (token) => {
  if (token) {
    localStorage.setItem("access_token", token);
  }
};

export const getToken = () => {
  const token = localStorage.getItem("access_token");
  if (token && token !== "undefined") {
    const decoded = jwtDecode(token);
    const currentTime = new Date().getTime() / 1000;

    if (decoded && currentTime < decoded.exp) {
      return token;
    }
  }
  return null;
};

export const removeToken = () => {
  localStorage.removeItem("access_token");
};
