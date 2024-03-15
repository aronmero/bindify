<script setup>
defineProps({
  texto: String,
});
</script>
<template>
  <button class="leading-normal cursor-default bg-gray-200 rounded-md p-1">
    {{ texto }}
  </button>
</template>
<style scoped></style>
