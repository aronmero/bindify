<script setup>
    defineProps({
        image : String,
        name : String
    })

    import FollowButton from './followButton.vue';

</script>


<template>
    <div class="flex items-center justify-between p-4">
        <div class="flex items-center gap-x-2 cursor-pointer">

            <img :src="image" alt="image-profile" class="size-20 rounded-full" v-if="image">
            <div class="flex flex-col items-start">
                <h4 v-if="name" >{{ name }}</h4>
                <p class="text-[#8f8f8f] text-[18px] font-normal" v-if="name">{{ "@" + name.toLowerCase() }}</p>
            </div>
            
        </div>
        <FollowButton />
    </div>
</template>


<style scoped>


</style>