<script setup>
import { RouterLink } from "vue-router";
</script>

<template>
  <header class="h-[50px] bg-background-300 flex fixed top-0 justify-between px-[10px] w-full z-50">
    <nav class="w-[50px] flex justify-center items-center">
        <RouterLink to="/"> <img
        src="https://placehold.co/35x35/png"
        class="max-w-[35px] max-h-[35px] rounded-full"
      /> </RouterLink>
    </nav>
    <div class="flex">
      <nav class="w-[50px] flex justify-center items-center">
        <RouterLink to="/busqueda">
          <img
            src="/assets/icons/search.svg"
            class="max-w-[30px] max-h-[30px] hidden lg:block"
        /></RouterLink>
      </nav>
      <nav class="w-[50px] flex justify-center items-center">
        <RouterLink to="/calendario">
          <img
            src="/assets/icons/schedule.svg"
            class="max-w-[30px] max-h-[30px] hidden lg:block"
        /></RouterLink>
      </nav>
      <nav class="w-[50px] flex justify-center items-center">
        <RouterLink to="/">
          <img
            src="/assets/icons/user.svg"
            class="max-w-[30px] max-h-[30px] hidden lg:block"
        /></RouterLink>
      </nav>
      <nav class="w-[50px] flex justify-center items-center">
        <RouterLink to="/">
          <img src="/assets/icons/bell.svg" class="max-w-[30px] max-h-[30px]"
        /></RouterLink>
      </nav>
      <nav class="w-[50px] flex justify-center items-center">
        <RouterLink to="/">
          <img
            src="/assets/icons/settings.svg"
            class="max-w-[30px] max-h-[30px]"
        /></RouterLink>
      </nav>
    </div>
  </header>
</template>

<style scoped></style>
