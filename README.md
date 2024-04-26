Proyecto final 2ºDAW *(Desarrollo de aplicaciones web)*

# Introduccion

La aplicacion propuesta era una web para fomentar el comercio local, con posibilidad de ver eventos y publicaciones de comercios e interactuar con ellos, seguir comercios y marcarlos como favoritos, ver puntos de fidelidad con un comercio, recibir notificaciones, dejar reseñas en comercios, comentarios en eventos y publicaciones.

La aplicacion consistia en dos partes, una api servida por laravel y un cliente en vue que consume dicha api.

Se realizo un diseño en Figma de las vistas del proyecto ademas de hacer una guia de estilos.

Se realizo un diseño de la BBDD previa a su programacion. Se puede ver mas en [dbdocs.io](https://dbdocs.io/aronmero/Bindify)

El plazo de realizacion del proyecto incluyendo fase de diseño visual y BBDD, prorgamacion del cliente y el servidor, ademas de documentacion y presentacion con defensa del proyecto fue de **4 de Marzo de 2024 a 15 de Marzo de 2024** 

# Tecnologia utilizada

Para el servidor se utiliza php con [laravel](https://laravel.com/) y su documentacion en [Swagger](https://swagger.io/)

Para el cliente [vue](https://vuejs.org/) con [Pinia](https://pinia.vuejs.org/), [Router](https://router.vuejs.org/), [tailwind](https://tailwindcss.com/) y [Sass](https://sass-lang.com/), como intermediario de api entre el cliente y el servidor se utilizo [Insomnia](https://insomnia.rest/) y [Postman](https://www.postman.com/). 

Las [peticiones en Insomnia](PeticionesAPI.json) se encuentran en un archivo json.

# Equipo

[aronmero](https://github.com/aronmero) - Project manager, programador y encargado del **Frontend**

[da25ni08](https://github.com/da25ni08) - Project manager, programador y encargado del **Backend**

[RevanHUB](https://github.com/RevanHUB) - Programador **Frontend**

[AntonioJPL](https://github.com/AntonioJPL) - Programador **Frontend**

[RonaldGutierrezMartin](https://github.com/RonaldGutierrezMartin) - Programador **Frontend**

[amanso23](https://github.com/amanso23) - Programador **Frontend**
 
[DomingoB](https://github.com/DomingoB) - Programador **Frontend**

[RengiChris](https://github.com/RengiChris) - Programador **Backend**

[JaviXhu](https://github.com/JaviXhu) - Programador **Backend**

[Arturo407LP](https://github.com/Arturo407LP) - Programador **Backend**

# Features de la ultima version

- Login
- Registro particular y comercio
- Home con publicaciones y modal de comentarios
- Evento y publicacion individual
- Comentarios para publicaciones y eventos
- Notificaciones
- Busqueda de comercios, por categorias, nombre y hashtag
- Particular
    - Fidelidad
    - Seguidos y favoritos
- Comercio
    - Publicacion
    - Evento
    - Reseñas
- Ayuntamiento
    - Publicacion 
    - Evento
