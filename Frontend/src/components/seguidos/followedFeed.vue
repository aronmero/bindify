<script setup>
    import UserCard from "@/components/seguidos/userCard.vue";
    import InputSearch from "./inputSearchAdaptado.vue";
    import { searchByFilter } from "./followedSearchLogicAdaptado.js";
    import {usersAux, loading, followedListAux, fetchUsers} from "@/utils/followedSearchLogic.js";
    import { onMounted } from "vue";

    onMounted(async() => {
      await fetchUsers();
    });
import { getUserFollows } from "@/Api/perfiles/perfil.js";
import { setDefaultImgs } from "@/components/perfiles/helpers/defaultImgs";
import { ref } from "vue";


let followsList = ref(null); 

async function responseCatcher(metodo, subRuta) {
  followsList.value = await getUserFollows(metodo, subRuta);
  
  followsList.value = setDefaultImgs(followsList.value);
}
responseCatcher("get", "/api/follows");

</script>

<template>
    <div class="flex flex-col">

      <div>
        <div v-for="(user, index) in  followsList && followsList" :key="index">
          <UserCard 
            :user="user"

          />
        </div>
      </div>

    </div>
  </template>
