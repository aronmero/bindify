<script setup>
defineProps({
  texto: String,
});
</script>
<template>
  <button
    class="px-10 border border-background-200 min-h-6 rounded-md text-xs md:text-base md:min-h-8"
  >
    {{ texto }}
  </button>
</template>
<style scoped></style>
