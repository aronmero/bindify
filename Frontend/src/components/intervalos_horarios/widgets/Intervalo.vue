<script setup>
    import {ref} from 'vue';
    import {dias} from './../mocks/dias';
    import DeleteSVG from '@public/assets/icons/delete.svg';
    import HorarioSVG from '@public/assets/icons/time.svg';

    const props = defineProps({
        intervalo: Object,
        index: Number,
        exportar: String,
        /** Funciones para cambiar en el componente padre */
        borrar_intervalo: Function,
        cambiar_intervalo: Function
    });


    /** El intervalo */
    const intervalo = ref(props.intervalo);

    /**
     * Las referencias da input
     * */

    const input_hora_apertura = ref(null);
    const input_hora_cierre = ref(null);
    const input_dia = ref(null);

</script>

<template>
    <div class="label flex items-center m-[10px_0px]  ">
        <img :src="HorarioSVG" class=" w-[30px]" alt="icono_schedule"/>
        <label for="">
            <input @change="() => props.cambiar_intervalo(props.index, input_hora_apertura.value, input_hora_cierre.value, input_dia.value)"  :id="`a_${index}`" ref="input_hora_apertura"  v-if="intervalo.hora_apertura != 'Cerrado'" type="time" :value="props.intervalo.hora_apertura">
            <input @change="() => props.cambiar_intervalo(props.index, input_hora_apertura.value, input_hora_cierre.value, input_dia.value)"   :id="`a_${index}`" ref="input_hora_apertura"  v-else type="time" value="00:00">
        </label>
        <label for="">
            <input  @change="() => props.cambiar_intervalo(props.index, input_hora_apertura.value, input_hora_cierre.value, input_dia.value)"  :id="`b_${index}`" ref="input_hora_cierre"  v-if="intervalo.hora_cierre != 'Cerrado'" type="time" :value="props.intervalo.hora_cierre">
            <input @change="() => props.cambiar_intervalo(props.index, input_hora_apertura.value, input_hora_cierre.value, input_dia.value)"  :id="`b_${index}`" ref="input_hora_cierre"  v-else type="time" value="00:00">
        </label>
        <label for="">
            <select  @change="() => props.cambiar_intervalo(props.index, input_hora_apertura.value, input_hora_cierre.value, input_dia.value)" :id="`c_${index}`" ref="input_dia" id="">
                <option v-for="day in dias" :value="day" :selected="day == props.intervalo.dia">{{ day }} </option>
            </select>
        </label>

        <button class="  flex items-center p-[5px_10px] mb-[0px] " @click="() => props.borrar_intervalo(props.index)">
            <img class=" w-[26px] h-[28px]" :src="DeleteSVG" alt="">
        </button>
        <p>{{  exportar  }}</p>
    </div>
    
    
</template>

<style scoped lang="scss">
    input {
        border:1px solid rgba(206,206,206);
        background:#f3f3f3;
        padding:10px 5px;
        border-radius:5px;
        margin-right:10px;
        color:black;
    }
    select {
        border:1px solid rgba(206,206,206);
        background:#f3f3f3;
        padding:10px 5px;
        border-radius:5px;
        margin-right:10px;
    }

    input::-webkit-calendar-picker-indicator, select::-webkit-calendar-picker-indicator {
        color:gray;
    }


    @media (prefers-color-scheme: light) {
        *::-webkit-calendar-picker-indicator {
            background-color:#f3f3f3;
            border-radius:5px;
            padding:2px 1.5px;
        }
    }

    @media (prefers-color-scheme: dark) {
        *::-webkit-calendar-picker-indicator {
            background-color:#101010;
            border-radius:5px;
            padding:2px 1.5px;
        }
    }


    

</style>