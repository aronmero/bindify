import { genOptions, urlApiHome } from "@/Api/api.js";

/**
 * Devuelve los comentarios de una publicacion
 * @date 3/11/2024 - 4:08:05 PM
 * @author Aaron Medina Rodriguez
 *
 * @export
 * @async
 * @param {number} id de la publicacion
 * @returns {Object}
 */
export async function getCommentsOfPost(id) {
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
export async function storeCommentsOfPost(body) {
  try {
    const options = genOptions("POST", body);
    const response = await fetch(`${urlApi}/api/comment`, options);
    const data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
  }
}
