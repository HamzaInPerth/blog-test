import axiosInstance from '@/api/AxiosIntance'

export const fetchUserList = (page: number = 1) => axiosInstance.get(`/users/list?page=${page}`)

export const deleteUser = () => axiosInstance.delete('/auth/user')

