import { type IUser } from './UserInterfaces'
export interface IAuthCheck {
    user: IUser|null,
    admin: boolean
}