<script setup>
    import { ref } from 'vue';

    const scrollUp = ref(false); //variable que controla si se muestra el boton de scroll up

    window.addEventListener('scroll', () => { //evento que controla si se muestra el boton de scroll up
        if (window.scrollY > 200) { //si el scroll es mayor a 200px
            scrollUp.value = true; //muestra el boton
        } else {
            scrollUp.value = false; //oculta el boton
        }
    });

    const scrollToTop = () => { //funcion que hace scroll hasta arriba
        window.scrollTo({
            top: 0, //scroll hasta arriba
            behavior: 'smooth', //animacion suave
        });
    };
</script>

<template>
    <div class="fixed bottom-0 right-0 m-2 mb-14 md:mb-2 cursor-pointer transition duration-200 ease-in hover:scale-110 " v-if="scrollUp" @click="scrollToTop">
        <svg class="size-10" viewBox="0 0 48 48">
            <defs>
                <mask id="ipSUpC0">
                    <g fill="none" stroke-width="4">
                        <path stroke="#fff" d="M24 44c11.046 0 20-8.954 20-20S35.046 4 24 4S4 12.954 4 24s8.954 20 20 20Z" clip-rule="evenodd"/>
                        <path fill="#eb5959"  d="M24 44c11.046 0 20-8.954 20-20S35.046 4 24 4S4 12.954 4 24s8.954 20 20 20Z"/>
                        <path stroke="#000" stroke-linecap="round" stroke-linejoin="round" d="m33 27l-9-9l-9 9"/>
                    </g>
                </mask>
            </defs>
            <path fill="#eb5959" d="M0 0h48v48H0z" mask="url(#ipSUpC0)"/>
        </svg>
    </div>
</template>
