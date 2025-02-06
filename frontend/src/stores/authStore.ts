import {defineStore} from 'pinia';
import VueCookies from 'vue-cookies'
import {getUser, loginUser} from "@/api/security.ts";

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
  }),
  actions: {
    async login(credentials: any) {
        const data = await loginUser(credentials);

        VueCookies.set('auth_token', data.token, '1h')

        await this.fetchUser()
    },
    async fetchUser() {
      this.user = await getUser();
    },
    async logout() {
        VueCookies.remove('auth_token')
        this.user = null;
    },
  },
});

export const isAuthenticated = () => {
  return VueCookies.get('auth_token') !== null;
};
