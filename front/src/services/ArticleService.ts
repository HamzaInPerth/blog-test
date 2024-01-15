import axiosInstance from '@/api/AxiosIntance'
import { type ICreateArticle, type IArticle } from '@/interfaces/ArticleInterface'

export const fetchArticles = async (page: number = 1): Promise<T> => (await axiosInstance.get(`articles?page=${page}`)).data

export const getOneArticle = async (id: number): Promise<T> => (await axiosInstance.get(`articles/${id}`)).data

export const fetchUserArticles = async (username: string, page: number = 1) => (await axiosInstance.get(`blog/${username}?page=${page}`))?.data

export const createPost = async (postData: ICreateArticle) => (await axiosInstance.post('/articles', postData))?.data