<script setup>
    import useSearchLogic from '@/utils/searchLogic.js';
    defineProps({
      name: String,
      type: String,
    });
  
    const { selectedOption } = useSearchLogic();
    
    const toggleOption = (name, type, event) => {
      event.currentTarget.classList.toggle('selected');
      document.querySelectorAll(`.${type}`).forEach((option) => {
        if (option !== event.currentTarget) {
          option.classList.remove('selected');
        }
      });
      selectedOption(name, type);
    };
   

  </script>

<template>
    <div :class="[type, 'flex', 'gap-x-1', 'items-center', 'justify-center', 'p-3', 'bg-[#e5e5e5]', 'text-[#404040]','rounded-full', 'cursor-pointer' ,'transition-all', 'duration-300', 'transform', 'hover:scale-105']" @click="toggleOption(name, type, $event)">
      <p class="font-semibold text-md capitalize">{{ name }}</p>
    </div>
  </template>
  
  <style scoped>
    .selected {
      background-color: #eb5959 !important;
      color: white !important;
      font-weight: bold !important;
    }
  </style>
  