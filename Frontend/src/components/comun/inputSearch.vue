<script setup>
    
</script>

<template>
    <div class="flex w-70 bg-[#e2e2e2] h-10 items-center mx-5 rounded-3xl px-3 md:w-5/6 md:m-auto m-3 md:mt-4 md:mb-4 p-4">
        <svg class="w-6 h-6 text-[#a1a1a1]"  fill="none" viewBox="0 0 24 24" strokeWidth="{1.5}" stroke="currentColor" className="w-6 h-6" >
            <path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
        </svg>
        <input v-model="value" placeholder="Buscar seguidos..." class="bg-inherit placeholder:text-[#b4b4b4] px-2 text-sm focus:outline-0" />
    </div>
</template>