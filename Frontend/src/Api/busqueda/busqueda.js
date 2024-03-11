import { genOptions,urlApi } from "@/Api/api.js";

export async function getCommerces(metodo,body=null,) {
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(
        `${urlApi}/api/search/commerces`,
        options
      );
      const data = await response.json();
      return data.data;
    } catch (error) {
      console.error(error);
    }
  }

  