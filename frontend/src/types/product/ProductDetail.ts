import type {Image} from "@/types/product/Image.ts";

export interface ProductDetail {
  name: string
  description: string
  shortDescription: string|null
  images: Image
}
