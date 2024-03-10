<script setup>
    import {ref} from 'vue';
    import {dias} from './../mocks/dias';
    import DeleteSVG from '@public/assets/icons/delete.svg';
    import EditSVG from '@public/assets/icons/done.svg';

    const props = defineProps({
        intervalo: Object,
        index: Number,
        /** Funciones para cambiar en el componente padre */
        borrar_intervalo: Function,
        cambiar_intervalo: Function
    });

    /**
     *  Los intervalos
     * */
    
    const intervalo = ref(props.intervalo);
    const hora_apertura = intervalo.value.hora_apertura;
    const hora_cierre = intervalo.value.hora_cierre;
    const dia = intervalo.value.dia;

    /**
     * Las referencias da input
     * */

    const input_hora_apertura = ref(null);
    const input_hora_cierre = ref(null);
    const input_dia = ref(null);

</script>

<template>
    <div class="label flex items-center m-[10px_0px] ">
        <label for="">
            <input ref="input_hora_apertura"  v-if="intervalo.hora_apertura != 'Cerrado'" type="time" :value="hora_apertura">
            <input ref="input_hora_apertura"  v-else type="time" value="00:00">
        </label>
        <label for="">
            <input ref="input_hora_cierre"  v-if="intervalo.hora_cierre != 'Cerrado'" type="time" :value="hora_cierre">
            <input ref="input_hora_cierre"  v-else type="time" value="00:00">
        </label>
        <label for="">
            <select ref="input_dia" id="">
                <option v-for="day in dias" :value="day" :selected="day == intervalo.dia">{{ day }} </option>
            </select>
        </label>
        <button class=" flex items-center bg-slate-400 ml-[5px] rounded-sm p-[5px_10px]" @click="() => props.cambiar_intervalo(props.index, input_hora_apertura.value, input_hora_cierre.value, e.target.value)">
            <img class="h-[20px]" :src="EditSVG" alt="">
         </button>
        <button class=" ml-[5px] bg-red-500 rounded-sm-[5px_10px] " @click="() => props.borrar_intervalo(props.index)">
            <img :src="DeleteSVG" alt="">
        </button>
      
    </div>
    
    
</template>

<style scoped lang="scss"></style>