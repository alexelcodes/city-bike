import axios from "axios";

const axiosInstance = axios.create({
  baseURL: "http://localhost:80/api", // Route requests to api.php for localhost
  // baseURL: "/api", // Route requests to api.php based on the .htaccess rule for hosting
  headers: {
    "Content-Type": "application/json",
  },
});

export default axiosInstance;
