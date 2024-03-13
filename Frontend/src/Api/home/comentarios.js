import { urlApi as urlApi, genOptions, genOptionsWithoutBody } from "../api";

export async function obtener_posts_seguidos() {
    const options = genOptionsWithoutBody('GET');
    let data = await fetch(`${urlApi}/api/home`, options)
        .then(res => res.json())
        .then(res => res);
    return data;
}

export async function obtener_comentarios_post(post_id) {
    const options = genOptionsWithoutBody('GET');
    const user = JSON.parse(sessionStorage.getItem("usuario"));
    const token = user.usuario.token;

    let data = await fetch(`${urlApi}/api/comment/${post_id}`, options)
        .then(res => res.json())
        .then(res => res);
    return data;
    
}

/**
 * Agrega un comentario por post
 * @date 3/11/2024 - 7:03:00 PM
 *
 * @export
 * @async
 * @param {*} post_id
 * @param {*} user_name
 * @returns {unknown}
 */

export async function agregar_comentario_post(post_id, comentario, id_padre = null) {

    const user = JSON.parse(sessionStorage.getItem("usuario"));
    const token = user.usuario.token;

    let data = await fetch(`${urlApi}/api/comment/`, {
        method: 'POST',
        headers: {
          "Content-Type": "application/json",
          "User-Agent": "insomnia/8.6.0",
          Accept: "application/json",
          Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify({
            comment_id: comment_id,
            content: comentario,
            post_id: post_id
        })
    })
        .then(res => res.json())
        .then(res => res)
        
    return data;
}

