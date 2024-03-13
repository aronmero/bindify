import { posts } from './posts';
import { categorias } from './categorias';


export const filtros = [
    'Para tí', 'Activos hoy', 'Guardados'
];

/**
 * Devuelve el valor maquetado de los filtros del usuario dependiendo de los gustos de este
 * @date 3/7/2024 - 6:55:57 PM
 * @author 'David Martín Concepción'
 */

export const filtro_parati = () => {
    /* TODO */
    //return posts.filter((post) => post.start_date >= fecha_elegida && post.end_date <= fecha_elegida);
}

/**
 * Cambio de formato de fechas
 * @author 'David Martín Concepción'
 * @date 3/7/2024 - 7:02:37 PM
 * @param {*} dateSQL
 * @returns {string}
 */

export const format_date = (dateSQL) => {
    /* SQL trabaja con formato YYYY-MM-DD */
    /* JavaScript trabaja con MM/DD/YYYY, de ahí el uso de esta función */
    const SQLDATA = dateSQL.split("-");
    const dia = dateSQL[2];
    const mes = dateSQL[1];
    const anio = dateSQL[0];

    return `${mes}/${dia}/${anio}`;
}

/**
 * Devuelve el valor de post que la fecha se encuentra entre esos valores
 * @date 3/7/2024 - 6:56:18 PM
 * @author 'David Martín Concepción'
 * @param {*} fecha_elegida
 * @returns {*}
 */

export const filtro_activos = (fecha_elegida) => {
    let current = new Date(fecha_elegida).getTime();
    // trabaja en formato 
    return posts.filter((post) => new Date(post.start_date).getTime() >= current && new Date(post.end_date).getTime() <= current);
}
/**
 * Obtiene los posts que coinciden con los criterios
 * @author 'David Martín Concepción'
 * @param {*} usuario_municipio 
 * @returns 
 */
export const filtro_cercanos = (usuario_municipio) => {
    return posts.filter((post) => post.usuario.municipality_id)
}

/**
 * Obtiene por gustos similares
 * @date 3/7/2024 - 7:03:16 PM
 * @author 'David Martín Concepción'
 * @param {*} gustos_usuario
 * @returns {*}
 */
export const filtro_similares = (gustos_usuario) => {
    return posts.filter((post) => gustos_usuario.includes(post.usuario.category_id));
}

/**
 * Obtiene los posts por una fecha dada
 * @date 3/7/2024 - 7:12:34 PM
 * @author 'David Martín Concepción'
 * @param {*} date
 * @returns {{}}
 */

export const postsPerDate = (date) => {
    let postList = [];
    posts.forEach((post) => {
        if (post.date_start === date) postList.push(post);
    });

    //console.log(postList);
    return postList;
};

/**
 * Obtiene las fechas de los posts
 * @date 3/7/2024 - 7:12:53 PM
 * @author 'David Martín Concepción'
 * @returns {{}}
 */
export const postsDates = () => {
    let dates = [];
    posts.forEach((post) => {
        dates.push(post.start_date);
    });
    return dates;
};

