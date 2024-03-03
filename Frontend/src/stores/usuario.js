import { defineStore } from "pinia";
import { ref } from "vue";
export const useUsuarioStore = defineStore("usuario", () => {
  const isActivo = ref(false);
  const data = {};

  /**
   * Inicia la sesion de un usuario
   * @date 2/23/2024 - 4:01:19 PM
   * @author Aaron Medina Rodriguez
   *
   * @param {Object} userData
   * @returns
   */
  function login(userData) {
    const datosUsuario = {
      id: userData.id,
      email: userData.email,
      nombre: userData.nombre,
    };
    this.isActivo = true;
    this.data = datosUsuario;
  }
  
  
  /**
   * Cierra la sesion de un usuario
   * @date 2/23/2024 - 4:01:23 PM
   * @author Aaron Medina Rodriguez
   *
   * @returns
   */
  function logout() {
    this.isActivo = false;
    this.data = {};
  }

  return { isActivo, data, login ,logout};
});
