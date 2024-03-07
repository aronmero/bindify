<script setup>
    import Grid from "@/components/comun/layout.vue";
    import Header from "@/components/comun/header.vue";
    import Footer from "@/components/comun/footer.vue";
    import searchBar from "@/components/search/searchBar.vue";
    import selectCategory from "@/components/search/selectCategory.vue";
    import locationButton from "@/components/search/locationButton.vue"
    import searchButton from "@/components/search/searchButton.vue";
    import Menu from "@/components/search/menu.vue";
    import commercesResults from "../components/search/commercesResults.vue";
    import useSearchLogic from "../utils/searchLogic";

    const {filteredCommerces} = useSearchLogic();

   
    

</script>

<template>
    <Header />
    <Grid><template v-slot:Left> Left</template>
        <form class="flex flex-col gap-y-8 ">
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
            <Menu  />
            <p class="text-[#bdbdbd]  mb-[-10px] ">{{ filteredCommerces.length > 1 ? filteredCommerces.length + " comercios encontrados" : filteredCommerces.length === 0 ? "Sin resultados" :  filteredCommerces.length +  " comercio encontrado" }}</p>
            <commercesResults :comercios="filteredCommerces" />
        </form>
        <template v-slot:Right> Right </template>
    </Grid>
    <Footer />
</template>

<style scoped>


</style>


