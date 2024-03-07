<script setup>
import Calendar from "@/components/utils/calendar.vue";
const props = defineProps({
    titulo: { type: String, default: "Título evento" },
    ubicacion: { type: String, default: "Ubicación" },
    fechaInicio: { type: String, default: "05-03-2024" },
    fechaFin: { type: String, default: "14-03-2024" },
    dias: { type: String, default: "25" },
    descripcion: { type: String, default: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in tempus lorem. Donec eu felis erat. Aenean eu augue congue, congue ligula vitae, accumsan neque. Mauris auctor lobortis tempor. In hac habitasse platea dictumst. Ut egestas eget nunc quis convallis. Suspendisse potenti. Vivamus commodo lectus quis maximus facilisis. " },
});

const openModal = (e) => {
    if (e.target.nextSibling.classList.contains("hidden")) {
        e.target.nextSibling.classList.remove("hidden")
    } else {
        e.target.nextSibling.classList.add("hidden")
    }
}
window.addEventListener("mouseup", (e) => {
    const modal = document.getElementById("modalEvento");

    if (e.target != modal.previousSibling) {

        //Esto es cosa de antonio si falla es su culpa
        if (modal.compareDocumentPosition(e.target) != "20" & modal.compareDocumentPosition(e.target) != "0") {
            modal.classList.add("hidden");
        }
    }
})
</script>

<template>
    <div>
        <div class="flex justify-center mx-[-10px]"><img src="https://placehold.co/320x230/png"
                class="max-w-[680px] max-h-[440px] min-w-[320px] min-h-[230px] w-full"></div>
    </div>
    <div class="flex m-[20px] flex-col">
        <div class="flex justify-between w-full font-bold pb-[40px] relative">
            <div>{{ props.titulo }}</div>
            <div class="cursor-pointer" @click="openModal">...</div>
            <div id="modalEvento"
                class="top-[30px] right-0 absolute bg-background-50 drop-shadow-sm rounded-[5px] font-normal p-[5px] flex gap-[5px] items-center cursor-pointer hidden">
                <img src="@public/assets/icons/share.svg"> Compartir
            </div>
        </div>
        <div>
            <div class="flex"><img src="@public/assets/icons/time.svg" class="w-[20px] mr-[5px]">Publicado hace {{
                props.dias }}
                dias</div>
            <div class="flex"><img src="@public/assets/icons/location.svg" class="w-[20px] mr-[5px]">{{ props.ubicacion }}
            </div>
            <div class="flex"><img src="@public/assets/icons/schedule.svg" class="w-[20px] mr-[5px]">{{ props.fechaInicio }}
                al {{ props.fechaFin }}</div>
        </div>
        <div> {{ props.descripcion }}</div>
        <div class="text-[24px] font-bold my-[30px]">Periodo del evento</div>
        <div>
            <Calendar />
        </div>
    </div>
</template>

<style scoped></style>
