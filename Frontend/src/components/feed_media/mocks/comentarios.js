export const comentarios = [
    {
        id: 1,
        user_id: 1,
        post_id: 1,
        content: 'Ejemplo de comentario uno en post 1',
        active: true
    },
    {
        id: 2,
        user_id: 1,
        post_id: 3,
        content: 'Ejemplo de comentario en post 3',
        active: true
    },
    {
        id: 3,
        user_id: 2,
        post_id: 1,
        content: 'Ejemplo de comentario dos en post 1',
        active: true
    },
    {
        id: 4,
        user_id: 3,
        post_id: 1,
        content: 'Ejemplo de comentario tres en post 1',
        active: true
    },

];


export const comentarios_por_post = (post_id) => {
    let comentarios_list = []
    comentarios.forEach(comentario => {
        if(comentario.post_id == post_id) comentarios_list.push(comentario);
    })
    console.log(comentarios_list)
    return comentarios_list;
}

export const agregar_comentario = (post_id, usuario_id, content) => {
    comentarios.push({
        id: comentarios.length + 1,
        user_id: usuario_id,
        post_id: post_id,
        content: content,
        active: true
    })
}