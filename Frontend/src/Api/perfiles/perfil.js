//Pillar de sesion storage o store de pinia cuando se realice
import { genOptions } from "@/Api/api.js";
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
export async function getUserData(metodo, ruta,body=null) {
    const user = JSON.parse(sessionStorage.getItem("usuario"));
    console.log(user)
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(`${ruta}/${user.usuario.username}?=`, options);
      const data = await response.json();
      return data.data;
    } catch (error) {
      console.error(error);
    }
  }
export async function getUserPosts(metodo, ruta,body=null) {
    const user = JSON.parse(sessionStorage.getItem("usuario"));
    console.log(user)
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(`${ruta}/${user.usuario.username}?=`, options);
      const data = await response.json();
      return data.data;
    } catch (error) {
      console.error(error);
    }
  }