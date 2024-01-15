// store/auth.ts

import { defineStore } from 'pinia';
import { checkAuthStatus } from '../services/AuthService';
import { type IUser } from '@/interfaces/UserInterfaces';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as IUser | null,
    admin: false as boolean,
  }),
  actions: {
    async checkAuthentication() {
      try {
        const { user, admin } = await checkAuthStatus();
        this.user = user;
        this.admin = admin;
      } catch (error) {
        console.error('Error checking user authentication:', error);
      }
    },

    setUser(user: IUser | null) {
      this.user = user;
    },

    logout() {
      this.user = null;
      this.admin = false;
    },
  },
});
