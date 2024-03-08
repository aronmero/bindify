<script setup>
import Grid from "@/components/comun/layout.vue";

import Header from "@/components/comun/header.vue";
import Footer from "@/components/comun/footer.vue";
import FollowedFeed from "@/components/seguidos/followedFeed.vue";


</script>

<template>
    <Header />
    <Grid><template v-slot:Left> </template>
        <div class="text-center font-bold text-2xl m-2 ">Seguidos</div>
       
        <div class="text-center text-2xl font-semibold">
            <div class="md:w-3/4 m-auto">
                <FollowedFeed />
            </div>
        </div>
        <template v-slot:Right>  </template>
    </Grid>
    <Footer />
</template>

<style scoped></style>
