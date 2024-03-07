<script setup>
    import searchSVG from "/assets/icons/search.svg";

</script>


<template>
    <button class="bg-white p-2 rounded-full shadow-md transition-scale duration-300 hover:scale-105">
        <img :src="searchSVG" class="size-6" />
    </button>
</template>