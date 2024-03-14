<script setup>
    import router from '@/router/index';
    const props = defineProps({
        user: Object
    });

    if(props.user.avatar=="default"){
        props.user.avatar="public/img/placeholderPerfil.webp";
}
</script>
<template>
    <div @click="router.push(`perfil/${props.user.username}`)" class="follower flex flex-col items-center mr-[10px] h-[100%] ">
        <div class="avatar-wrapper flex items-center justify-center rounded-full overflow-hidden max-w-[50px] max-h-[50px] md:max-h-[70px] md:max-w-[70px] ">
            <img :src="user.avatar" alt="">
        </div>
        <b class="md:max-w-[130px] max-w-[80px]  overflow-hidden text-ellipsis whitespace-nowrap mt-[10px]" :title="props.user.username">{{ props.user.username }} </b>
    </div>
</template>
<style scoped lang="scss">
.follower {
    //background:green;
}
.avatar-wrapper {
    background:linear-gradient(to bottom, #D1475A, #EDAF4A);
    padding:6px;
    width:80px;
    height:80px;
    overflow:hidden;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
    img {
        width:100%;
        height:100%;
        //zoom:2;
        //transform:scale(2);
        transition: all .4s ease-in-out;
        cursor:pointer;
        border-radius:50px;
    }
    img:hover {
        transform:scale(2);
    }

    @media screen and (max-width: 400px) {
        .avatar-wrapper {
            width:50px;
            height:50px;
        }
        
    }
}
</style>