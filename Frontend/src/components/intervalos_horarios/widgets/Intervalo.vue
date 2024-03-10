<script setup>
    import {ref} from 'vue';
    import {dias} from './../mocks/dias';
    import DeleteSVG from '@public/assets/icons/delete.svg';

    const props = defineProps({
        intervalo: Object,
        index: Number,
        /** Funciones para cambiar en el componente padre */
        borrar_intervalo: Function,
        cambiar_intervalo: Function
    });

    const intervalo = ref(props.intervalo);
    const hora_apertura = ref(intervalo.value.hora_apertura);
    const hora_cierre = ref(intervalo.value.hora_cierre);
    const dia = ref(intervalo.value.dia);

</script>

<template>
    <div class="label flex">
        <label for="">
            <input @blur="(e) => props.cambiar_intervalo(props.index, hora_apertura, hora_cierre, dia)"  v-if="intervalo.hora_apertura != 'Cerrado'" type="time" :value="hora_apertura">
            <input @blur="(e) => props.cambiar_intervalo(props.index, hora_apertura, hora_cierre, dia)" v-else type="time" value="00:00">
        </label>
        <label for="">
            <input @blur="(e) => props.cambiar_intervalo(props.index, hora_apertura, hora_cierre, dia)" v-if="intervalo.hora_cierre != 'Cerrado'" type="time" :value="hora_cierre">
            <input @blur="(e) => props.cambiar_intervalo(props.index, hora_apertura, hora_cierre, dia)" v-else type="time" value="00:00">
        </label>
        <label for="">
            <select name="" id="" @change="(e) => props.cambiar_intervalo(props.index, hora_apertura, hora_cierre, dia)">
                <option v-for="day in dias" :value="day" :selected="day == intervalo.dia">{{ day }} </option>
            </select>
        </label>
        <button @click="() => props.borrar_intervalo(props.index)">
            <img :src="DeleteSVG" alt="">
        </button>
    </div>
    
    
</template>

<style scoped lang="scss"></style>