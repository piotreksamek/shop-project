import axios from 'axios';
import VueCookies from 'vue-cookies'

const api = axios.create({
  baseURL: 'http://localhost:8080/api',
  headers: {
    'Content-Type': 'application/json',
  }
});

api.interceptors.request.use(
  config => {
    const token = VueCookies.get('auth_token');
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);

api.interceptors.response.use(
  response => response,
  error => {
    if (error.response) {
      if (error.response.status === 401) {
        // Odswiezanie tokenu tu bedzie
      }
      return Promise.reject(error.response.data);
    }
    return Promise.reject(error);
  }
);

export default api;
