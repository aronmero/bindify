<script setup>
import { ref } from 'vue';
const props = defineProps({
    clase: String,
    tipo: String,
    requerido: Boolean,
    label: String,
    valor: String,
    img: String,
    opciones: Array,
    error: String,
    placeholder: String
});
const emit = defineEmits(["datos"]);
let ojoAbierto = "/assets/icons/eye.svg";
let ojoCerrado = "/assets/icons/invisible.svg";
const diaActual = new Date().getFullYear()+"-"+("0" + (parseInt(new Date().getMonth())+1).toString()).slice(-2)+"-"+("0" + new Date().getDate()).slice(-2);
const ojo = ref("/assets/icons/eye.svg");
const cambiarVision = (e)=>{
    if(e.target.parentNode.parentNode.children[1].type == "password"){
        ojo.value = ojoCerrado;
        e.target.parentNode.parentNode.children[1].type = "text";
    }else{
        ojo.value = ojoAbierto;
        e.target.parentNode.parentNode.children[1].type = "password";
    }
}
let imagenSubida = ref(null);
const seleccionarImagen = (e)=>{
    e.target.parentNode.children[1].addEventListener("change", ()=>{
        if(e.target.parentNode.children[1].files.length == 1){
            imagenSubida.value = e.target.parentNode.children[1].files[0];
            imagenSubida.value = URL.createObjectURL(imagenSubida.value);
        }
    });
    e.target.parentNode.children[1].click();
}
const emitirDatos = (e)=>{
    if(e.target.type == "file"){
        emit("datos", e.target.files[0]);
    }else{
        emit("datos", e.target.value);
    }
}
</script>
<template>
    <div class="flex flex-col gap-y-2 justify-center">
        <div v-if="label != null" class="label flex items-center">
            <label for="" class="ms-1 text-lg">{{label}}</label>
            <p v-if="requerido == 'true'" class="text-primary-700 text-xl">*</p>
            <p v-if="error != null" class="text-primary-700 text-xs lg:text-sm ms-3">{{ error }}</p>
        </div>
        <input @change="emitirDatos" v-if="(tipo == 'text' || tipo == 'password' || tipo == 'email') && img != null" :type="tipo" class="ps-12 bg-background-100 text-text-950 py-3 px-1 rounded-xl" :placeholder="placeholder" :value="valor">
        <input @change="emitirDatos" v-if="(tipo == 'text' || tipo == 'password' || tipo == 'email') && img == null" :type="tipo" class="ps-3 bg-background-100 text-text-950 py-3 px-1 rounded-xl" :placeholder="placeholder" :value="valor">
        <input @change="emitirDatos" v-if="tipo == 'button' && clase == null" :type="tipo" class="ps-12 bg-background-100 text-text-950 py-3 rounded-xl w-fit px-4 cursor-pointer" :value="valor">
        <input @change="emitirDatos" v-if="tipo == 'button' && clase == 'social'" :type="tipo" class="ps-12 bg-background-100 text-text-950 py-5 rounded-xl w-fit px-6 cursor-pointer" :value="valor">
        <input @change="emitirDatos" v-if="tipo == 'submit' && clase == 'claro'" :type="tipo" :value="valor" class="bg-secondary-400 text-text-950 py-3 px-1 rounded-xl cursor-pointer">
        <input @change="emitirDatos" v-if="tipo == 'submit' && clase == 'oscuro'" :type="tipo" :value="valor" class="bg-background-800 text-text-50 py-3 px-1 rounded-xl cursor-pointer">
        <input @change="emitirDatos" v-if="tipo == 'file'" accept="image/*" :type="tipo" hidden>
        <input @change="emitirDatos" v-if="tipo == 'hora'" type="time" class=" ps-12 bg-background-100 text-text-950 py-3 px-1 rounded-xl w-[10rem]" :value="valor">
        <input @change="emitirDatos" v-if="tipo == 'fecha'" type="date" :min="diaActual" class=" ps-12 bg-background-100 text-text-950 py-3 px-1 rounded-xl w-[10rem]" :value="valor">
        <input @change="emitirDatos" v-if="tipo == 'fechaLibre'" type="date" class=" ps-12 bg-background-100 text-text-950 py-3 px-1 rounded-xl w-[10rem]" :value="valor">
        <select @change="emitirDatos" v-if="tipo == 'selection'" class="bg-background-100 text-text-950 py-3 px-1 text-center rounded-xl cursor-pointer">
            <option value="" disabled selected>{{ placeholder }}</option>
            <option v-for="(value, clave) in opciones" :value="clave" :selected="value == valor" :id="value.id">{{ value.name }}</option>
        </select>
        <textarea @change="emitirDatos" v-if="tipo == 'texto'" class="ps-10 bg-background-100 text-text-950 py-3 px-1 rounded-xl resize-none h-[15rem]" :placeholder="placeholder" :value="valor"></textarea>
        <button @click.prevent="seleccionarImagen" v-if="tipo == 'file' && clase == 'perfil'" class="flex relative lg:size-40 size-28 justify-center items-center rounded-full border-dotted border border-background-900">
            <p v-if="imagenSubida == null" class="text-[1em] pointer-events-none">Añadir Imagen</p>
            <img v-else :src="imagenSubida" alt="Previsualizacion de foto de perfil" class="pointer-events-none lg:size-40 size-28 rounded-full">
            <img
                src="/assets/icons/add.svg"
                class="max-w-[40px] max-h-[40px] lg:block absolute bottom-0 right-0 lg:-translate-x-1 lg:translate-y-0 translate-x-1 translate-y-1 py-1 px-2 pointer-events-none"
            />
        </button>
        <button @click.prevent="seleccionarImagen" v-if="tipo == 'file' && clase == 'banner'" class="flex relative lg:h-[10rem] lg:w-[12rem] h-[7rem] w-[9rem] justify-center items-center rounded-xl border-dotted border border-background-900">
            <img v-if="imagenSubida == null && valor != null" :src="valor" alt="Previsualizacion de foto del Banner" class=" pointer-events-none lg:h-[10rem] lg:w-[12rem] h-[7rem] w-[9rem] rounded-xl">
            <p v-if="imagenSubida == null && valor == null" class="text-[1em] pointer-events-none">Añadir Imagen</p>
            <img v-else :src="imagenSubida" alt="Previsualizacion de foto del Banner" class=" pointer-events-none lg:h-[10rem] lg:w-[12rem] h-[7rem] w-[9rem] rounded-xl">
            <img
                src="/assets/icons/add.svg"
                class="max-w-[40px] max-h-[40px] lg:block absolute bottom-0 right-0 lg:translate-x-4 lg:translate-y-2 translate-x-4 translate-y-2 py-1 px-2 pointer-events-none"
            />
        </button>
        <div v-if="tipo == 'button' && clase == null" class="relative flex flex-row items-center justify-start">
            <img
            :src="img"
            class="max-w-[30px] max-h-[30px] lg:block absolute -translate-y-[2rem] translate-x-[0.9rem]"
            />
        </div>
        <div v-if="tipo == 'button' && clase == 'social'" class="relative flex flex-row items-center justify-center">
            <img
            :src="img"
            class="max-w-[40px] max-h-[40px] lg:block absolute -translate-y-[2.45rem] pointer-events-none"
            />
        </div>
        <button v-if="tipo == 'password'" @click.prevent="cambiarVision" class="absolute translate-y-[0.8rem] -translate-x-2 self-end hover:bg-background-100 p-2 rounded-full">
            <img
                :src="ojo"
                class="max-w-[30px] max-h-[30px] lg:block"
            />
        </button>
        <div class="absolute translate-y-[1rem] translate-x-3 flex">
            <img v-if="tipo != 'submit' && tipo != 'selection' && tipo != 'file' && tipo != 'fecha' && tipo != 'button'"
            :src="img"
            class="max-w-[30px] max-h-[30px] lg:block"
            />
            <!--  <img v-if="tipo == 'fecha'"
            :src="img"
            class="max-w-[30px] max-h-[30px] lg:block w-[4rem] pointer-events-none select-none hidden"
            /> -->
        </div>
        <div class="self-end -translate-y-[2.9rem] -translate-x-[0.25rem] pointer-events-none">
            <img v-if="tipo == 'selection'"
                src="/assets/icons/expandArrow.svg"
                class="max-w-[40px] max-h-[40px] lg:block py-1 px-2 pointer-events-none"
            />
        </div>
    </div>

</template>
<style scoped>
select {
    -moz-appearance:none;
    -webkit-appearance:none;
    appearance:none;
}
input[type="time"]::-webkit-calendar-picker-indicator{
    filter: invert(1);
    margin-right: 0.5rem;
}
input[type="date"]::-webkit-calendar-picker-indicator{
    position: relative;
    right: 7.5rem;
    filter: invert(1);
}
textarea::-webkit-scrollbar{
    background-color: transparent;
    width: 1rem;
}
textarea::-webkit-scrollbar-thumb{
    background-color: var(--text-600);
    border-radius: 5rem;
}
</style>