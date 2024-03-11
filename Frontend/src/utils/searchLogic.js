import { ref, watch, computed } from 'vue';
import { optionSelected } from "@/stores/option";
import { inputSearch } from '@/stores/inputSearch';
import comercios from "@/data/comerciosData.js";

//logica para buscar comercios por categorías
export default function useSearchLogic() {
    let category = ref(optionSelected().getOptionSelected()); //creamos una referencia reactiva para la categoría
    let location = ref(optionSelected().getOptionSelectedLocation()); //creamos una referencia reactiva para la localización
    let searchValue = ref(inputSearch().getInputSearch()); //creamos una referencia reactiva para la búsqueda (input de búsqueda

    watch(() => optionSelected().getOptionSelected(), (newValue) => { //observamos el cambio de la categoría
        category.value = newValue; //actualizamos la categoría
    });

    watch(() => optionSelected().getOptionSelectedLocation(), (newValue) => { //observamos el cambio de la localización
        location.value = newValue; //actualizamos la localización
    });

    watch(() => inputSearch().getInputSearch(), (newValue) => { //observamos el cambio de la búsqueda
        searchValue.value = newValue; //actualizamos la búsqueda
    });

    const filteredCommerces = computed(() => {
        if(searchValue.value !== ""){
            if(category.value !== "" && location.value !== "" ){
                return comercios.filter(comercio => comercio.category === category.value && comercio.location === location.value && comercio.name.toLowerCase().includes(searchValue.value.toLowerCase()));
            }else if(location.value !== ""){
                return comercios.filter(comercio => comercio.location === location.value && comercio.name.toLowerCase().includes(searchValue.value.toLowerCase()));
            }else if(category.value !== ""){
                return comercios.filter(comercio => comercio.category === category.value && comercio.name.toLowerCase().includes(searchValue.value.toLowerCase()));
            }
            return comercios.filter(comercio => comercio.name.toLowerCase().includes(searchValue.value.toLowerCase()));
        }else{
            if(category.value !== "" && location.value !== "" ){
                return comercios.filter(comercio => comercio.category === category.value && comercio.location === location.value);
            }else if(location.value !== ""){
                return comercios.filter(comercio => comercio.location === location.value);
            }else if(category.value !== ""){
                return comercios.filter(comercio => comercio.category === category.value);
            }
            return comercios;
        }
        
        
    });

    const getCategories = computed(() => {
        let categories = [];
        comercios.forEach(comercio => {
            if (!categories.includes(comercio.category)) {
                categories.push(comercio.category);
            }
        });
        return categories;
    });

    let option = optionSelected();

    const selectedOption = (name, type) => {
        if (type === 'categorias') { // Si es una categoria
            if (option.getOptionSelected() === name) { // si ya esta selecccionada
                option.setOptionSelected(''); // Se deselecciona
                return;
            }
            option.setOptionSelected(name); // si no esta seleccionada, se selecciona
        } else if (type === 'localizaciones') { // Si es una localizacion
            if (option.getOptionSelectedLocation() === name) { // Si ya esta seleccionada
                option.setOptionSelectedLocation(''); // Se deselecciona
                return;
            }
            option.setOptionSelectedLocation(name); // Se selecciona la localizacion
        }
    }


    return {
        category,
        filteredCommerces,
        getCategories,
        selectedOption
    };
}

