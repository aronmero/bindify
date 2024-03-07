<script setup>
    import { ref } from 'vue';

    const email = ref('');
    const password = ref('');

    function Login() {
        
    }

    function OlvidarPassword() {
        
    }

    function Registro() {
        
    }
</script>

<template>
    <div class="container">
        <div class="imagen-container">
            <img src="./../../public/fondo.png" alt="imagen">
        </div>
        <div class="formulario-container">
            <h2 class="title">Título</h2>
            <p class="subtitle">Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto.</p>
            <form @submit.prevent="Login" class="form">
                <div class="grupos">
                    <label>Email: </label>
                    <i class="bx bx-envelope"></i>
                    <input type="email" id="email" v-model="email" placeholder="Email" required>
                </div>
                <div class="grupos">
                    <label>Contraseña: </label>
                    <i class="bx bx-lock-alt"></i>
                    <input type="password" id="password" v-model="password" placeholder="Contraseña" required>
                </div>
                <div class="login">
                    <input type="submit" value="Iniciar Sesión">
                </div>
                <div class="olvidarPassword">
                    <p @click="OlvidarPassword" class="olvidarPassword">¿Olvidaste tu contraseña?</p>
                </div>
                <div class="links">
                    <p>O inicie sesión con:</p>
                    <div class="social-media-buttons">
                        <button class="social-media-button">
                            <img src="./../../public/google-logo.png" alt="Google">
                        </button>

                        <button class="social-media-button">
                            <img src="./../../public/instagram-logo.png" alt="Instagram">
                        </button>

                        <button class="social-media-button">
                            <img src="./../../public/facebook-logo.png" alt="Facebook">
                        </button>
                    </div>
                </div>
                <div class="registro">
                    <p>¿No tienes una cuenta?</p>
                    <button @click="Registro" class="Registro-button">Regístrate</button>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped lang="scss">
@media screen and (max-width: 576px) {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    .container {
        margin: 0 auto;
        width: 80%;
        display: flex;
        margin-top: 60px;
        background-color: #EBEBEB;
        padding: 50px;
    }

    .imagen-container {
        display: none;
    }

    .formulario-container {
        width: 100%;
        height: 75vh;
        margin-left: 25px;
    }

    .title {
        font-family: "Inter", 'Times New Roman', Times, serif;
        font-size: 50px;
        font-weight: bolder;
        margin-bottom: 10px;
        text-align: center;
    }

    .subtitle {
        margin-bottom: 50px;
    }
    
    .grupos {
        margin-top: 20px;
        position: relative;
    }

    .grupos input {
        width: 100%;
        padding: 12px 12px 12px 45px;
        border-radius: 10px;
        outline: none;
    }

    .grupos input::placeholder {
        color: transparent;
    }

    .grupos i {
        position: absolute;
        top: 65%;
        left: 10px;
        font-size: 20px;
        transform: translateY(-50%);
    }

    
    .login input {
        background-color: black;
        color: white;
        border-radius: 15px;
        width: 100%;
        padding: 15px;
        margin: 20px 0 5px;
    }

    .olvidarPassword {
        text-align: end;
        margin-bottom: 25px;
        p {
            font-size: 14px;
        }
    }

    .links {
        p {
            text-align: center;
            margin-bottom: 20px;
        }
    }

    .social-media-buttons {
        display: flex;
        justify-content: space-between;
    }
    
    .social-media-button {
        background-color: white;
        padding: 10px;
        border-radius: 15px;
        margin: 0 15px 30px;
    }

    .social-media-button img {
        width: 50px;
        height: 50px;
    }

    .registro {
        display: flex;
        justify-content: center;

        button {
            font-weight: bold;
            margin-left: 5px;
        }
    }
}


@media screen and (min-width: 577px) and (max-width: 1250px) {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    .container {
        margin: 0 auto;
        width: 85%;
        display: flex;
        margin-top: 100px;
        background-color: #EBEBEB;
        padding: 50px;
    }

    .imagen-container {
        display: none;
    }

    .formulario-container {
        margin-left: 50px;
        width: 100%;
    }

    .title {
        font-family: "Inter", 'Times New Roman', Times, serif;
        font-size: 50px;
        font-weight: bolder;
        margin-bottom: 30px;
        text-align: center;
    }

    .subtitle {
        margin-bottom: 50px;
    }

    label {
        display: none;
    }

    .grupos {
        margin-top: 15px;
        position: relative;
    }

    .grupos input {
        width: 100%;
        padding: 12px 12px 12px 45px;
        border-radius: 10px;
        outline: none;
    }

    .grupos input::placeholder {
        color: black;
        font-size: 17px;
        letter-spacing: 0.02em;
    }

    .grupos i {
        position: absolute;
        top: 50%;
        left: 10px;
        font-size: 20px;
        transform: translateY(-50%);
    }


    .login input {
        background-color: black;
        color: white;
        border-radius: 15px;
        width: 100%;
        padding: 15px;
        margin: 20px 0 5px;
    }

    .olvidarPassword {
        text-align: end;
        margin-bottom: 15px;
    }

    .links {
        p {
            text-align: center;
            margin-bottom: 10px;
        }
    }

    .social-media-buttons {
        display: flex;
        justify-content: space-between;
    }
    
    .social-media-button {
        background-color: white;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 25px
    }

    .social-media-button img {
        width: 50px;
        height: 50px;
    }

    .registro {
        display: flex;
        justify-content: center;

        button {
            font-weight: bold;
            margin-left: 5px;
        }
    }
}


