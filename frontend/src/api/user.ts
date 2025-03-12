import axios from '@/api/axios.ts'
import type { User } from '@/types/user/User.ts'
import type { BaseInformation } from '@/types/user/BaseInformation.ts'

export const updateUser = async (baseInformation: BaseInformation) => {
  const { data } = await axios.post('/user/update', baseInformation)

  return data
}

export const getUserInformation = async (): Promise<User> => {
  const { data } = await axios.get('/user/data')

  return data.data.user
}
