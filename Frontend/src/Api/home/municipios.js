import { urlApiHome as urlApi, genOptions, genOptionsWithoutBody } from "../api";


/**
 * Devuelve los posts por municipios
 * @date 3/12/2024 - 6:22:13 PM
 *
 * @export
 * @async
 * @returns {unknown}
 */
export async function obtener_posts_municipios() {
    const options = genOptionsWithoutBody('GET');
    const user = JSON.parse(sessionStorage.getItem("usuario"));
    const token = user.usuario.token;

    let data = await fetch(`${urlApi}/api/home_calendario`, {
        method: 'GET',
        headers: {
          "Content-Type": "application/json",
          "User-Agent": "insomnia/8.6.0",
          Accept: "application/json",
          Authorization: `Bearer ${token}`,
        }
    })
        .then(res => res.json())
        .then(res => res);
    return data;
}

/**
 * Devuelve el listado de todos los municipios
 * @date 3/12/2024 - 6:22:28 PM
 *
 * @export
 * @async
 * @returns {unknown}
 */
export async function obtener_municipios() {
    const options = genOptionsWithoutBody('GET');
    const user = JSON.parse(sessionStorage.getItem("usuario"));
    const token = user.usuario.token;

    let data = await fetch(`${urlApi}/api/municipality`, {
        method: 'GET',
        headers: {
          "Content-Type": "application/json",
          "User-Agent": "insomnia/8.6.0",
          Accept: "application/json",
          Authorization: `Bearer ${token}`,
        }
    })
        .then(res => res.json())
        .then(res => res);
    return data;
}

