<template>
    <div>
      <form @submit.prevent="handleRegistration" class="col-md-4 container mt-5">
        <div class="form-group mb-4">
          <h4>User Registration</h4>
        </div>
        <div class="form-group mb-4">
          <label for="email">Email address</label>
          <input type="email" v-model="newUser.email" class="form-control" id="email" aria-describedby="emailHelp"
            placeholder="Enter email">
        </div>
        <div class="form-group mb-4">
          <label for="username">Username</label>
          <input type="text" v-model="newUser.username" class="form-control" id="username" placeholder="Username">
        </div>
        <div class="form-group mb-4">
          <label for="password">Password</label>
          <input type="password" v-model="newUser.password" class="form-control" id="password"
            placeholder="Password">
        </div>
        <div class="form-group mb-4">
          <label for="password_confirmed">Confirm password</label>
          <input type="password" v-model="newUser.password_confirmed" class="form-control" id="password_confirmed"
            placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
        <div v-if="errorMessage" class="alert alert-danger mt-3">
          {{ errorMessage }}
        </div>
      </form>
  
      <!-- Login link -->
      <div class="text-center mt-3">
        Already have an account ? <router-link to="/user/login">Login In</router-link>
      </div>
    </div>
  </template>
  
  <script lang="ts">
  import { registerUser } from '@/services/AuthService'
  import { type IUserRegistration } from '@/interfaces/UserInterfaces'
  
  export default {
    data() {
      return {
        newUser: {
          username: '',
          email: '',
          password: '',
          password_confirmed: ''
        } as IUserRegistration,
        errorMessage: null as string | null
      }
    },
    methods: {
      async handleRegistration() {
        if (this.validateForm()) {
          try {
            this.errorMessage = null
            const response = await registerUser(this.newUser)
  
            console.log('Registration successful:', response)
            this.resetForm()
          } catch (error) {
            console.error('Registration failed:', error)
            this.errorMessage = 'Registration failed. Please try again.'
          }
        }
      },
      validateForm() {
        const { email, username, password, password_confirmed } = this.newUser
        if (!email || !username || !password || !password_confirmed) {
          this.errorMessage = 'All fields are required.'
          return false
        }
        return true
      },
      resetForm() {
        this.newUser.username = ''
        this.newUser.email = ''
        this.newUser.password = ''
        this.newUser.password_confirmed = ''
      }
    }
  }
  </script>
  