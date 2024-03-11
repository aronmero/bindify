<script setup>

    import filterSVG from '/assets/icons/filter.svg';
</script>


<template>
    <div class="p-2 rounded-full transition duration-200 ease-in hover:scale-110 hover:bg-[#e3e3e3] cursor-pointer">
        <img class="size-6" :src="filterSVG" alt="filter">
    </div>
</template>