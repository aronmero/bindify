
import { random } from "../helpers/random";

/**
 * Exporta estadisticas de comercios maquetados
 * @date 3/7/2024 - 3:31:25 PM
 * @author 'David Martín Concepción'
 * @type {{}}
 */
export const comercios = [
    {
        id: 1,
        usuario: {
            name: 'comercio_1',
            avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
            tipo: 'comercio'
        },
        schedule: " 01:00 a 15:00 - Lunes \n 02:00 a 15:00 - Lunes(T) \n 03:00 a 15:00 - Martes \n 04:00 a 15:00 - Miércoles \n 05:00 a 15:00 - Jueves \n 06:00 a 15:00 - Viernes \n Cerrado a Cerrado - Sábado \n  Cerrado a Cerrado - Domingo",
        rating: 4.9,
        votes: 120,
    },
    {
        id: 2,
        usuario: {
            name: 'comercio_2',
            avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
            tipo: 'comercio'
        },
        rating: 4.8,
        schedule: " 08:00 a 15:00 - Lunes \n 08:00 a 15:00 - Lunes(T) \n 08:00 a 15:00 - Martes \n 08:00 a 15:00 - Miércoles \n 08:00 a 15:00 - Jueves \n 08:00 a 15:00 - Viernes \n Cerrado a Cerrado - Sabado \n  Cerrado a Cerrado - Domingo",
        votes: 109,
    },
    {
        id:3,
        usuario: {
            name: 'comercio_3',
            avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
            tipo: 'comercio'
        },
        rating: 4.3,
        schedule: " 08:00 a 15:00 - Lunes \n 08:00 a 15:00 - Lunes(T) \n 08:00 a 15:00 - Martes \n 08:00 a 15:00 - Miércoles \n 08:00 a 15:00 - Jueves \n 08:00 a 15:00 - Viernes \n Cerrado a Cerrado - Sabado \n  Cerrado a Cerrado - Domingo",
        votes: 89,
    },
    {
        id:4,
        usuario: {
            name: 'comercio_4',
            avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
            tipo: 'comercio'
        },
        rating: 3.1,
        schedule: " 08:00 a 15:00 - Lunes \n 08:00 a 15:00 - Lunes(T) \n 08:00 a 15:00 - Martes \n 08:00 a 15:00 - Miércoles \n 08:00 a 15:00 - Jueves \n 08:00 a 15:00 - Viernes \n Cerrado a Cerrado - Sabado \n  Cerrado a Cerrado - Domingo",
        votes: 56,
    },
    {
        id: 5,
        usuario: {
            name: 'comercio_5',
            avatar: `https://randomuser.me/api/portraits/men/${random(91)}.jpg`,
            tipo: 'comercio'
        },
        rating: 3.2,
        schedule: " 08:00 a 15:00 - Lunes \n 08:00 a 15:00 - Lunes(T) \n 08:00 a 15:00 - Martes \n 08:00 a 15:00 - Miércoles \n 08:00 a 15:00 - Jueves \n 08:00 a 15:00 - Viernes \n Cerrado a Cerrado - Sabado \n  Cerrado a Cerrado - Domingo",
        votes: 43,
    }
];

export const encontrar_comercio = (comercio_id) => {
    let encontrado = null;
    comercios.forEach(element => {
        if(element.id == comercio_id) encontrado = element;
    });
    return encontrado;
}

export const obtener_rango_horarios = (comercio_id) => {

    let comercio = encontrar_comercio(comercio_id);
    let exportar = null;
    if(comercio != null) {
        let schedule = comercio.schedule;

        let semana = schedule.split(/\n| (?=a)|(?<=a) |-/);
        let filtrado = semana.filter((intervalo) => intervalo != "a" && intervalo.trim() !== " ");
        exportar = []

        for (let index = 0; index < filtrado.length; index++) {
            if(index % 3 == 0) {
                exportar.push({
                    hora_apertura: filtrado[index].trim(),
                    hora_cierre: filtrado[index + 1].trim(),
                    dia: filtrado[index + 2].trim()
                })
            }
        }
        return exportar;
    }
    
}

export const filtrar_rango_horarios = (datos_string) => {

    let exportar = [];
    if(datos_string != null) {

        let semana = datos_string.split(/\n| (?=a)|(?<=a) |-/);
        let filtrado = semana.filter((intervalo) => intervalo != "a" && intervalo.trim() !== " " && intervalo.trim() !== "");
        exportar = []

        console.log(filtrado)

        for (let index = 0; index < filtrado.length; index++) {
            if(index % 3 == 0) {
                exportar.push({
                    hora_apertura: filtrado[index].trim(),
                    hora_cierre: filtrado[index + 1].trim(),
                    dia: filtrado[index + 2].trim()
                })
            }
        }
       
    }

    return exportar;
    
}

export const pasar_a_string_horario = (array_objeto) => {
    let string_final = "";

    if(array_objeto.length >= 1) {
        /* formato: 08:00 a 15:00 - Lunes \n     */
        array_objeto.forEach(intervalo => {
            string_final += ` ${intervalo.hora_apertura} a ${intervalo.hora_cierre} - ${intervalo.dia} \n`;
        });
        return string_final;
    }

    string_final = "Debes introducir al menos un intervalo."
}