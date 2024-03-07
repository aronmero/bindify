<script setup>
import btnConImg from "@/components/perfiles/widgets/btnConImg.vue";
import btnConText from "@/components/perfiles/widgets/btnConText.vue";
</script>
<template>
  <div class="flex justify-center items-center gap-4">
    <btnConText texto="EDIT PROFILE"></btnConText>
    <btnConImg
      ruta="/assets/icons/qrCode.svg"
      altText="icono codigo qr"
      :borde="true"
    ></btnConImg>
  </div>
</template>
<style scoped></style>
