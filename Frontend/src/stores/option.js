import { defineStore } from "pinia";

export const optionSelected = defineStore({
    id : "idOptionSelected",
    state: () =>({
        optionSelected : (""),
        optionSelectedLocation : (""),
        optionSelectedHashtag : ("")

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
        },
        getOptionSelectedHashtag(){
            return this.optionSelectedHashtag;
        },
        setOptionSelectedHashtag(option){
            this.optionSelectedHashtag = option; 
        }

    }
})