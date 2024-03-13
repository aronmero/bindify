<script setup>
    import Grid from "@/components/comun/layout.vue";
    import Header from "@/components/comun/header.vue";
    import Footer from "@/components/comun/footer.vue";
    import Menu from "@/components/search/menu.vue";
    import SearchBar from "@/components/search/searchBar.vue";
    import commercesResults from "@/components/search/commercesResults.vue";
    import useSearchLogic from "@/utils/searchLogic";
    import {categoriesOptions, locationOptions, popularsHastags, tiposPost, apiMunicipalitiesRequest, apiPopularHashtagRequest, apiCategoriesRequest} from "@/data/menuData.js";
    import hashtagSection from "@/components/search/hashtagSection.vue";
    import scrollUpButton from "@/components/comun/scrollUpButton.vue";
    import changeSearchButton from "@/components/search/changeSearchButton.vue";
    import Filter from "@/components/search/filter.vue";
    import { onMounted, ref, watch } from 'vue';
    import { actualSection } from "@/stores/actualSection";
    import postsResults from "@/components/search/postsResults.vue";
    import infoSVG from "/assets/icons/infoSVG.svg";
    
   
    
    const { filteredResults, apiRequest, resetFilters } = useSearchLogic();
    let section = ref("comercios");
    let loading = ref(true);
    let actualSectionAux = actualSection();
    
    onMounted(async () => {
        await fetchData(section.value);
    })

    const changeSection = (actualSection) => {
        section.value = actualSection;
        actualSectionAux.setActualSection(section.value);
    }

    const fetchData = async (sectionValue) => {
        await apiRequest(sectionValue);
        await apiMunicipalitiesRequest();
        await apiPopularHashtagRequest(sectionValue);
        await apiCategoriesRequest();
        loading.value = false;
    }

    watch(section, (newValue) => { // Si cambia la sección, se vuelve a hacer la petición a la API
        loading.value = true;
        resetFilters();
        fetchData(newValue);
    });

</script>

<template>
    <Header />
    <Grid><template v-slot:Left> </template>
        <div class="flex flex-col gap-y-8 rounded-md p-2 ">
           <div class="flex items-center gap-x-2">
                <SearchBar :placeholder="section" />
                <Filter />
           </div>
           <div v-if="loading">
            <div class="absolute inset-0 flex items-center justify-center">
                <h3 class="font-bold text-4xl text-[#fe822f] animate-bounce">Bindify</h3>
            </div>
            </div>
            <div v-else class="flex flex-col justify-center gap-y-8">
                <hashtagSection :popularsHastags="popularsHastags" v-show="section === 'comercios'"/>
                <hashtagSection :popularsHastags="popularsHastags" v-show="section === 'Posts'"/>
                <Menu title="categorias" :menuOptions="categoriesOptions" v-show="section === 'comercios'" />
                <Menu title="localizaciones" :menuOptions="locationOptions" v-show="section === 'comercios'" />
                <Menu title="posts" :menuOptions="tiposPost" v-show="section === 'Posts'" />
                <button @click="resetFilters" class="text-right font-semibold rounded-full text-sm flex-none" id="results">resetear filtros</button>
                <div class="flex items-center gap-x-1">
                    <img :src="infoSVG" alt="info" class="size-4 mt-[11.2px]" />
                    <p class="text-[#c6c6c6] mb-[-10px] text-md " >{{ filteredResults.length > 1 ? filteredResults.length + " " +  section + " encontrados" : filteredResults.length === 0 ? "Sin resultados" :  filteredResults.length +  " comercio encontrado" }}</p>
                </div>
                <commercesResults :comercios="filteredResults" v-show="section === 'comercios'"/>
                <postsResults :posts="filteredResults" v-show="section ==='Posts'" />
            </div>
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