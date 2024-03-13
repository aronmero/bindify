export const  setDefaultImgs = (objeto) =>{
    console.log(Array.isArray(objeto)) 
    // console.log(objeto[0].avatarUsuario)
    if(Array.isArray(objeto)){
        objeto.forEach(elemento => {
            if(elemento.banner!= undefined && elemento.banner=="default"){
                elemento.banner = "/img/placeholderPerfil.webp"
              }
              if(elemento.avatar!= undefined  && elemento.avatar=="default"){
                elemento.avatar = "/img/placeholderBanner.webp"
              }
              if(elemento.avatarUsuario!= undefined  && elemento.avatarUsuario=="default"){
                elemento.avatarUsuario = "/img/placeholderBanner.webp"
              }
        });
    }
    if(objeto.banner!= undefined && objeto.banner=="default"){
      objeto.banner = "/img/placeholderPerfil.webp"
    }
    if(objeto.avatar!= undefined && objeto.avatar=="default"){
      objeto.avatar = "/img/placeholderBanner.webp"
    }
    return objeto
  }