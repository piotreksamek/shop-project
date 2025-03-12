import axios from './axios.ts'
import type {ProductCreate} from "@/types/product/ProductCreate.ts";
import type {ProductDetail} from "@/types/product/ProductDetail.ts";

export const createProduct = async (productData: ProductCreate) => {
    const { data } = await axios.post('/products', productData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });

    return data;
}

export const getProductsList = async() => {
    const { data } = await axios.get('/products/list');

    return data.data;
}

export const getProductDetail = async(id: string | string[]): Promise<ProductDetail> => {
  const { data } = await axios.get(`/products/${id}`);

  return data.data;
}
