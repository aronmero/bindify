<script setup>
    import { ref, onMounted, computed } from 'vue';
    import getUsers from "@/data/randomUser.js";
    import UserCard from "@/components/seguidos/userCard.vue";
    import InputSearch from "../../components/comun/inputSearch.vue";
   

    const users = ref([]);

    onMounted(async () => {
        users.value = await getUsers();
    });

    

</script>

<template>
    <div class="flex flex-col">
      <InputSearch  />
      <div v-for="(user, index) in users" :key="index">
        <UserCard 
          :image="user.picture.thumbnail"
          :name="user.name.first"
        />
      </div>
    </div>
  </template>
