import axios from './axios.ts'
import type {ProductCreate} from "@/types/ProductCreate.ts";

export const createProduct = async (data: ProductCreate) => {
    await axios.post('/products', data);
}
