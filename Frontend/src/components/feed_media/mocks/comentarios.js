export const comentarios = [
    {
        id: 1,
        user_id: 1,
        post_id: 1,
        content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed leo molestie, pellentesque leo eget, tristique velit. Integer eget libero metus. Donec vulputate mauris a rhoncus hendrerit. Suspendisse efficitur odio vitae elit condimentum, sed mattis massa tempor. Donec quam libero, eleifend ac dui non, malesuada tincidunt eros. Aliquam aliquam scelerisque nibh, vel finibus enim eleifend vel. Duis nec interdum arcu, id lacinia magna. Nullam faucibus consequat dictum.        ',
        active: true
    },
    {
        id: 2,
        user_id: 1,
        post_id: 3,
        content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed leo molestie, pellentesque leo eget, tristique velit. Integer eget libero metus. Donec vulputate mauris a rhoncus hendrerit. Suspendisse efficitur odio vitae elit condimentum, sed mattis massa tempor. Donec quam libero, eleifend ac dui non, malesuada tincidunt eros. Aliquam aliquam scelerisque nibh, vel finibus enim eleifend vel. Duis nec interdum arcu, id lacinia magna. Nullam faucibus consequat dictum.        ',
        active: true
    },
    {
        id: 3,
        user_id: 2,
        post_id: 1,
        content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed leo molestie, pellentesque leo eget, tristique velit. Integer eget libero metus. Donec vulputate mauris a rhoncus hendrerit. Suspendisse efficitur odio vitae elit condimentum, sed mattis massa tempor. Donec quam libero, eleifend ac dui non, malesuada tincidunt eros. Aliquam aliquam scelerisque nibh, vel finibus enim eleifend vel. Duis nec interdum arcu, id lacinia magna. Nullam faucibus consequat dictum.        ',
        active: true
    },
    {
        id: 4,
        user_id: 3,
        post_id: 1,
        content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed leo molestie, pellentesque leo eget, tristique velit. Integer eget libero metus. Donec vulputate mauris a rhoncus hendrerit. Suspendisse efficitur odio vitae elit condimentum, sed mattis massa tempor. Donec quam libero, eleifend ac dui non, malesuada tincidunt eros. Aliquam aliquam scelerisque nibh, vel finibus enim eleifend vel. Duis nec interdum arcu, id lacinia magna. Nullam faucibus consequat dictum.        ',
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