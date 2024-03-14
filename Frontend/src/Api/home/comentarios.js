import { genOptions, urlApi,genOptionsWithoutBody } from "@/Api/api.js";

/**
 * Devuelve los comentarios de una publicacion
 * @date 3/11/2024 - 4:08:05 PM
 * @author Aaron Medina Rodriguez - David Martín Concepción
 *
 * @export
 * @async
 * @param {number} id de la publicacion
 * @returns {Object}
 */
export async function obtener_comentarios(id) {
  try {
    const options = genOptions("GET", null);
    const response = await fetch(`${urlApi}/api/comment/${id}`, options);
    const data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
  }
}

/**
 * Almacena un comentario en una publicacion
 * @date 3/11/2024 - 5:25:58 PM
 * @author Aaron Medina Rodriguez
 *
 * @export
 * @async
 * @param {number} id de la publicacion
 * @returns {Object}
 */
export async function guardar_comentario(body) {
  try {
    const options = genOptions("POST", body);
    const response = await fetch(`${urlApi}/api/comment`, options);
    const data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
  }
}


/**
 * Almacena un comentario en una publicacion
 * @date 3/13/2024 - 11:04:45 AM
 * @author Aaron Medina Rodriguez - David Martín 
 *
 * @export
 * @async
 * @param {number} id de la publicacion
 * @returns {Object}
 */
export async function borrar_comentario(id) {
  try {
    const options = genOptionsWithoutBody("DELETE");
    const response = await fetch(`${urlApi}/api/comment/${id}`, options);
    const data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
  }
}
