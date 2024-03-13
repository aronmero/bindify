import {getMunicipalities} from "@/Api/municipios/municipios.js";
import {getPopularHashtags} from "@/Api/popular_hashtags/popular_hashtags.js";
import {getCategories} from "@/Api/categorias/categorias.js";
import {ref} from "vue";

export let locationOptions = ref([]);
export let popularsHastags = ref([]);
export let categoriesOptions = ref([]);
export const tiposPost = [
    {name : "Post"},
    {name : "Evento"}
]

export const apiMunicipalitiesRequest = async () => { //fecth para obtener los municipios registrados
    await getMunicipalities("GET").then((response) => {
        locationOptions.value = response;
    }).catch((error) => {
        console.error("Error al obtener los municipios:", error);
    });
}

export const apiPopularHashtagRequest = async (type) => { //fecth para obtener los hashtags mas populares
    await getPopularHashtags("POST", type).then((response) => {
        popularsHastags.value = response;
    }).catch((error) => {
        console.error("Error al obtener los hashtags:", error);
    });
}

export const apiCategoriesRequest = async () => { //fecth para obtener las categorias registradas
    await getCategories("GET").then((response) => {
        categoriesOptions.value = response;
    }).catch((error) => {
        console.error("Error al obtener las categorias:", error);
    });
}






