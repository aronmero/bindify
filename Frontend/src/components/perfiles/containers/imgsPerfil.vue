<script setup>
import imgRectangular from "@/components/perfiles/widgets/imgRectangular.vue";
import imgRedonda from "@/components/perfiles/widgets/imgRedonda.vue";
const props = defineProps({
  rutaBaner: String,
  altTextBaner: String,
  rutaPerfil: String,
  altTextPerfil: String,
});
</script>
<template>
  <div v-if="props.rutaBaner != ''" class="relative flex justify-center">
    <imgRectangular :ruta="rutaBaner" :altText="altTextBaner" />
    <div class="flex justify-center items-end absolute bottom-0 left-0 w-full">
      <imgRedonda :ruta="rutaPerfil" :altText="altTextPerfil" class="" />
    </div>
  </div>
  <div class="relative" v-if="props.rutaBaner == ''">
    <!-- <imgRectangular :ruta="rutaBaner" :altText="altTextBaner" /> -->
    <div class="flex justify-center items-end w-full">
      <imgRedonda
        :ruta="rutaPerfil"
        :altText="altTextPerfil"
        
      />
    </div>
  </div>
</template>
<style scoped></style>
