import {defineStore} from "pinia";

export const actualSection = defineStore({
    id : "idActualSection",
    state: () =>({
        actualSection : ("comercios")
    }),
    actions : {
        getActualSection(){
            return this.actualSection;
        },
        setActualSection(section){
            this.actualSection = section; 
        }
    }
})