
import { random } from "../helpers/random";

/**
 * Exporta estadisticas de comercios maquetados
 * @date 3/7/2024 - 3:31:25 PM
 * @author 'David Martín Concepción'
 * @type {{}}
 */
export const comercios = [
    {
        usuario: {
            name: 'comercio_1',
            avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
            tipo: 'comercio'
        },
        rating: 4.9,
        votes: 120,
    },
    {
        usuario: {
            name: 'comercio_2',
            avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
            tipo: 'comercio'
        },
        rating: 4.8,
        votes: 109,
    },
    {
        usuario: {
            name: 'comercio_3',
            avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
            tipo: 'comercio'
        },
        rating: 4.3,
        votes: 89,
    },
    {
        usuario: {
            name: 'comercio_4',
            avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
            tipo: 'comercio'
        },
        rating: 3.1,
        votes: 56,
    },
    {
        usuario: {
            name: 'comercio_5',
            avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
            tipo: 'comercio'
        },
        rating: 3.2,
        votes: 43,
    }
];
