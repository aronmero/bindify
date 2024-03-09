import { ref, watch, computed } from 'vue';
import { optionSelected } from "../stores/option";
import comercios from "@/data/comerciosData.js";

//logica para buscar comercios por categorías
export default function useSearchLogic() {
    let category = ref(optionSelected().getOptionSelected());

    watch(() => optionSelected().getOptionSelected(), (newValue) => {
        category.value = newValue;
    });

    const filteredCommerces = computed(() => {
        return comercios.filter(comercio => comercio.category === category.value);
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


    return {
        category,
        filteredCommerces,
        getCategories
        
    };
}

