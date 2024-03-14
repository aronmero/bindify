<script setup>
import textoEnNegrita from "@/components/perfiles/widgets/textoEnNegrita.vue";
import textoNormal from "@/components/perfiles/widgets/textoNormal.vue";
import imgRedonda from "@/components/perfiles/widgets/imgRedonda.vue";
import contenedorPuntuacion from "@/components/perfiles/containers/contenedorPuntuacion.vue";
import { ref } from "vue";
const userData = JSON.parse(sessionStorage.getItem("userData"));
const userLogeado = JSON.parse(sessionStorage.getItem("usuario"));
defineProps({
  rutaPerfil: String,
  nombre: String,
  texto: String,
  puntuacion: String,
  fecha: String,
  titulo: String,
  imagen: String,
  imagenAltText: String,
  id: String,
});
const estilos = {
  post: " w-[100%] min-h-[800px] flex flex-col overflow-hidden ",
  post_avatar: "",
  modal:
    " absolute bg-white min-w-[200px] rounded-lg p-2 flex flex-col items-start justify-center ",
  modal_button: " flex items-center font-medium w-[100%]  ",
  modal_superior_dcha: " top-[100px] right-[20px] ",
};

let response = ref(null);
async function responseCatcher(metodo, subRuta) {
  response.value = await borrarPost(metodo, subRuta);
  console.log(response.value);
  router.go();
}
function clickBorrarResenia(evento) {
  if (confirm("Estas seguro de que quieres borrar la resenia ?")) {
    // responseCatcher("delete", `/api/post/${props.post.post_id}`);
  }
}
</script>
<template>
  <div class="flex flex-col border-b">
    <div class="flex justify-start">
      <imgRedonda :ruta="rutaPerfil"></imgRedonda>
      <div class="flex flex-col">
        <textoEnNegrita :texto="nombre" class="text-base lg:text-xl" />

        <textoNormal :texto="fecha" class="text-sm lg:text-base"></textoNormal>
      </div>
      <div class="flex justify-end w-full">
        <contenedorPuntuacion :puntuacion="puntuacion"></contenedorPuntuacion>
      </div>
    </div>
    <div class="flex flex-col">
      <textoEnNegrita :texto="titulo" class="text-base lg:text-xl" />
      <textoNormal
        :texto="texto"
        class="text-sm lg:text-base pb-2"
      ></textoNormal>
      <img :src="imagen" :alt="imagenAltText" class="scale-90" />
    </div>
    Modal de Ver Más
    <!-- <div
      ref="modal"
      :id="`modal_${id}`"
      :class="`modal ${estilos.modal} ${estilos.modal_superior_dcha}`"
      v-if="
        userLogeado.usuario.tipo == 'customer' &&
        userLogeado.usuario.username == nombre
      "
    > -->
    <!-- Botón eliminar post -->

    <!-- <button
        :class="`${estilos.modal_button} m-2 `"
        @click="clickBorrarResenia"
        :id="id"
      >
        <img class="w-[30px] h-[30px] mr-3" :src="StarSVG" />
        Eliminar
      </button>
    </div> -->
  </div>
</template>
<style scoped></style>
