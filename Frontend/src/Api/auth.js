import { urlApi } from "@/Api/api.js";
export async function login(email,pass) {
  try {
    const options = genOptionsLogin("POST");
    const response = await fetch(
      `${urlApi}/api/login?email=${email}&password=${pass}`,
      options
    );
    const data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
  }
}
export async function register(datos) {
  try {
    let formData = new FormData();
    for(let clave in datos){
        if(clave == 'avatar'){
            formData.append(clave, datos[clave], 'avatar');
        }else{
            formData.append(clave, datos[clave]);
        }
    }
    /* const datos = JSON.stringify(datosRecibidos); */
    const options = genOptionsRegister("POST", formData);
    const response = await fetch(
      `${urlApi}/api/register`,
      options
    );
    const data = await response.json().then(response => console.log(response));
    return data;
  } catch (error) {
    console.error(error);
  }
}
/**
 * Genera unas opciones para hacer una peticion a una api. Obtiene un token del SessionStorage
 * @date 3/10/2024 - 5:32:48 PM
 * @author Aarón Medina Rodríguez
 *
 * @param {String} metodo POST, GET, PATCH, DELETE
 * @returns {{ method: any; headers: { "Content-Type": string; "User-Agent": string; Accept: string; Authorization: string; } }}
 */
const genOptionsLogin = (metodo) => {
  return {
    method: metodo,
    headers: {
      "Content-Type": "application/json",
      "User-Agent": "insomnia/8.6.0",
      "Accept": "application/json"
    }
  };
};
export const genOptionsRegister = (metodo, body = null) => {
  return {
    method: metodo,
    headers: {
      "User-Agent": "insomnia/8.6.0",
      "Accept": "application/json",
    },
    body: body,
  };
};