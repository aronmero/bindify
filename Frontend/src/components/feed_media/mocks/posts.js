import { random } from "../helpers/random";
import { lorem } from "../helpers/lorem";

import {categorias} from "./categorias";

/**
 * Retorna un array de prueba
 * @author 'David Martín Concepción'
 * @date 3/6/2024 - 5:46:22 PM
 * 
 * @type {{}}
 */


/**
 * Etiqueta de tipos
 * @date 3/7/2024 - 3:36:25 PM
 * @default [{1:Oferta|2:Evento}]
 */

export const posts = [
    {
        id: 1,
        title: "Titulo de #2",
        description: `${lorem}`,
        post_type_id: 1, /* evento he puesto 2 */
        usuario: {
            nombre: 'comercio_1',
            avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
            tipo: 'comercio',
            municipality_id: 1,
            category_id: 1
        },
        image: 'https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        fecha_publicacion: "2/19/2024",
        /* Formato es YYYY-MM-DD */
        start_date: '2024-03-07',
        end_date: '2024-03-15',
        likes: 1,
        rating: 2,
    },
    {
        id: 2,
        title: "Titulo de ejemplo",
        description: `${lorem}`,
        post_type_id: 1,
        usuario: {
            nombre: 'comercio',
            avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
            tipo: 'comercio',
            municipality_id: 2,
            category_id: 3
        },
        image: 'https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        fecha_publicacion: "2/19/2024", /* fecha formato mes/dias/año  */
        destacado: true,
        institucional: false,
        start_date: '2024-03-07',
        end_date: '2024-03-15',
        likes: 0,
        rating: 4.9
    },
    {
        id: 3,
        title: "Titulo de ejemplo",
        description: `${lorem}`,
        post_type_id: 2, /* evento he puesto 2 */
        usuario: {
            nombre: 'ayuntamiento',
            avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
            tipo: 'ayuntamiento',
            municipality_id: 3,
            category_id: 6
        },
        image: 'https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        fecha_publicacion: "2/19/2024",
        destacado: true,
        start_date: '2024-03-07',
        end_date: '2024-03-15',
        institucional: true
    }
];




export const obtener_tipo = (tipo_id) => {
    let found = null;
    posts.some((post) =>  {
        if (post.post_type == tipo_id) found = p 
    });
    return found;
}


