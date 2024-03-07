<script setup>
    import { ref } from 'vue';
    import Grid from "@/components/comun/layout.vue";
    import Header from "@/components/comun/header.vue";
    import Footer from "@/components/comun/footer.vue";
    import searchBar from "@/components/search/searchBar.vue";
    import selectCategory from "@/components/search/selectCategory.vue";
    import locationButton from "@/components/search/locationButton.vue"
    import searchButton from "@/components/search/searchButton.vue";
    import Menu from "@/components/search/menu.vue";
    import commercesResults from "../components/search/commercesResults.vue";

    let option = ref("Botánica"); //categoria por defecto

    const selectedOption = (name) =>{
        option.value = name;
    }

</script>

<template>
    <Header />
    <Grid><template v-slot:Left> Left</template>
        <div class="flex flex-col gap-y-4">
            <div class="flex items-center flex-wrap gap-y-4 gap-x-3">
                <searchBar />
                <selectCategory />
                <locationButton />
                <searchButton />
                <div class="flex items-center gap-x-1 cursor-pointer">
                    <p class="text-[#A19E9E] font-semibold">Filtrar</p>
                    <img src="/assets/icons/filter.svg">
                </div>
            </div>
            <Menu @selectedOption="selectedOption" />
            <commercesResults :category="option" :key="option"/>
        </div>
        <template v-slot:Right> Right </template>
    </Grid>
    <Footer />
</template>

<style scoped>


</style>


