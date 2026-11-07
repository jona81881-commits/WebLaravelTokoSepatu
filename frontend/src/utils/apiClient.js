import axios from "axios";

const apiClient = axios.create({
  baseURL: "http://127.0.0.1:8000/api",
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

// Token diambil dari localStorage (disimpan saat login)
apiClient.interceptors.request.use((config) => {
  let token = null;
  try {
    token = localStorage.getItem("token");
  } catch {
    token = null;
  }
  if (token) {
    config.headers.Authorization = "Bearer " + token;
  }
  return config;
});

export default apiClient;