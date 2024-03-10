//Pillar de sesion storage o store de pinia cuando se realice
import { genOptions } from "@/api/api.js";
/**
 * Devuelve un objeto publicacion con sus datos
 * @date 
 * @author 
 *
 * @export
 * @async
 * @param {Number} id de la publicacion
 * @returns {Object}
 */
export async function postId(metodo, id,body=null) {
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(
        `http://127.0.0.1:8000/api/post/${id}`,
        options
      );
      const data = await response.json();
      return data;
    } catch (error) {
      console.error(error);
    }
  }