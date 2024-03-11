import {getMunicipalities} from "@/Api/municipios/municipios.js";
import {getPopularHashtags} from "@/Api/popular_hashtags/popular_hashtags.js";

export let locationOptions = [];
export let popularsHastags = [];

export const apiMunicipalitiesRequest = async () => { //fecth para obtener los municipios registrados
    await getMunicipalities("GET").then((response) => {
        locationOptions = response;
    }).catch((error) => {
        console.error("Error al obtener los municipios:", error);
    });
}

export const apiPopularHashtagRequest = async () => { //fecth para obtener los hashtags mas populares
    await getPopularHashtags("GET").then((response) => {
        popularsHastags = response;
    }).catch((error) => {
        console.error("Error al obtener los comercios:", error);
    });
}

export const categoriesOptions = [
    {name : "Restaurante", icon : ".././assets/icons/restaurant.svg"},
    {name : "Botánica", icon : ".././assets/icons/plant.svg"},
    {name : "Joyería", icon : ".././assets/icons/jewelry.svg"},
    {name : "Informática", icon : ".././assets/icons/computer.svg"},
    {name : "Supermercado", icon : ".././assets/icons/supermarket.svg"},
    {name : "Deportes", icon : ".././assets/icons/sport.svg"},
    {name : "Decoración", icon : ".././assets/icons/deco.svg" },
];






