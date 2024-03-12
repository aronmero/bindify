//ruta para obtener todos los municipios registrados
import { genOptions,urlApiHome } from "@/Api/api.js";

export async function getPopularHashtags(metodo, type,body=null) {
    try {
      const options = genOptions(metodo,body);
      const url = new URL(`${urlApiHome}/api/hashtag/trending`);

      url.searchParams.append('type', type);
      const response = await fetch(
        url,
        options
      );
      const data = await response.json();
      return data.data;
    } catch (error) {
      console.error(error);
    }
  }