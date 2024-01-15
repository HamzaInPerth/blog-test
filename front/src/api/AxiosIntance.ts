import axios from 'axios'

async function getCsrfToken() {
  try {
    await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie');
  } catch (error) {
    console.error('Error fetching CSRF token:', error);
    throw error;
  }
}

const api = axios.create({
  withCredentials: true,
  baseURL: 'http://127.0.0.1:8000/api/',
  timeout: 5000,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'Access-Control-Allow-Origin': 'true'
  }
})

api.interceptors.request.use((config) => {
  getCsrfToken()
  return config
})

export default api

