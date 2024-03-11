<script setup>
    import Grid from "@/components/comun/layout.vue";
    import Header from "@/components/comun/header.vue";
    import Footer from "@/components/comun/footer.vue";
    import Menu from "@/components/search/menu.vue";
    import SearchBar from "@/components/search/searchBar.vue";
    import commercesResults from "@/components/search/commercesResults.vue";
    import useSearchLogic from "@/utils/searchLogic";
    import {categoriesOptions, locationOptions} from "@/data/menuData.js";
    import hashtagSection from "@/components/search/hashtagSection.vue";
    import scrollUpButton from "@/components/comun/scrollUpButton.vue";
    import Filter from "@/components/search/filter.vue";
    

    const {filteredCommerces} = useSearchLogic();


</script>

<template>
    <Header />
    <Grid><template v-slot:Left> </template>
        <div class="flex flex-col gap-y-8 rounded-md p-2 ">
           <div class="flex items-center gap-x-2">
                <SearchBar />
                <Filter />
           </div>
            <hashtagSection />
            <Menu title="categorias" :menuOptions="categoriesOptions"/>
            <Menu title="localizaciones" :menuOptions="locationOptions" />
            <p class="text-[#c6c6c6] mb-[-10px] text-md ml-2 ">{{ filteredCommerces.length > 1 ? filteredCommerces.length + " comercios encontrados" : filteredCommerces.length === 0 ? "Sin resultados" :  filteredCommerces.length +  " comercio encontrado" }}</p>
            <commercesResults :comercios="filteredCommerces" id="results" />
            <scrollUpButton />
          
        </div>
        <template v-slot:Right>  </template>
    </Grid>
    <Footer />
</template>

<style scoped>
    html{
        scroll-behavior: smooth;
    }
   
    
</style>

