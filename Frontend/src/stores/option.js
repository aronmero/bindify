import { defineStore } from "pinia";


export const optionSelected = defineStore({
    id : "idOptionSelected",
    state: () =>({
        optionSelected : ("Botánica"),
    }),
    actions : {
        getOptionSelected(){
            return this.optionSelected;
        },
        setOptionSelected(option){
            this.optionSelected = option; 
        }
    }
})