import {defineStore} from 'pinia';
import VueCookies from 'vue-cookies'
import {getUser, loginUser} from "@/api/security.ts";
import type {LoginType} from "@/types/security/LoginType.ts";

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
  }),
  actions: {
    async login(credentials: LoginType) {
      const data = await loginUser(credentials);

      VueCookies.set('auth_token', data.token, '1h');
      VueCookies.set('refresh_token', data.refresh_token, '7d');

      await this.fetchUser()
    },
    async fetchUser() {
      let response = await getUser();

      this.user = response.data

      return response.data;
    },
    logout() {
      VueCookies.remove('auth_token');
      VueCookies.remove('refresh_token');

      this.user = null;
    },
  },
});

export const isAuthenticated = () => {
  return VueCookies.get('auth_token') !== null;
};
