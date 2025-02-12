import axios from 'axios';
import VueCookies from 'vue-cookies'
import { useAuthStore } from '@/stores/authStore';

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
  async error => {
    const authStore = useAuthStore();

    if (error.response && error.response.status === 401) {
      const refreshToken = VueCookies.get('refresh_token');

      if (refreshToken) {
        try {
          const response = await axios.post(
            'http://localhost:8080/api/token/refresh',
            {
              refresh_token: refreshToken
            });

          const newToken = response.data.token;

          VueCookies.set('auth_token', newToken, '1h');

          error.config.headers['Authorization'] = `Bearer ${newToken}`;

          return axios(error.config);
        } catch (refreshError) {
          authStore.logout();

          return Promise.reject(refreshError);
        }
      } else {
        authStore.logout();
      }
    }
    return Promise.reject(error);
  }
);

export default api;
