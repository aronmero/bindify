import {defineStore} from "pinia";

export const inputSearch = defineStore({
    id : "idInputSearch",
    state: () =>({
        searchValue : ("")
    }),
    actions : {
        getInputSearch(){
            return this.searchValue;
        },
        setInputSearch(input){
            this.searchValue = input; 
        }
    }
})