import axios from "@/api/axios.ts";
import type {BaseInformation} from "@/types/user/BaseInformation.ts";

export const updateUserBaseInformation = async (baseInformationData: BaseInformation) => {
  const { data } = await axios.post('/update/user', baseInformationData);

  return data;
}
