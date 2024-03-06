<script setup>
const titulo = "TodoJardín";
const categoria = "Floristeria";
</script>

<template>
  <div class="flex flex-row gap-[5px] items-center p-[10px]">
    <img src="https://placehold.co/35x35/png" class="rounded-full" />
    <div class=" flex flex-row w-full justify-between">
      <div class=" flex flex-col justify-center">
        <div class="font-bold">{{ titulo }}</div>
        <div>{{ categoria }}</div>
      </div>

      <div class=" flex flex-row justify-center items-center">
        <div >true</div>
        <div>false</div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
