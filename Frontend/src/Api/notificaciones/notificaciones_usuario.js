//Pillar de sesion storage o store de pinia cuando se realice
import { genOptions,urlApi } from "@/Api/api.js";

/**
 * Devuelve la notificación por consola del estado actual de la petición
 * @date 3/10/2024 - 12:10:35 PM
 * @author Aarón Medina Rodríguez - 
 * "Realizado por Aaron, adaptado para notificaciones por "
 * @author David Martín Concepción
 * @export
 * @async
 * @param {Number} id de la publicacion
 * @returns {Object}
 */

export async function postId(metodo, id,body=null) {
  try {
    const options = genOptions(metodo,body);
    const response = await fetch(
      `${urlApi}/api/notificaciones/${id}`,
      options
    );
    const data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
  }
}
