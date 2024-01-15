import { type IUser } from './UserInterfaces'

export interface IArticle {
    id: number,
    title: string,
    content: string
    user?: IUser
}

export interface ICreateArticle {
    title: string,
    content: string
}