@media screen and (min-width: 1251px) and (max-width: 1450px) {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    .container {
        margin: 0 auto;
        width: 60%;
        display: flex;
        margin-top: 150px;
        background-color: #EBEBEB;
        padding: 50px;
    }

    .imagen-container {
        margin-right: 25px;

        img {
            width: 550px;
            height: 550px;
            background-size: cover;
        }
    }
    
    .formulario-container {
        margin-left: 50px;
        width: 50%;
    }

    .title {
        font-family: "Inter", 'Times New Roman', Times, serif;
        font-size: 50px;
        font-weight: bolder;
        margin-bottom: 30px;
        text-align: center;
    }

    .subtitle {
        display: none;
    }

    label {
        display: none;
    }

    .grupos {
        margin-top: 15px;
        position: relative;
    }

    .grupos input {
        width: 100%;
        padding: 12px 12px 12px 45px;
        border-radius: 10px;
        outline: none;
    }

    .grupos input::placeholder {
        color: black;
        font-size: 17px;
        letter-spacing: 0.02em;
    }

    .grupos i {
        position: absolute;
        top: 50%;
        left: 10px;
        font-size: 20px;
        transform: translateY(-50%);
    }


    .login input {
        background-color: black;
        color: white;
        border-radius: 15px;
        width: 100%;
        padding: 15px;
        margin: 20px 0 5px;
    }

    .olvidarPassword {
        text-align: end;
        margin-bottom: 15px;
        font-size: 13px;
    }

    .links {
        p {
            text-align: center;
            margin-bottom: 10px;
        }
    }

    .social-media-buttons {
        display: flex;
        justify-content: space-between;
    }
    
    .social-media-button {
        background-color: white;
        padding: 10px;
        border-radius: 15px;
        margin-bottom: 25px
    }

    .social-media-button img {
        width: 50px;
        height: 50px;
    }

    .registro {
        display: flex;
        justify-content: center;

        button {
            font-weight: bold;
            margin-left: 5px;
        }
    }
}


@media screen and (min-width: 1451px) and (max-width: 1750px) {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    .container {
        margin: 0 auto;
        width: 60%;
        display: flex;
        margin-top: 150px;
        background-color: #EBEBEB;
        padding: 50px;
    }

    .imagen-container {
        margin-right: 25px;

        img {
            width: 550px;
            height: 550px;
            background-size: cover;
        }
    }

    .formulario-container {
        margin-left: 50px;
        width: 50%;
    }

    .title {
        font-family: "Inter", 'Times New Roman', Times, serif;
        font-size: 50px;
        font-weight: bolder;
        margin-bottom: 30px;
        text-align: center;
    }

    .subtitle {
        display: none;
    }

    label {
        display: none;
    }

    .grupos {
        margin-top: 15px;
        position: relative;
    }

    .grupos input {
        width: 100%;
        padding: 12px 12px 12px 45px;
        border-radius: 10px;
        outline: none;
    }

    .grupos input::placeholder {
        color: black;
        font-size: 17px;
        letter-spacing: 0.02em;
    }

    .grupos i {
        position: absolute;
        top: 50%;
        left: 10px;
        font-size: 20px;
        transform: translateY(-50%);
    }


    .login input {
        background-color: black;
        color: white;
        border-radius: 15px;
        width: 100%;
        padding: 15px;
        margin: 20px 0 5px;
    }

    .olvidarPassword {
        text-align: end;
        margin-bottom: 15px;
    }

    .links {
        p {
            text-align: center;
            margin-bottom: 10px;
        }
    }

    .social-media-buttons {
        display: flex;
        justify-content: space-between;
    }
    
    .social-media-button {
        background-color: white;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 15px
    }

    .social-media-button img {
        width: 50px;
        height: 50px;
    }

    .registro {
        display: flex;
        justify-content: center;

        button {
            font-weight: bold;
            margin-left: 5px;
        }
    }
}


@media screen and (min-width: 1751px) {
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    .container {
        margin: 0 auto;
        width: 60%;
        display: flex;
        margin-top: 150px;
        background-color: #EBEBEB;
        padding: 50px;
    }

    .imagen-container {
        margin-right: 25px;

        img {
            width: 550px;
            height: 550px;
            background-size: cover;
        }
    }

    .formulario-container {
        margin-left: 50px;
        width: 50%;
    }

    .title {
        font-family: "Inter", 'Times New Roman', Times, serif;
        font-size: 50px;
        font-weight: bolder;
        margin-bottom: 30px;
        text-align: center;
    }

    .subtitle {
        display: none;
    }

    label {
        display: none;
    }

    .grupos {
        margin-top: 15px;
        position: relative;
    }

    .grupos input {
        width: 100%;
        padding: 12px 12px 12px 45px;
        border-radius: 10px;
        outline: none;
    }

    .grupos input::placeholder {
        color: black;
        font-size: 17px;
        letter-spacing: 0.02em;
    }

    .grupos i {
        position: absolute;
        top: 50%;
        left: 10px;
        font-size: 20px;
        transform: translateY(-50%);
    }


    .login input {
        background-color: black;
        color: white;
        border-radius: 15px;
        width: 100%;
        padding: 15px;
        margin: 20px 0 5px;
    }

    .olvidarPassword {
        text-align: end;
        margin-bottom: 15px;
    }

    .links {
        p {
            text-align: center;
            margin-bottom: 10px;
        }
    }

    .social-media-buttons {
        display: flex;
        justify-content: space-between;
    }
    
    .social-media-button {
        background-color: white;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 15px
    }

    .social-media-button img {
        width: 50px;
        height: 50px;
    }

    .registro {
        display: flex;
        justify-content: center;

        button {
            font-weight: bold;
            margin-left: 5px;
        }
    }
}
</style>