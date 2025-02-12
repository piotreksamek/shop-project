import axios from './axios.ts'
import type {RegisterType} from "@/types/security/RegisterType.ts";
import type {LoginType} from "@/types/security/LoginType.ts";

export const createUser = async (data: RegisterType) => {
  const response = await axios.post('/security/register', data);

  return response.data;
}

export const loginUser = async (loginData: LoginType) => {
  const { data } = await axios.post('/login_check', loginData);

  return data;
}

export const getUser = async () => {
  const { data } = await axios.get('/user');

  return data;
}

export const verifyEmail = async (token: string | string[]) => {
  const { data } = await axios.post(`/email/verify`, {
    token: token
  });

  return data;
}
