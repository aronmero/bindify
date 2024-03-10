<script setup>
    import {popularsHastags} from "@/data/menuData.js";
    import hashtag from "@/components/search/hashtag.vue";


</script>


<template>
    <div class="flex flex-wrap  items-center gap-x-2 gap-y-2">
        <div v-for="(hashtag, index) in popularsHastags" :key="index">
            <hashtag :name="hashtag.name" />
        </div>
    </div>
</template>