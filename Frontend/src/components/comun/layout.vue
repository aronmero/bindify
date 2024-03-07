<script setup></script>

<template>
    <div class="flex flex-row justify-center gap-[10px] mt-[50px] ">
        <section class="hidden w-auto min-w-[300px] max-w-[560px] p-[10px] py-[40px] lg:flex flex-col">
            <slot name="Left"></slot>
        </section>
        <section class="w-full max-w-[700px] p-[10px] py-[40px] flex flex-col">
            <slot></slot>
        </section>
        <section class="hidden w-auto min-w-[300px] max-w-[560px] p-[10px] py-[40px] lg:flex flex-col">
            <slot name="Right"></slot>
        </section>
    </div>
</template>

<style scoped></style>
