//ruta para obtener todos los municipios registrados
import { genOptions,urlApi } from "@/Api/api.js";

export async function getFollows(metodo,body=null) {
    try {
      const options = genOptions(metodo,body);
      const url = new URL(`${urlApi}/api/follows`);
      console.log(url);
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