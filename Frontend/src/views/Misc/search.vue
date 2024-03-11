<script setup>
    import Grid from "@/components/comun/layout.vue";
    import Header from "@/components/comun/header.vue";
    import Footer from "@/components/comun/footer.vue";
    import Menu from "@/components/search/menu.vue";
    import SearchBar from "@/components/search/searchBar.vue";
    import commercesResults from "@/components/search/commercesResults.vue";
    import useSearchLogic from "@/utils/searchLogic";
    import {categoriesOptions, locationOptions, popularsHastags, apiMunicipalitiesRequest, apiPopularHashtagRequest} from "@/data/menuData.js";
    import hashtagSection from "@/components/search/hashtagSection.vue";
    import scrollUpButton from "@/components/comun/scrollUpButton.vue";
    import changeSearchButton from "@/components/search/changeSearchButton.vue";
    import Filter from "@/components/search/filter.vue";
    import { onMounted, ref } from 'vue';
    
    const {filteredCommerces, apiRequest} = useSearchLogic();
    let section = ref("comercios");

    onMounted(async() => {
        apiRequest();
        apiMunicipalitiesRequest();
        apiPopularHashtagRequest();
    })

    const changeSection = (actualSection) =>{
        section.value = actualSection;
    }

    
</script>

<template>
    <Header />
    <Grid><template v-slot:Left> </template>
        <div class="flex flex-col gap-y-8 rounded-md p-2 ">
           <div class="flex items-center gap-x-2">
                <SearchBar :placeholder="section" />
                <Filter />
           </div>
            <hashtagSection :popularsHastags="popularsHastags" v-if="section === 'comercios'"/>
            <hashtagSection :popularsHastags="popularsHastags" v-if="section === 'hashtags'"/>
            <Menu title="categorias" :menuOptions="categoriesOptions" v-if="section === 'comercios'" />
            <Menu title="localizaciones" :menuOptions="locationOptions" v-if="section === 'comercios'" />
            <p class="text-[#c6c6c6] mb-[-10px] text-md ml-2 " v-if="section === 'comercios'">{{ filteredCommerces.length > 1 ? filteredCommerces.length + " comercios encontrados" : filteredCommerces.length === 0 ? "Sin resultados" :  filteredCommerces.length +  " comercio encontrado" }}</p>
            <commercesResults :comercios="filteredCommerces" id="results" v-if="section === 'comercios'"/>
            <scrollUpButton />
            <changeSearchButton @changeSection="changeSection"/>
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

