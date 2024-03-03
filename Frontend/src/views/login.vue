<script setup>
import AuthUsuario from "@/components/Auth/AuthUsuario.vue";
import { useRouter } from "vue-router";
import { useUsuarioStore } from "@/stores/usuario";
import { ref } from "vue";
const router = useRouter();
const store = useUsuarioStore();

let errorMsg = ref(null);
const tryAuthUser = async (userData) => {
  if (userData.email && userData.password) {
    try {
      const response = await fetch("api/v1/usuarios");
      const data = await response.json();

      const usuarioEncontrado = data.usuarios.find(
        (usuario) =>
          usuario.email === userData.email &&
          usuario.password === userData.password
      );

      if (usuarioEncontrado) {
        const userData = {
          id: usuarioEncontrado.id,
          email: usuarioEncontrado.email,
          nombre: usuarioEncontrado.nombre,
        };

        store.login(userData)
        errorMsg.value = "";
        router.push("/home");
      } else {
        errorMsg.value = "Email o contraseña incorrectos.";
      }
    } catch (error) {
      errorMsg.value = "Error";
    }
  }
};
</script>
<template>
  <AuthUsuario titulo="Iniciar sesion" @submit="tryAuthUser" :error="errorMsg" />
</template>