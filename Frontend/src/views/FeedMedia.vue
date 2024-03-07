<script setup>
    import Grid from "@/components/comun/layout.vue";
    
    import Header from "@/components/comun/header.vue";
    import Footer from "@/components/comun/footer.vue";

    import FeedPosts from "../components/feed_media/Posts.vue";

</script>

<template >
    <Header />
    <Grid style="max-height:100vh; overflow-y:scroll; background:#fff; margin: 20px 0px 40px 0px;">
        <template v-slot:Left >
            
        </template>
            <FeedPosts  id="feed" />
        <template v-slot:Right > Right </template>
    </Grid>
    <Footer />
</template>

<style scoped lang="scss">
    #feed  {
        background: red !important;
    }
</style>
