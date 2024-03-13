/**
 * Guarda los favoritos en variable localStorage
 * @author David
 * @returns 
 */
export const obtener_favoritos = () => {
    let favoritos = localStorage.getItem("favoritos");

    if(favoritos != null) {
        return favoritos
    } else {
        localStorage.setItem('favoritos', '[]');
        favoritos = JSON.parse(localStorage.getItem("favoritos"));
    }
    return favoritos
}

export const aniadir_favorito = (item) => {
    const favoritos = JSON.parse(obtener_favoritos());
    
    if(favoritos.indexOf(item) == -1) {
        favoritos.push(item);
    } else {
        favoritos.splice(favoritos.indexOf(item), 1);
    }
     // guardamos los cambios
     localStorage.setItem("favoritos", JSON.stringify(favoritos));
}

export const borrar_favorito = (item) => {
    const favoritos = JSON.parse(obtener_favoritos());
    // borramos el favorito
    favoritos.splice(favoritos.indexOf(item), 1);
    // guardamos los cambios
    localStorage.setItem("favoritos", favoritos);

}

export const en_favoritos = (item) => {
    const favoritos = JSON.parse(obtener_favoritos());
    return favoritos.indexOf(item) != -1;
}

export const guardar_en_session = (array) => {
    localStorage.setItem('favoritos', array);
}

export const purgarFavoritos = () => {
    localStorage.setItem('favoritos', '[]');
}