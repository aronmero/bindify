<script setup>
import textoEnNegrita from "@/components/textoEnNegrita.vue";
import textoNormal from "@/components/textoNormal.vue";

defineProps({
  "amount": String,
  "tipo": String,
  
});
</script>
<template>
  <div class="flex flex-col">
            <textoEnNegrita :texto="amount" class="text-base md:text-xl" />
            <textoNormal
              :texto="tipo"
              class="text-sm md:text-base"
            ></textoNormal>
          </div>
</template>
<style scoped></style>
