export interface ProductCreate {
  name: string
  description: string
  shortDescription: string|null
  images: File|Array<any>
}
