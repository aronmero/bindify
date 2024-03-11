//ruta para obtener todos los municipios registrados
import { genOptions,urlApi } from "@/Api/api.js";

export async function getPopularHashtags(metodo,body=null) {
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(
        `${urlApi}/api/hashtag`,
        options
      );
      const data = await response.json();
      return data.data;
    } catch (error) {
      console.error(error);
    }
  }