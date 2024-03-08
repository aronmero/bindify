<script setup>
  import commercesResults from "@/components/search/commercesResults.vue";
  import comercios from "@/data/comerciosData";
</script>
<template>
  <commercesResults :comercios="comercios"></commercesResults>
</template>
<style scoped></style>
