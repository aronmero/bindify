//Pillar de sesion storage o store de pinia cuando se realice
import { genOptions, urlApi } from "@/Api/api.js";

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
export async function getUserData(metodo,body=null) {
    const user = JSON.parse(sessionStorage.getItem("usuario"));
    console.log(user)
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(`${urlApi}/api/profile`, options);
      const data = await response.json();
      //sessionStorage.setItem("userData",JSON.stringify({ userData: data.data }))
      console.log("hola")
      return data.data;
    } catch (error) {
      console.error(error);
    }
  }
export async function getUserPosts(metodo,body=null) {
    // const user = JSON.parse(sessionStorage.getItem("usuario"));
    // console.log(user)
    try {
      const options = genOptions(metodo,body);
      const response = await fetch(`${urlApi}/api/home`, options);
      const data = await response.json();
      sessionStorage.setItem("userData",JSON.stringify({ userData: data.data }))
      console.log(data.data)
      return data.data;
    } catch (error) {
      console.error(error);
    }
  }
