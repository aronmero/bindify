<script setup>
import UserCardFavorite from "@/components/seguidos/userCardFavorites.vue";
import { getUserFollows } from "@/Api/perfiles/perfil.js";
import { setDefaultImgs } from "@/components/perfiles/helpers/defaultImgs";
import { ref } from "vue";

let followsList = ref(null);
let filledFavoritos = ref([]);
async function responseCatcher(metodo, subRuta) {
  followsList.value = await getUserFollows(metodo, subRuta);

  followsList.value = setDefaultImgs(followsList.value);
  for (let i = 0; i < followsList.value.length; i++) {
    if (followsList.value[i].favorito) {
      filledFavoritos.value.push(followsList.value[i]);
    }
  }
}
responseCatcher("get", "/api/follows");
</script>

<template>
  <div class="flex flex-col">
    <div>
      <div
        v-for="(user, index) in filledFavoritos && filledFavoritos"
        :key="index"
      >
        <UserCardFavorite :user="user" />
      </div>
    </div>
  </div>
</template>
