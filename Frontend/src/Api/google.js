
import { urlApi } from "./api";
import { googleSdkLoaded } from "vue3-google-login";
import router from '@/router/index'
/**
 * Realiza el intento de login con Google Auth
 * @date 3/13/2024 - 7:06:56 PM
 */

const genOptionsLogin = (metodo) => {
    return {
        method: metodo,
        headers: {
            "Content-Type": "application/json",
            "User-Agent": "insomnia/8.6.0",
            "Accept": "application/json"
        }
    };
};

export const google_login = () => {
    console.log("login google");

    googleSdkLoaded(google => {
        const sendCode = async (code) => {
            try {
                const options = genOptionsLogin("POST");
                const response = await fetch(`${urlApi}/recovery_token?token=${code}`, options);
                const userDetails = response.data;
                console.log("sent")
                //login 
                /*console.log("User Details:", userDetails);
                this.userDetails = userDetails;*/

                // Redirect to the homepage ("/")
                /*router.push("/");*/
            } catch (error) {
                console.error("Failed to send authorization code:", error);
            }
        }

        google.accounts.oauth2
            .initCodeClient({
                client_id:
                    "223418345365-a7cgjvqp16h16o00opdaheg0erif0sf4.apps.googleusercontent.com",
                scope: "email profile openid",
                redirect_uri: `${urlApi}/auth/callback`,
                callback: response => {
                    if (response.code) {
                        console.log(response);
                        this.sendCode(response.code);
                    }
                }
            })
            .requestCode();
    });


}

