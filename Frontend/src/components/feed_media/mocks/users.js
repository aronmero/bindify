import { random } from "../helpers/random";

export const users = [
    {
        id:1, 
        name: 'particular_1',
        avatar: `https://randomuser.me/api/portraits/women/3.jpg`,
        tipo: 'particular'
    },
    {
        id:2,
        name: 'comercio_1',
        avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
        tipo: 'comercio',
        rating: 3.2
    },
    {
        id:3,
        name: 'comercio_3',
        avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
        tipo: 'comercio',
        rating: 3.8
    },
    {
        id:4,
        name: 'comercio_4',
        avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
        tipo: 'comercio',
        rating: 3.1
    },
    {
        id:5,
        name: 'comercio_5',
        avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
        tipo: 'comercio',
        rating: 2.5
    },
    {
        id:6,
        name: 'comercio_6',
        avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
        tipo: 'comercio',
        rating: 4.1
    },
    {
        id:6,
        name: 'comercio_7',
        avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
        tipo: 'comercio',
        rating: 4.3
    },
    {
        id:7,
        name: 'ayuntamiento',
        avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
        tipo: 'ayuntamiento',
        rating: 4.9
    },
];

export const encontrar_usuario_por_id = (usuario_id) => {
    let encontrado = false;
    users.forEach(usuario => {
        if(usuario.id == usuario_id) encontrado = usuario;
    })
    console.log(encontrado);
    return encontrado;
}