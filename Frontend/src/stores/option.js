import { defineStore } from "pinia";

export const optionSelected = defineStore({
    id : "idOptionSelected",
    state: () =>({
        optionSelected : (""),
        optionSelectedLocation : ("")

    }),
    actions : {
        getOptionSelected(){
            return this.optionSelected;
        },
        setOptionSelected(option){
            this.optionSelected = option; 
        },
        getOptionSelectedLocation(){
            return this.optionSelectedLocation;
        },
        setOptionSelectedLocation(option){
            this.optionSelectedLocation = option; 
        }

    }
})