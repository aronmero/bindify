<script setup>
import btnConImg from "@/components/perfiles/widgets/btnConImg.vue";
import btnConText from "@/components/perfiles/widgets/btnConText.vue";
import { RouterLink } from "vue-router";
</script>
<template>
  <div class="flex justify-center items-center gap-4">
    <RouterLink to="/perfil/edit">
      <btnConText
        texto="EDIT PROFILE"
        class="transition hover:bg-accent-400 ease-linear hover:text-text-50"
      ></btnConText>
    </RouterLink>
    <RouterLink to="/tarjeta-fidelidad">
      <btnConImg
        ruta="/assets/icons/qrCode.svg"
        altText="icono codigo qr"
        :borde="true"
      ></btnConImg>
    </RouterLink>
  </div>
</template>
<style scoped></style>
