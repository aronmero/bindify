<script setup>
    import {ref} from 'vue';
    import {dias} from './../mocks/dias';
    import DeleteSVG from '@public/assets/icons/delete.svg';
    import EditSVG from '@public/assets/icons/done.svg';

    const props = defineProps({
        intervalo: Object,
        index: Number,
        exportar: String,
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
            <input :id="`a_${index}`" ref="input_hora_apertura"  v-if="intervalo.hora_apertura != 'Cerrado'" type="time" :value="props.intervalo.hora_apertura">
            <input :id="`a_${index}`" ref="input_hora_apertura"  v-else type="time" value="00:00">
        </label>
        <label for="">
            <input :id="`b_${index}`" ref="input_hora_cierre"  v-if="intervalo.hora_cierre != 'Cerrado'" type="time" :value="props.intervalo.hora_cierre">
            <input :id="`b_${index}`" ref="input_hora_cierre"  v-else type="time" value="00:00">
        </label>
        <label for="">
            <select :id="`c_${index}`" ref="input_dia" id="">
                <option v-for="day in dias" :value="day" :selected="day == props.intervalo.dia">{{ day }} </option>
            </select>
        </label>
        <button class=" bg-[#f3f3f3] flex items-center ml-[5px] p-[5px_10px] " @click="() => props.cambiar_intervalo(props.index, input_hora_apertura.value, input_hora_cierre.value, input_dia.value)">
            <img class=" w-[26px] h-[28px]" :src="EditSVG" alt="">
         </button>
        <button class="  flex items-center p-[5px_10px] mb-[0px] " @click="() => props.borrar_intervalo(props.index)">
            <img class=" w-[26px] h-[28px]" :src="DeleteSVG" alt="">
        </button>
        <p>{{  exportar  }}</p>
    </div>
    
    
</template>

<style scoped lang="scss"></style>