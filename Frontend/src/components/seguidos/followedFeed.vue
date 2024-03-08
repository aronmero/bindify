<script setup>
    import { ref, onMounted } from 'vue';
    import getUsers from "@/data/randomUser.js";
    import UserCard from "@/components/seguidos/userCard.vue";

    const users = ref([]);

    onMounted(async () => {
        users.value = await getUsers();
    });

</script>

<template>
    <div class="flex flex-col">
      <div v-for="(user, index) in users" :key="index">
        <UserCard 
          :image="user.picture.thumbnail"
          :name="user.name.first"
        />
      </div>
    </div>
  </template>
