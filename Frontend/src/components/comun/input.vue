<script setup>
import { ref } from 'vue';
const props = defineProps({
    clase: String,
    tipo: String, 
    requerido: Boolean, 
    label: String, 
    valor: String, 
    img: String,
    opciones: Array
})
let ojoAbierto = "/assets/icons/Eye.svg";
let ojoCerrado = "/assets/icons/Invisible.svg";
const ojo = ref("/assets/icons/Eye.svg");
const cambiarVision = (e)=>{
    if(e.target.parentNode.parentNode.parentNode.children[1].type == "password"){
        ojo.value = ojoCerrado;
        e.target.parentNode.parentNode.parentNode.children[1].type = "text";
    }else{
        ojo.value = ojoAbierto;
        e.target.parentNode.parentNode.parentNode.children[1].type = "password";
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
    console.log(e.target.parentNode.children[1].files.length == 1);
    
}
</script>
<template>
    <div class="flex flex-col gap-y-2">
        <label v-if="label != null" for="" class="ms-1 text-lg">{{label}}</label>
        <input v-if="requerido == 'true' && tipo != 'submit' && tipo != 'selection' && tipo != 'file'" :type="tipo" required class="ps-12 bg-background-50 text-text-950 py-3 px-1 rounded-xl">
        <input v-if="requerido == 'false' && tipo != 'submit' && tipo != 'selection' && tipo != 'file'" :type="tipo" class=" ps-12bg-background-50 text-text-950 py-3 px-1 rounded-xl">
        <input v-if="tipo == 'submit' && clase == 'claro'" :type="tipo" :value="valor" class="bg-secondary-400 text-text-950 py-3 px-1 rounded-xl cursor-pointer">
        <input v-if="tipo == 'submit' && clase == 'oscuro'" :type="tipo" :value="valor" class="bg-background-800 text-text-50 py-3 px-1 rounded-xl cursor-pointer">
        <input v-if="tipo == 'file'" :type="tipo" hidden>
        <select v-if="tipo == 'selection' && requerido == 'true'" class="bg-background-50 text-text-950 py-3 px-1 text-center rounded-xl cursor-pointer" required> 
            <option value="" disabled selected>Selecciona una categoría</option>
            <option v-for="(valor, clave) in opciones" :value="clave">{{ valor }}</option>
        </select>
        <select v-if="tipo == 'selection' && required == 'false'" class="bg-background-50 text-text-950 py-3 px-1 text-center rounded-xl cursor-pointer"> 
            <option value="" disabled selected>Selecciona una categoría</option>
            <option v-for="(valor, clave) in opciones" :value="clave">{{ valor }}</option>
        </select>
        <button @click.prevent="seleccionarImagen" v-if="tipo == 'file' && clase == 'perfil'" class="flex relative lg:h-[8rem] lg:w-[8rem] justify-center items-center rounded-full border-dotted border border-background-900">
            <p v-if="imagenSubida == null" class="text-[1em] pointer-events-none">Añadir Imagen</p>
            <img v-else :src="imagenSubida" alt="Previsualizacion de foto de perfil" class="pointer-events-none lg:h-[8rem] lg:w-[8rem] rounded-full">
            <img 
                src="/assets/icons/Add.svg"
                class="max-w-[40px] max-h-[40px] lg:block absolute bottom-0 right-0 lg:translate-x-1 lg:-translate-y-1 py-1 px-2 pointer-events-none"
            />
        </button>
        <button @click.prevent="seleccionarImagen" v-if="tipo == 'file' && clase == 'banner'" class="flex relative lg:h-[10rem] lg:w-[12rem] justify-center items-center rounded-xl border-dotted border border-background-900">
            <p v-if="imagenSubida == null" class="text-[1em] pointer-events-none">Añadir Imagen</p>
            <img v-else :src="imagenSubida" alt="Previsualizacion de foto del Banner" class=" pointer-events-none lg:h-[10rem] lg:w-[12rem] rounded-xl">
            <img 
                src="/assets/icons/Add.svg"
                class="max-w-[40px] max-h-[40px] lg:block absolute bottom-0 right-0 lg:translate-x-4 lg:translate-y-2 py-1 px-2 pointer-events-none"
            />
        </button>
        <div class="absolute translate-y-11 translate-x-3 flex">
            <img v-if="tipo != 'submit' && tipo != 'selection' && tipo != 'file'"
            :src="img"
            class="max-w-[30px] max-h-[30px] lg:block"
            />
            <button v-if="tipo == 'password'" @click.prevent="cambiarVision" class="lg:translate-x-[37rem] -translate-y-[0.10rem] hover:bg-background-100 p-2 rounded-full">
                <img 
                    :src="ojo"
                    class="max-w-[30px] max-h-[30px] lg:block"
                />
            </button>
            <img v-if="tipo == 'selection'"
                src="/assets/icons/Expand-Arrow.svg"
                class="max-w-[40px] max-h-[40px] lg:block lg:translate-x-[38.9rem] py-1 px-2 pointer-events-none"
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
</style>