import type { BaseInformation } from '@/types/user/BaseInformation.ts'

export interface User {
  email: string
  baseInformation: BaseInformation
}
