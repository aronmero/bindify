<script setup>
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";
import FollowedFeed from "@/components/seguidos/followedFeed.vue";


</script>

<template>
    <Header />
    <Grid><template v-slot:Left> </template>
        <div class="text-center m-4 font-bold text-2xl">Seguidos</div>
    
        <div class="w-full md:w-3/4 m-auto" >
        <div class="text-center text-2xl font-semibold">
            <FollowedFeed />
        </div>

        </div>
        <template v-slot:Right>  </template>
    </Grid>
    <Footer />
</template>

<style scoped></style>
