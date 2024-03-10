<script setup>
defineProps({
  titulo: String,
});
</script>
<!-- w-[90vw] -->
<template>
  <header class="flex items-center relative justify-center">
    <button class="lg:hidden absolute left-0">
      <img src="/assets/icons/forward.svg" alt="Boton para volver atras" />
    </button>
    <h3 class="lg:text-xl font-bold">{{ titulo }}</h3>
  </header>
</template>
<style scoped></style>
