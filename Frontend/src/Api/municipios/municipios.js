//ruta para obtener todos los municipios registrados
import { genOptions,urlApiHome } from "@/Api/api.js";

export async function getMunicipalities(metodo,body=null) {
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(
        `${urlApiHome}/api/municipality`,
        options
      );
      const data = await response.json();
      return data.data;
    } catch (error) {
      console.error(error);
    }
  }