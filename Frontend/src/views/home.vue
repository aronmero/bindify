<script setup>
import Carrusel from "@/components/carrusel.vue";
</script>

<template>
  <div class="flex flex-col items-center">
    <h1
      class="text-white fixed top-0 right-[20px] text-3xl font-bold underline z-10"
    >
      Hello world!
    </h1>

    <!-- Before -->
    <div class="flex gap-10 mb-10 mt-10">
      <button
        class="text-white px-4 sm:px-8 py-2 sm:py-3 bg-sky-700 hover:bg-sky-800"
      >
        ...
      </button>

      <!-- After -->
      <button
        class="text-white px-4 sm:px-8 py-2 sm:py-3 bg-sky-700 hover:bg-sky-800"
      >
        ...
      </button>
    </div>
  </div>
</template>

<style scoped></style>
