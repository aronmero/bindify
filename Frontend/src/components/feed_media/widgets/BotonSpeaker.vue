<script setup>
    import { text_to_speech } from '../helpers/textspeech';
    import SpeakerSVG from '@public/assets/icons/speaker.svg';
    const props = defineProps({
        texto: String
    });
</script>
<template>
    <button class="speaker" @click="text_to_speech(props.texto)">
        <img :src="SpeakerSVG" alt="Speaker">
    </button>
</template>
<style scoped lang="scss">
    .speaker  {
        margin-left:15px;
        background:rgba(206,206,206,1);
        padding:5px;
        border-radius:50%;
        border:none;
        img {
            width:20px;
            height:20px;
        }
    }
</style>