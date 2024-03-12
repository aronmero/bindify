<script setup>
    import Grid from "@/components/comun/layout.vue";
    
    import Header from "@/components/comun/header.vue";
    import Footer from "@/components/comun/footer.vue";

    import FeedPosts from "../components/feed_media/Posts.vue";

    /* Trends */
    import TrendsOfertas from "../components/feed_media/widgets/TrendsOfertas.vue";
    import TrendsComercios from "../components/feed_media/widgets/TrendsComercios.vue";

</script>

<template >
    <Header />
    <div class=" feed-wrap relative ">
        <Grid>
            <template v-slot:Left  >
                <!-- Se listan los trends de la barra de navegación izquierda -->
                <!-- <TrendsOfertas  v-if="true"/> -->
                
            </template>
                <Suspense>
                    <FeedPosts  />
                </Suspense>
            <template v-slot:Right>
                <!-- Se listan los trends de la barra de navegación derecha -->
                <!-- <TrendsComercios  v-if="true"/> -->
            </template>
        </Grid>
    </div>
    <Footer />
</template>

<style scoped lang="scss">

</style>
