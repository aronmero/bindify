<script setup>
    defineProps({
        user : Object
    })

    import FollowButton from './followButton.vue';

</script>


<template>
    <div class="flex items-center justify-between p-4 cursor-pointer transition-colors duration-300 hover:bg-[#eeeeee] rounded-md">
        <div class="flex items-center gap-x-2">
            <img :src="user.avatar" alt="image-profile" class="size-20 rounded-full" v-if="user">
            <div class="flex flex-col items-start">
                <h4 v-if="user" >{{ user.username }}</h4>
                <p class="text-[#8f8f8f] text-[18px] font-normal hidden" v-if="user">{{ "@" + user.username.toLowerCase() }}</p>
            </div>
            
        </div>
        <FollowButton :user="user" />
    </div>
</template>


<style scoped>


</style>