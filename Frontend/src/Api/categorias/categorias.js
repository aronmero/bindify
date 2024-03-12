import { genOptions,urlApiHome } from "@/Api/api.js";

export async function getCategories(metodo,body=null,) {
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(
        `${urlApiHome}/api/category`,
        options
      );
      const data = await response.json();
      return data.data;
    } catch (error) {
      console.error(error);
    }
}

  