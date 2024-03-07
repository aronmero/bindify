<script setup>
import { RouterLink } from "vue-router";
</script>

<template>
  <footer
    class="h-[50px] w-full bg-background-50 flex px-[10px] justify-around fixed bottom-0 lg:hidden z-50"
  >
    <nav class="w-[50px] flex justify-center items-center">
      <RouterLink to="/">
        <img
          src="/assets/icons/home.svg"
          class="max-w-[20px] max-h-[20px]"
        />
      </RouterLink>
    </nav>
    <nav class="w-[50px] flex justify-center items-center">
      <RouterLink to="/">
        <img
          src="/assets/icons/search.svg"
          class="max-w-[20px] max-h-[20px]"
      /></RouterLink>
    </nav>
    <nav class="w-[50px] flex justify-center items-center">
      <RouterLink to="/">
        <img
          src="/assets/icons/schedule.svg"
          class="max-w-[20px] max-h-[20px] "
      /></RouterLink>
    </nav>
    <nav class="w-[50px] flex justify-center items-center">
      <RouterLink to="/">
        <img
          src="/assets/icons/user.svg"
          class="max-w-[20px] max-h-[20px] "
      /></RouterLink>
    </nav>

  </footer>
</template>

<style scoped></style>
