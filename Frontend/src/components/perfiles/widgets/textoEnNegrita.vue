<script setup>
defineProps({
  texto: String,
});
</script>
<template>
  <button class="font-bold leading-normal cursor-pointer">{{ texto }}</button>
</template>
<style scoped></style>
