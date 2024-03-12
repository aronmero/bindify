<script setup>
    import router from '../../../router';
    
    const props = defineProps({
        options: Array,
        status: Boolean,
        handler: Function
    });

    /**
     * Recoge estilos del padre
     * */

    const estilos = {
        modal: ' absolute bg-white min-w-[200px] rounded-lg p-2 flex flex-col items-start justify-center ',
        modal_button: ' flex items-center font-medium w-[100%]  ',
        modal_superior_dcha: ' top-[50px] right-[20px] '
    };

    /**
     * Prepara la redirección
     * */

    const redirect = (url) => {
        router.push(url);
    }

</script>
<template>
    <div ref="modal" :class="`modal bg-white z-50 ${estilos.modal} ${estilos.modal_superior_dcha}`">
        <!-- Botones de las opciones pasadas por parámetro -->
        <button :class="`${estilos.modal_button} m-2 `" @click="() => redirect(option.action)" v-for="option in props.options">
            <!-- Exporta el icono seleccionado, leído previamente en el padre -->
            <img class="w-[30px] h-[30px] mr-3 " :src="option.icon" alt="">
            <!-- Exporta el nombre -->
            {{ option.name }}
        </button>
    </div>
</template>
<style scoped>

    .modal {
        width: fit-content;
        background:#fff;
        box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
        transition:.4s ease-in-out;
    }

</style>