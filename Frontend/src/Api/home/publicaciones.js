import { urlApi, genOptions, genOptionsWithoutBody } from "../api";

export async function obtener_posts_seguidos() {
    const options = genOptionsWithoutBody('GET');
    let data = await fetch(`${urlApi}/api/home`, options)
        .then(res => res.json())
        .then(res => res);
    return data;
}

export async function obtener_posts() {
    const options = genOptionsWithoutBody('GET');
    const user = JSON.parse(sessionStorage.getItem("usuario"));
    const token = user.usuario.token;

    try {
        let data = await fetch(`${urlApi}/api/home_todos`, {
            method: 'GET',
            headers: {
                "Content-Type": "application/json",
                "User-Agent": "insomnia/8.6.0",
                Accept: "application/json",
                Authorization: `Bearer ${token}`,
            }
        }).then(res => res.json())
            .then(res => res)
            .catch(err => {
                console.error(err)
            })

        return data;
    } catch (error) {
        console.error(error);
    }

}

export async function obtener_tipo_comercio(comercio_username) {
    const options = genOptionsWithoutBody('GET');
    const user = JSON.parse(sessionStorage.getItem("usuario"));
    const token = user.usuario.token;

    let data = await fetch(`${urlApi}/api/user/${comercio_username}`, options)
        .then(res => res.json())
        .then(res => res);

    return data;

}
/**
 * UPDATE DE POST
 * @date 3/14/2024 - 2:57:22 PM
 *
 * @export
 * @async
 * @param {*} post_id
 * @param {*} body
 * @returns {unknown}
 */
export async function actualizar_posts(post_id, body) {
    /**
     * Actualiza los posts
     * @date 3/14/2024 - 2:49:27 PM
     * @requires
     * 'image' => 'string', // Imagen del post
     * 'title' => 'required|string|max:255', // Titulo del post
     * 'description' => 'string|max:300', // Descripción del post
     * 'post_type_id' => 'required|integer', // Id de tipo de publicación
     * 'start_date' => 'date|after_or_equal:today', // Fecha en la que inicia el evento
     * 'end_date' => 'date|after:start_date', // Fecha en la que termina el evento
     */
    const options = genOptions('PUT', body);

    const user = JSON.parse(sessionStorage.getItem("usuario"));
    const token = user.usuario.token;

    let formData = new FormData();

    /** Los añade dentro del formdata para poder enviar la imagen */
    for (const key in body) {
        formData.append(key, body[key]);
    }

    let data = await fetch(`${urlApi}/api/post/${post_id}?_method=PUT`, {
        method: 'POST',
        headers: {
            //"Content-Type": "application/json",
            "User-Agent": "insomnia/8.6.0",
            Accept: "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: formData
    })
        .then(res => res.json())
        .then(res => res)
        .catch(err => {
            console.error(err)
        })


    return data;
}