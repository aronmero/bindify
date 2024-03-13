<script setup>

    import hashtag from "@/components/search/hashtag.vue";


    defineProps({
        popularsHastags : Array,
        sectionTitle : String
    })
   
    
</script>


<template>
 
    <div class="flex flex-wrap  items-center gap-x-2 gap-y-2">
        <div v-for="(hashtag, index) in popularsHastags" :key="index">
            <hashtag :name="hashtag.name" :type="'hashtag'" />
        </div>
    </div>
</template>