//Pillar de sesion storage o store de pinia cuando se realice
import { genOptionsWithoutAuth,urlApi } from "@/api/api.js";
/**
 * Devuelve el listado de categorías
 * @date 3/11/2024 - 16:36:35 PM
 * @author Antonio José Peñuela López
 *
 * @export
 * @async
 * @returns {Object}
 */
export async function solicitarCategorias(metodo) {
  try {
    const options = genOptionsWithoutAuth(metodo);
    const response = await fetch(
      `${urlApi}/api/category`,
      options
    );
    const data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
  }
}
export async function solicitarMunicipios(metodo) {
  try {
    const options = genOptionsWithoutAuth(metodo);
    const response = await fetch(
      `${urlApi}/api/municipality`,
      options
    );
    const data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
  }
}