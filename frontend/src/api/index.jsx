import axios from "axios";

function axiosInstance(token = "") {
  let auth = localStorage.getItem("auth");

  const axiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    headers: { Authorization: `Bearer ${auth}` },
  });

  axiosInstance.interceptors.response.use(
    function (response) {
      return response;
    },
    function (error) {
      if (401 === error?.response?.status) {
        localStorage.clear();
        window.location.href = "/login";
      }

      return Promise.reject(error);
    }
  );

  return axiosInstance;
}

export default axiosInstance;
