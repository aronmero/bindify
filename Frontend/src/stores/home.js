import { defineStore } from "pinia";
import { ref } from "vue";
export const useHomeStore = defineStore("home", () => {
  const isActivo = ref(false);
  const data = ref([]);

  /**
   * Almancena post
   * @date 3/13/2024 - 8:41:26 AM
   * @author Aarón Medina Rodríguez
   *
   * @param {Object} homeData
   * @returns
   */
  function add(homeData) {
    
    isActivo.value = true;
    data.value = data.value.concat(homeData);
  }


  /**
   * Elimina todos los post
   * @date 2/23/2024 - 4:01:23 PM
   * @author Aaron Medina Rodriguez
   *
   * @returns
   */
  function clear() {
    isActivo.value = false;
    data.value = [];
  }

  return { isActivo, data, add, clear };
});
