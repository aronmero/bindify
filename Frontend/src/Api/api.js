//Pillar de sesion storage o store de pinia cuando se realice
const token = "1|LNSPOK5hwyhzxAYXbplfM1nlvB1yj8aOU11O3rTR0e414f0e";

//Util para metodo get,delete
const genOptions = (metodo) => {
  return {
    method: metodo,
    headers: {
      "User-Agent": "insomnia/8.6.0",
      Accept: "application/json",
      Authorization: `Bearer ${token}`,
    },
  };
};

//Util para metodo put, patch, store
const genOptions2 = (metodo,body) => {
  return {
    method: metodo,
    headers: {
      "Content-Type": "application/json",
      "User-Agent": "insomnia/8.6.0",
      Accept: "application/json",
      Authorization: `Bearer ${token}`,
    },
    body: body,
  };
};

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
export async function postShow(metodo, id) {
  try {
    const options = genOptions(metodo);
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
