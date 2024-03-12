import { urlApiHome as urlApi, genOptions, genOptionsWithoutBody } from "../api";


export async function obtener_posts_municipios() {
    const options = genOptionsWithoutBody('GET');
    const user = JSON.parse(sessionStorage.getItem("usuario"));
    const token = user.usuario.token;

    let data = await fetch(`http://127.0.0.1:8000/api/home_calendario`, {
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

export async function obtener_municipios() {
    const options = genOptionsWithoutBody('GET');
    const user = JSON.parse(sessionStorage.getItem("usuario"));
    const token = user.usuario.token;

    let data = await fetch(`http://127.0.0.1:8000/api/municipality`, {
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

