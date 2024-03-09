import {defineStore} from 'pinia';

export const userFollowed = defineStore({ //store de usuarios seguidos
    id: "userFollowed",
    state: () => ({
        followedList : [], //lista de usuarios seguidos
    }),
    actions: {
        getFollowed(){ //devuelve la lista de usuarios seguidos
            return this.followedList;
        },
        follow(userAux){ //añade un usuario a la lista de seguidos
            this.followedList.push(userAux); // si no está en la lista de seguidos lo añadimos
        },
        unfollow(userAux){ //elimina un usuario de la lista de seguidos
            const index = this.followedList.findIndex(user => user.name.first === userAux.name.first); //buscamos el indice del usuario a eliminar
            this.followedList.splice(index, 1); //eliminamos el usuario de la lista de seguidos
        }
    }
});