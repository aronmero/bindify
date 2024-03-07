<script setup>
defineProps({
  titulo: { type: String, default: "TodoJardín" },
  categoria: { type: String, default: "Floristeria" },
  url: { type: String, default: "/validate" },
});

const emit=defineEmits(["submit"])

function validar(parametro) {
  emit("submit",parametro);
}
</script>

<template>
  <div class="flex flex-row gap-[5px] items-center p-[10px]">
    <RouterLink :to="url" class="rounded-full overflow-hidden">
      <img src="https://placehold.co/35x35/png" />
    </RouterLink>
    <div class="flex flex-col w-full justify-between">
      <div class="flex flex-col justify-center">
        <div class="flex font-bold gap-[12px]">
          {{ titulo }}
          <RouterLink :to="url" class="hidden sm:block">
            <div
              class="flex text-[10px] items-center bg-primary-300 px-[10px] py-[2px] rounded-[5px] drop-shadow-lg cursor-pointer text-text-50 tracking-wider h-full">
              Ver perfil
            </div>
          </RouterLink>
        </div>
      </div>
      <div class="flex w-full justify-between items-center">
        <div>{{ categoria }}</div>

        <div class="flex flex-row justify-center items-center gap-[12px]">
          <div class="rounded-[5px] bg-accent-400 cursor-pointer" @click="validar(true)">
            <img src="@public/assets/icons/done.svg" />
          </div>
          <div class="rounded-[5px] bg-background-700 cursor-pointer" @click="validar(false)">
            <img src="@public/assets/icons/close.svg" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
