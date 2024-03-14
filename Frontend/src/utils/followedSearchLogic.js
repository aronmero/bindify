    import { ref } from 'vue';
    import { userFollowed } from "@/stores/userFollowed.js"; //importamos el store de usuarios seguidos
    import getUsers from "@/data/randomUser.js"; //importamos la función que nos devuelve los usuarios

    export const followedListAux = userFollowed(); //creamos una instancia del store de usuarios seguidos

    export const users = ref([]); //creamos una referencia reactiva para los usuarios
    export const usersAux = ref([]); //creamos una referencia reactiva para los usuarios filtrados
    export const loading = ref(true); //creamos una referencia reactiva para el estado de carga, por defecto está en true

    export const fetchUsers = async () => { //función asíncrona para obtener los usuarios
      users.value = await getUsers(); //obtenemos los usuarios y los guardamos en la referencia reactiva
      usersAux.value = users.value; //guardamos los usuarios en la referencia reactiva de usuarios filtrados
      loading.value = false; //cambiamos el estado de carga a false
      followedListAux.followedList = [...users.value]; //añadimos todos los usuarios a la lista de seguidos
    }

    export const searchByFilter = (filter) =>{ //función para buscar usuarios por nombre
      usersAux.value = users.value.filter(user => user.name.first.toUpperCase().includes(filter.toUpperCase())); //filtramos los usuarios por nombre
    }
