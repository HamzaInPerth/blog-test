import axiosInstance from '@/api/AxiosIntance'
import { type IUserRegistration, type IUserLogin } from '@/interfaces/UserInterfaces'
import { type IAuthCheck } from '@/interfaces/ApiResponseInterface'

export const checkAuthStatus = async (): Promise<IAuthCheck> => (await axiosInstance.get('/auth/check'))?.data

export const loginUser = async (credentials: IUserLogin) => await axiosInstance.post('/auth/user/login', credentials)

export const loginAdmin = async (credentials: IUserLogin) => await axiosInstance.post('/auth/admin/login', credentials)

export const registerUser = async (userData: IUserRegistration) => await axiosInstance.post('/auth/register', userData)
