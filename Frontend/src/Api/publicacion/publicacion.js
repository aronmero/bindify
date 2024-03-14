//Pillar de sesion storage o store de pinia cuando se realice
import { genOptions,urlApi,genOptionsUpdate } from "@/Api/api.js";
/**
 * Devuelve un objeto publicacion con sus datos
 * @date 3/10/2024 - 12:10:35 PM
 * @author Aarón Medina Rodríguez
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
      `${urlApi}/api/post/${id}`,
      options
    );
    const data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
  }
}

/**
 * Devuelve un objeto publicacion con sus datos
 * @date 3/13/2024 - 15:10:35 PM
 * @author Antonio José Peñuela López
 *
 * @export
 * @async
 * @returns {Object}
 */
export async function crearPublicacion(metodo, body) {
  try {
    let formData = new FormData();
    for(let clave in body){
      formData.append(clave, body[clave]);
    }
    const options = genOptionsUpdate(metodo, formData);
    const response = await fetch(
      `${urlApi}/api/post`,
      options
    );
    const data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
  }
}
