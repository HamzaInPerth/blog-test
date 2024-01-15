export interface IUserRegistration {
    name: string,
    username: string,
    email: string,
    password: string,
    password_confirmed: string
}

export interface IUserLogin {
    email: string,
    password: string
}

export interface IUser {
    id: number,
    name: string,
    username: string,
    email: string,
}