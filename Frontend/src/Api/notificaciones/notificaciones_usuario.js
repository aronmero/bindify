//Pillar de sesion storage o store de pinia cuando se realice
import { genOptionsWithoutBody,urlApi } from "@/Api/api.js";

/**
 * Devuelve la notificación por consola del estado actual de la petición
 * @date 3/10/2024 - 12:10:35 PM
 * @author Aarón Medina Rodríguez - 
 * "Realizado por Aaron, adaptado para notificaciones por "
 * @author David Martín Concepción
 * @export
 * @async
 * @param {Number} id de la notificacion
 * @returns {Object}
 */
export async function getNotificacion() {
  try {
    const options = genOptionsWithoutBody("GET");
    const response = await fetch(
      `${urlApi}/api/notifications/`,
      options
    );
    const data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
  }
}

/**
 * Marca como vista una notificacion
 * @date 3/13/2024 - 10:42:21 PM
 * @author Aarón Medina Rodríguez 
 * @export
 * @async
 * @param {Number} id de la notificacion
 * @returns {Object}
 */
export async function vistoNotificacion(id) {
  try {
    const options = genOptionsWithoutBody("POST");
    const response = await fetch(
      `${urlApi}/api/notifications/${id}`,
      options
    );
    const data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
  }
}


/**
 * Elimina una notificacion
 * @date 3/13/2024 - 11:14:15 PM
 * @author Aarón Medina Rodríguez
 *
 * @export
 * @async
* @param {Number} id de la notificacion
 * @returns {Object}
 */
export async function deleteNotificacion(id) {
  try {
    const options = genOptionsWithoutBody("DELETE");
    const response = await fetch(
      `${urlApi}/api/notifications/${id}`,
      options
    );
    const data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
  }
}
