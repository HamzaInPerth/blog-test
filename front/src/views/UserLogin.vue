<template>
    <div>
      <form @submit.prevent="handleLogin" class="col-md-4 container mt-5">
        <div class="form-group mb-4">
          <h4>User Login</h4>
        </div>
        <div class="form-group mb-4">
          <label for="email">Email address</label>
          <input type="email" v-model="login.email" class="form-control" id="email"
            aria-describedby="emailHelp" placeholder="Enter email">
        </div>
        <div class="form-group mb-4">
          <label for="password">Password</label>
          <input type="password" v-model="login.password" class="form-control" id="password"
            placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary">Log In</button>
        <div v-if="errorMessage" class="alert alert-danger mt-3">
          {{ errorMessage }}
        </div>
      </form>
  
      <!-- Registration link for new users -->
      <div class="text-center mt-3">
        Don't have an account? <router-link to="/user/register">Register</router-link>
      </div>
    </div>
  </template>
  
  <script lang="ts">
  import { loginUser } from '@/services/AuthService'
  import { type IUserLogin } from '@/interfaces/UserInterfaces'
  import { useAuthStore } from '@/stores/AuthStore'

  
  export default {
    data() {
      return {
        login: {
          email: 'natasha.padberg@example.com',
          password: 'password'
        } as IUserLogin,
        errorMessage: null as string | null
      }
    },
    methods: {
      async handleLogin() {
        try {
          this.errorMessage = null
          const response = await loginUser(this.login)
  
          console.log('Login successful: redirect...', response)
          this.login.email = ''
          this.login.password = ''
          // SET USER IN STORE
          // REDIRECT
        } catch (error) {
          // this.login.password = ''
          console.error('Login failed:', error)
          this.errorMessage = 'Login failed. Please check your credentials.'
        }
      },
      async checkLogging() {
        const authStore = useAuthStore()
        await authStore.checkAuthentication()
      }
    },
    created() {
      this.checkLogging()
    }
  }
  </script>
  