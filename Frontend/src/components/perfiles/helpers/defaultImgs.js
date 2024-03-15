export const  setDefaultImgs = (objeto) =>{
    
    if(Array.isArray(objeto)){
        objeto.forEach(elemento => {
            if(elemento.banner!= undefined && elemento.banner=="default"){
                elemento.banner = "/img/placeholderBanner.webp"
              }
              if(elemento.avatar!= undefined  && elemento.avatar=="default"){
                elemento.avatar = "/img/placeholderPerfil.webp"
              }
              if(elemento.avatarUsuario!= undefined  && elemento.avatarUsuario=="default"){
                elemento.avatarUsuario = "/img/placeholderPerfil.webp"
              }
              if(elemento.image!= undefined  && elemento.image=="default"){
                elemento.image = "/img/placeholderPerfil.webp"
              }
        });
    }
    if(objeto.banner!= undefined && objeto.banner=="default"){
      objeto.banner = "/img/placeholderBanner.webp"
    }
    if(objeto.avatar!= undefined && objeto.avatar=="default"){
      objeto.avatar = "/img/placeholderPerfil.webp"
    }
    if(objeto.image!= undefined  && objeto.image=="default"){
      objeto.image = "/img/placeholderPerfil.webp"
    }
    return objeto
  }